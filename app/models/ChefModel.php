<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 17:23
 */
class ChefModel extends Model
{

    public function search($name){
        $stmt = $this->db->prepare("SELECT id, CONCAT(`first_name`, ' ', `last_name`) as name FROM `Chef` WHERE first_name like :name");
        $stmt->execute(array('name' => $name . '%'));
        return $stmt->fetchAll();
    }

}