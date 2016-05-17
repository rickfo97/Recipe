<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 20:53
 */
class user extends Controller
{
    public function index($name = ''){
        $this->menu();
        if (strlen($name) > 0){
            $user = $this->model('Account');
            $user = $user->find($name);
            $this->view('user/index', ['user' => $user]);
        }else{
            $this->view('user/index');
        }
    }

    public function login(){
        $this->menu();
        $this->view('user/login');
    }

    public function register(){
        $this->menu();
        $this->view('user/register');
    }

    public function run(){
        if($id = $this->model('Account')->run()){
            $_SESSION['user'] = $id;
            header("Location:/");
        }else{
            $this->login();
        }
    }

    public function logout(){
        if(isset($_SESSION['user'])){
            $_SESSION = array();
            session_destroy();
        }
        header("Location:/");
    }

    public function create(){
        if($this->model('Account')->create()){
            echo 'Made Account';
        }else{
            echo 'Failed';
        }
    }

    public function profile(){
        $this->menu();
        $this->view('user/profile');
    }

}