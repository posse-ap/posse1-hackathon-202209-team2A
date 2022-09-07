<?php


namespace cruds;


class Admin
{
    protected $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function get_user($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM admins WHERE admins.email=:email');
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create_user($username, $email, $password)
    {
        $hashed_password = sha1($password);
        $stmt = $this->db->prepare("INSERT INTO users
        (email, hashed_password, username)
        VALUES
        (:email, :hashed_password, :username)");
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->bindValue(':hashed_password', $hashed_password, \PDO::PARAM_STR);
        $stmt->bindValue(':username', $username, \PDO::PARAM_STR);
        return $stmt->execute();
    }
}
