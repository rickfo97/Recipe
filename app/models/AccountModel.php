<?php

/**
 * Created by PhpStorm.
 * User: Rickardh
 * Date: 2016-05-03
 * Time: 16:38
 */
class AccountModel extends Model{

    public function __construct()
    {
        parent::__construct();
    }

    public function create(){
        $options = [
            'cost' => 10,
            'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
        ];
        $passhash = password_hash($_POST['password'], PASSWORD_BCRYPT, $options);
        $stmt = $this->db->prepare("INSERT INTO User(username, email, password) VALUES(:username,:email,:password)");
        $success = $stmt->execute(array('username' => $_POST['username'], 'email' => $_POST['email'], 'password' => $passhash));
        return $success;
    }

    public function find($name)
    {
        $stmt = $this->db->prepare("SELECT id, username, email, avatar, permission FROM User WHERE username = :name");
        $stmt->execute(array('name' => $name));
        if ($row = $stmt->fetch()) {
            return $row;
        }
        return false;
    }

    public function findID($id){
        $stmt = $this->db->prepare("SELECT id, username, email, avatar, permission FROM User WHERE id = :id");
        $stmt->execute(array('id' => $id));
        if ($row = $stmt->fetch()) {
            return $row;
        }
        return false;
    }

    public function run(){
        $stmt = $this->db->prepare("SELECT id, password FROM User WHERE username = :user");
        $stmt->execute(array(':user' => $_POST['username']));
        if($user = $stmt->fetch()){
            if(password_verify($_POST['password'], $user['password'])){
                return $user['id'];
            }
        }
        return false;
    }

    public function change($column, $oldValue, $newValue){
        switch ($column){
            case 'username':
                break;
            case 'password':
                break;
            case 'avatar':
                break;
            case 'email':
                break;
        }
    }
}