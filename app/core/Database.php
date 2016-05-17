<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 17:00
 */
class Database extends PDO{

    public function __construct(){
        parent::__construct('mysql:host=;dbname=', '', '');
    }
}