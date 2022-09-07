<?php


namespace cruds;
use modules\Utils;


class Admin
{
    protected $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function create_event($name, $start_at, $end_at)
    {
        // TODO format input datetime to insert record
        $start_at = Utils::convert_datetime($start_at);
        $end_at = Utils::convert_datetime($end_at);
        $stmt = $this->db->prepare('INSERT INTO events (name, start_at, end_at) VALUES (:name, :start_at, :end_at)');
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->bindValue(':start_at', $start_at, \PDO::PARAM_STR);
        $stmt->bindValue(':end_at', $end_at, \PDO::PARAM_STR);
        return $stmt->execute();
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
