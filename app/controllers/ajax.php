<?php
/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-17
 * Time: 20:18
 */
class ajax extends Controller
{

    public function index(){

    }

    public function checkUsername($user){
        if($user = $this->model('Account')->find($user)){
           echo 'has-error';
        }else{
            echo 'has-success';
        }
    }

    public function lookupChef($chef){
        echo '<option value="-1">No chef</option>';
        echo '<option value="-2">Textbox</option>';
        if ($chefs = $this->model('Chef')->search($chef)){
            foreach ($chefs as $oneChef){
                echo '<option value="' . $oneChef["id"] . '">' . $oneChef["name"] . '</option>';
            }
        }
    }

}