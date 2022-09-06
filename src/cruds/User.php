<?php


namespace cruds;

use PDO;

class User
{
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function read_events()
    {

        $stmt = $this->db->query("SELECT events.id, events.name, events.start_at, events.end_at, 
        count(event_attendance.id) AS total_participants FROM events 
        LEFT JOIN event_attendance ON events.id = event_attendance.event_id 
        where end_at > now() GROUP BY events.id
        ORDER BY start_at");
        $events = $stmt->fetchAll();
        return $events;
    }
    public function get_user($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE users.email=:email');
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }
}
