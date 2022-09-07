<?php


namespace modules\auth;


class Auth
{

    protected $cruds;
    protected $session;
    protected $address;

    public function login($email,$password)
    {
        $user = $this->cruds->get_user($email);
        $user_password = $user['hashed_password'];
        if(sha1($password) === $user_password){
            $this->session= $user['id'];
            return true;
        }else{
            return false;
        }
    }

    public function validate()
    {
        if(!isset($this->session)){
            header("Location: http://" . $_SERVER['HTTP_HOST'] . "/auth/login/" . $this->address);
            exit();
        }
    }

    public function logout()
    {
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: http://" . $_SERVER['HTTP_HOST'] . "/auth/login/" . $this->address);
        exit();
    }
}
