<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 15:52
 */
class Controller
{

    public function model($model)
    {
        $model .= 'Model';
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    public function view($view, $data = [])
    {
        require_once '../app/views/' . $view . '.php';
        $this->close();
    }

    public function menu()
    {
        if(!isset($_GET['ajax'])) {
            if (isset($_SESSION['user'])) {
                $user = $this->model('Account');
                $user = $user->findID($_SESSION['user']);
                if($user){
                    $this->view("home/menu", array('user' => $user));
                    echo '<div id="content" class="col-sm-9">';
                }else{
                    $this->view("home/menu");
                    echo '<div id="content" class="col-sm-9">';
                }
            } else {
                $this->view("home/menu");
                echo '<div id="content" class="col-sm-9">';
            }
        }
    }

    public function close(){
        echo '</div>';
    }
}

?>