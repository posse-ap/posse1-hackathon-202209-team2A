<?php

namespace modules\auth;
use cruds\User as Cruds;

class User{
    
    public function __construct(\PDO $db)
    {
        $this->cruds = new Cruds($db);
    }

    public function login($email,$password)
    {
        $user = $this->cruds->get_user($email);
        $user_password = $user['hashed_password'];
        if(sha1($password) === $user_password){
            $_SESSION['user']['id'] = $user['id'];
            return true;
        }else{
            return false;
        }
    }
}