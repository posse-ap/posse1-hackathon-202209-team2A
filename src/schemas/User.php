<?php


namespace schemas;


class User
{
    protected $email;
    protected $password;
    protected $username;
    public function __construct(
        $email,
        $password,
        $username) {
            $this->email = $email;
            $this->password = $password;
            $this->username = $username;
        }

    public function username() {
        return $this->username;
    }
    public function email() {
        return $this->email;
    }

    public function hashed_password() {
        return sha1($this->password);
    }
}
