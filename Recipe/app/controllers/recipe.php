<?php
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-04
 * Time: 14:50
 */
class recipe extends Controller{

    public function index($page = 0){
        $this->menu();
        $recipe = $this->model('Recipe')->getList($page);

        $this->view('recipe/index', ['list' => $recipe]);
    }

    public function open($id){
        $this->menu();
        $steps = $this->model('Recipe')->steps($id);

        $this->view('recipe/recipe', ['steps' => $steps]);
    }

    public function latest($page = 0){
        $this->menu();
        $recipe = $this->model('Recipe')->getList($page, "Order BY uploaded DESC");

        $this->view('recipe/index', ['list' => $recipe]);
    }

    public function getTop($page = 0){
        $this->menu();
        $recipe = $this->model('Recipe')->getList($page, "ORDER BY score DESC");

        $this->view('recipe/index', ['list' => $recipe]);
    }

    public function ingredients(){
        $this->menu();
        $this->view('recipe/index');
    }

}