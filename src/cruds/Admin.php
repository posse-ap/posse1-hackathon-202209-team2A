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

    public function create_event($name, $start_at, $end_at, $detail=null)
    {
        // TODO format input datetime to insert record
        $start_at = Utils::convert_datetime($start_at);
        $end_at = Utils::convert_datetime($end_at);
        $stmt = $this->db->prepare('INSERT INTO events (name, start_at, end_at, detail) VALUES (:name, :start_at, :end_at, :detail)');
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->bindValue(':start_at', $start_at, \PDO::PARAM_STR);
        $stmt->bindValue(':end_at', $end_at, \PDO::PARAM_STR);
        $stmt->bindValue(':detail', $detail, \PDO::PARAM_STR);
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

    public function get_events()
    {
        $stmt = $this->db->query("SELECT * FROM events");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function get_event($event_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM events
        WHERE id = :id");
        $stmt->bindValue(':id', $event_id, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function update_event($event_id, $name, $start_at, $end_at, $detail)
    {
        $start_at = Utils::convert_datetime($start_at);
        $end_at = Utils::convert_datetime($end_at);
        $stmt = $this->db->prepare("UPDATE events
        SET name = :name,
        start_at = :start_at,
        end_at = :end_at,
        detail = :detail
        WHERE id = :id");
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->bindValue(':start_at', $start_at, \PDO::PARAM_STR);
        $stmt->bindValue(':end_at', $end_at, \PDO::PARAM_STR);
        $stmt->bindValue(':detail', $detail, \PDO::PARAM_STR);
        $stmt->bindValue(':id', $event_id, \PDO::PARAM_STR);
        return $stmt->execute();
    }
}
