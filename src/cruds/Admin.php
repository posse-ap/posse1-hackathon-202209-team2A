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

    public function create_event($name, $start_at, $end_at, $detail = null)
    {
        // TODO format input datetime to insert record
        $start_at = Utils::convert_datetime($start_at);
        $end_at = Utils::convert_datetime($end_at);
        $dead_line = $start_at;
        $stmt = $this->db->prepare('INSERT INTO events (name, start_at, end_at, detail) VALUES (:name, :start_at, :end_at, :detail)');
        $stmt->bindValue(':name', $name, \PDO::PARAM_STR);
        $stmt->bindValue(':start_at', $start_at, \PDO::PARAM_STR);
        $stmt->bindValue(':end_at', $end_at, \PDO::PARAM_STR);
        $stmt->bindValue(':detail', $detail, \PDO::PARAM_STR);
        $success = $stmt->execute();

        $new_event_id = $this->db->lastInsertId();
        $user_ids = $this->get_user_ids();
        foreach($user_ids as $user_id) {
            $this->create_association_data($user_id['id'], $new_event_id);
        }
        return $success;
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
        $success = $stmt->execute();
        $new_user_id =  $this->db->lastInsertId();
        $event_ids = $this->get_event_ids();
        foreach($event_ids as $event_id) {
            $this->create_association_data($new_user_id, $event_id['id']);
        }
        return $success;
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

    private function create_association_data($user_id, $event_id)
    {
        $stmt = $this->db->prepare('INSERT INTO event_attendance (user_id, event_id) VALUES(:user_id, :event_id)');
        $stmt->bindValue(':user_id', $user_id, \PDO::PARAM_INT);
        $stmt->bindValue(':event_id', $event_id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function get_event_ids()
    {
        $stmt = $this->db->query('SELECT id FROM events');
        $stmt->execute();
        return $stmt->fetchAll();
    }

    private function get_user_ids()
    {
        $stmt = $this->db->query('SELECT id FROM users');
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
