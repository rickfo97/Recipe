<?php
include '../app/helper/class.upload.php';
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 17:23
 */
class RecipeModel extends Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function create()
    {
        if (isset($_POST['description'])) {
            $stmt = $this->db->prepare("INSERT INTO Recipe(name, description, user_id, language_id) VALUES (:name, :desc, :user, :language)");
            $stmt->execute(array('name' => $_POST['name'], 'desc' => $_POST['description'], 'user' => $_SESSION['user'], 'language' => 1));
        }
        $id = $this->db->lastInsertId();
        $stmt = $this->db->prepare("INSERT INTO Recipe_Step(number, step, recipe_id) VALUES (:number, :step, :recipe)");
        foreach ($_POST['step'] as $number => $step) {
            $stmt->execute(array('number' => ($number + 1), 'step' => $step, 'recipe' => $id));
        }
        $stmt = $this->db->prepare("INSERT INTO Ingredient(name, recipe_id) VALUES (:name, :recipe)");
        foreach ($_POST['ingredient'] as $ingredient) {
            $stmt->execute(array('name' => $ingredient, 'recipe' => $id));
        }
        if($_POST['chef-select'] == -2){
            $chef = explode(',', $_POST['chef']);
            $stmt = $this->db->prepare("INSERT INTO Chef(first_name, last_name) VALUES(:first, :last)");
            $stmt->execute(array('first' => $chef[0], 'last' => $chef[1]));
            $stmt = $this->db->prepare("UPDATE Recipe SET chef_id = :chef WHERE id = :id");
            $stmt->execute(array('chef' => $this->db->lastInsertId(), 'id' => $id));
        }elseif ($_POST['chef-select'] > 0){
            $stmt = $this->db->prepare("UPDATE Recipe SET chef_id = :chef WHERE id = :id");
            $stmt->execute(array('chef' => $_POST['chef-select'], 'id' => $id));
        }
        if (isset($_FILES['thumbnail'])) {
            $fileName = $this->saveImage($_FILES['thumbnail']);
            $stmt = $this->db->prepare("INSERT INTO Media(value, type_id, recipe_id) VALUES (:imagePath, :type_id, :recipe)");
            $stmt->execute(array('imagePath' => $fileName, 'type_id' => 1, 'recipe' => $id));
        }
        if(isset($_FILES['images'])){
            $files = array();
            foreach ($_FILES['images'] as $k => $l) {
                foreach ($l as $i => $v) {
                    if (!array_key_exists($i, $files))
                        $files[$i] = array();
                    $files[$i][$k] = $v;
                }
            }
            $stmt = $this->db->prepare("INSERT INTO Media(value, type_id, recipe_id) VALUES (:imagePath, :type_id, :recipe)");
            foreach ($files as $file){
                $fileName = $this->saveImage($file, "uploads/recipe/images/");
                $stmt->execute(array('imagePath' => $fileName, 'type_id' => 3, 'recipe' => $id));
            }
        }
        return $id;
    }

    public function getList($page, $order = "", $IPP = 15)
    {
        $full = $page * $IPP;
        $sql = "SELECT Recipe.id as id, Recipe.name as name, Recipe.uploaded as uploaded, user_id as user, Chef.id as Chef, CONCAT(Chef.first_name, ' ', Chef.last_name) as chef_name, language_id as language, (SELECT value FROM Recipe_Meta WHERE Recipe_Meta.recipe_id = Recipe.id AND Recipe_Meta.type_id = 5) as time, (SELECT value FROM Media WHERE Media.recipe_id = Recipe.id AND Media.type_id = 1) as thumbnail, rating_per_recipe.Score as score FROM Recipe LEFT JOIN rating_per_recipe ON Recipe.id = rating_per_recipe.id LEFT JOIN Chef ON Recipe.chef_id = Chef.id $order LIMIT $full, $IPP";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll();
        return $list;
    }

    public function steps($id)
    {
        if ($id > 0) {
            $stmt = $this->db->prepare("SELECT number, step, GROUP_CONCAT(Ingredient.name SEPARATOR ' | ') AS ingredients FROM Recipe_Step LEFT JOIN Ingredient ON Recipe_Step.recipe_id = Ingredient.recipe_id WHERE Recipe_Step.recipe_id = :id GROUP BY number ORDER BY number ASC");
            $stmt->execute(array('id' => $id));
            $steps = $stmt->fetchAll();
            return $steps;
        }
    }

    public function delete($id, $accountModel)
    {
        if ($id > 0) {
            $account = $accountModel->find($_SESSION['user']);
            if ($account['permission'] >= 15 || $this->getInfo($id)['user_id'] == $account['id']) {
                $stmt = $this->db->prepare("DELETE FROM Recipe WHERE id = :id");
                $stmt->execute(array('id' => $id));

                $stmt = $this->db->prepare("SELECT id FROM Recipe_Step WHERE recipe_id = :id");
                $stmt->execute(array('id' => $id));
                $ids = array();
                while ($row = $stmt->fetch()) {
                    if (array_key_exists($row['id'], $ids))
                        array_push($ids, $row['id']);
                }

                $stmt = $this->db->prepare("DELETE FROM Recipe_Step WHERE recipe_id = :id");
                $stmt->execute(array('id' => $id));

                foreach ($ids as $stepID) {
                    $stmt = $this->db->prepare("DELETE FROM Ingredient_Step WHERE step_id = :id");
                    $stmt->execute(array('id' => $stepID));
                }
            }
        }
    }

    public function getInfo($id)
    {
        if ($id > 0) {
            $stmt = $this->db->prepare("SELECT *FROM Recipe WHERE id = :id");
            $stmt->execute(array('id' => $id));
            return $stmt->fetch();
        }
    }

    public function comment($id, $user, $comment)
    {
        if ($id > 0 && $user > 0 && strlen($comment) > 0) {

        }
    }

    public function rate($id, $user, $rating)
    {
        if ($rating > 0 && $rating <= 5) {
            $stmt = $this->db->prepare("SELECT *FROM Rating WHERE user_id = :user AND recipe_id = :recipe");
            $stmt->execute(array('user' => $user, 'recipe' => $id));
            if ($row = $stmt->fetch()) {
                $stmt = $this->db->prepare("UPDATE Rating score = :score WHERE id = :id");
                $stmt->execute(array('score' => $rating, 'id' => $row['id']));
            } else {
                $stmt = $this->db->prepare("INSERT INTO Rating(score, user_id, recipe_id) VALUES(:score, :user, :recipe)");
                $stmt->execute(array('score' => $rating, 'user' => $user, 'recipe' => $id));
            }
        }
    }

    private function saveImage($image, $location = "uploads/recipe/thumbnail/"){
        $root = "/var/www/Recipe/public_html/";
        $file = new Upload($image);
        $uploadOk = 1;
        if ($file->uploaded) {
            if($file->file_src_name_ext != "jpg" && $file->file_src_name_ext != "png" && $file->file_src_name_ext != "jpeg" ) {
                echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }
            if($uploadOk == 1){
                $file->file_auto_rename = true;
                $file->image_resize = true;
                $file->image_x = 406;
                $file->image_y = 228;
                echo 'going process<br>';
                $file->Process($root . $location);
                if ($file->processed) {
                    $file->clean();
                    return '/' . $location . $file->file_dst_name;
                } else {
                    echo 'error : ' . $file->error;
                }
            }
        }
    }
}