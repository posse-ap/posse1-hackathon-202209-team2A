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
            $_SESSION[$this->session]['id'] = $user['id'];
            return true;
        }else{
            return false;
        }
    }

    public function validate()
    {
        if(!isset($_SESSION[$this->session]['id'])){
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

    public function reset_password($email, $current_password, $new_password)
    {
        $user = $this->cruds->get_user($email);
        $current_user_password = $user['hashed_password'];
        if (sha1($current_password) === $current_user_password){
            return $this->cruds->update_user_password($email, $new_password);
        }
    }
}
