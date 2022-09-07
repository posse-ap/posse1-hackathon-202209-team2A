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
}
