<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 15:59
 */
class Home extends Controller
{

    public function index(){
        $this->menu();
        $this->view('home/index');
    }

    public function ajaxTest(){
        $this->menu();
        $this->view('home/ajaxTest');
    }

}