<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 17:23
 */
class RecipeModel extends Model{

    public function __construct(){
        parent::__construct();
    }

    public function create($name, $description, $user, $language, $steps, $ingredients){
        $stmt = $this->db->prepare("INSERT INTO Recipe(name, description, user_id, language_id) VALUES(:name, :description, :user, :language)");
        $stmt->execute(array('name' => $name, 'description' => $description, 'user' => $user, 'language' => $language));
        $id = $this->db->lastInsertId();
        $stmt = $this->db->prepare("INSERT INTO Recipe_Step(number, step, recipe_id) VALUES(:number, :step, :recipe)");
        $stepID = array();
        foreach ($steps as $step){
            $stmt->execute(array('number' => $step['number'], 'step' => $step['step'], 'recipe' => $id));
            $stepID[$step['number']] = $this->db->lastInsertId();
        }
        $stmt = $this->db->prepare("INSERT INTO Ingredient_Step(amount, ingredient_id, measurement_id, step_id) VALUES(:amount, :ingredient, :measurement, :step)");
        foreach ($ingredients as $ingredient){
            if($ingredient['amount'] > 0) {
                $stmt->execute(array('amount' => $ingredient['amount'], 'ingredient' => $ingredient['ingredient'], 'measurement' => $ingredient['measurement'], 'step' => $stepID[$ingredient['number']]));
            }
        }
    }

    public function getList($page, $order = "", $IPP = 15){
        $full = $page * $IPP;
        $sql = "SELECT Recipe.id as id, Recipe.name as name, Recipe.uploaded as uploaded, user_id as user, Chef.id as Chef, CONCAT(Chef.first_name, ' ', Chef.last_name) as chef_name, language_id as language, (SELECT value FROM Recipe_Meta WHERE Recipe_Meta.recipe_id = Recipe.id AND Recipe_Meta.type_id = 5) as time, (SELECT value FROM Media WHERE Media.recipe_id = Recipe.id AND Media.type_id = 1) as thumbnail, rating_per_recipe.Score as score FROM Recipe LEFT JOIN rating_per_recipe ON Recipe.id = rating_per_recipe.id LEFT JOIN Chef ON Recipe.chef_id = Chef.id $order LIMIT $full, $IPP";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        $list = $stmt->fetchAll();
        return $list;
    }

    public function steps($id){
        if ($id > 0){
            $stmt = $this->db->prepare("SELECT number, step, GROUP_CONCAT(Ingredient.name SEPARATOR ' | ') as ingredients FROM Recipe_Step LEFT JOIN Ingredient ON Recipe_Step.id = Ingredient.recipe_id WHERE Recipe_Step.recipe_id = :id GROUP BY number ORDER BY number ASC");
            $stmt->execute(array('id' => $id));
            $steps = $stmt->fetchAll();
            return $steps;
        }
    }

    public function delete($id, $accountModel){
        if($id > 0){
            $account = $accountModel->find($_SESSION['user']);
            if($account['permission'] >= 15 || $this->getInfo($id)['user_id'] == $account['id']){
                $stmt = $this->db->prepare("DELETE FROM Recipe WHERE id = :id");
                $stmt->execute(array('id' => $id));

                $stmt = $this->db->prepare("SELECT id FROM Recipe_Step WHERE recipe_id = :id");
                $stmt->execute(array('id' => $id));
                $ids = array();
                while ($row = $stmt->fetch()){
                    if(array_key_exists($row['id'], $ids))
                        array_push($ids, $row['id']);
                }

                $stmt = $this->db->prepare("DELETE FROM Recipe_Step WHERE recipe_id = :id");
                $stmt->execute(array('id' => $id));

                foreach ($ids as $stepID){
                    $stmt = $this->db->prepare("DELETE FROM Ingredient_Step WHERE step_id = :id");
                    $stmt->execute(array('id' => $stepID));
                }
            }
        }
    }

    public function getInfo($id){
        if($id > 0){
            $stmt = $this->db->prepare("SELECT *FROM Recipe WHERE id = :id");
            $stmt->execute(array('id' => $id));
            return $stmt->fetch();
        }
    }

    public function comment($id, $user, $comment){
        if ($id > 0 && $user > 0 && strlen($comment) > 0){

        }
    }

    public function rate($id, $user, $rating){
        if($rating > 0 && $rating <= 5){
            $stmt = $this->db->prepare("SELECT *FROM Rating WHERE user_id = :user AND recipe_id = :recipe");
            $stmt->execute(array('user' => $user, 'recipe' => $id));
            if($row = $stmt->fetch()){
                $stmt = $this->db->prepare("UPDATE Rating score = :score WHERE id = :id");
                $stmt->execute(array('score' => $rating, 'id' => $row['id']));
            }else{
                $stmt = $this->db->prepare("INSERT INTO Rating(score, user_id, recipe_id) VALUES(:score, :user, :recipe)");
                $stmt->execute(array('score' => $rating, 'user' => $user, 'recipe' => $id));
            }
        }
    }

}