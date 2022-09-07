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

    public function read_attendance_events($user_id,$is_attendance)
    {
        $stmt = $this->db->prepare("SELECT * FROM events 
        INNER JOIN event_attendance ON events.id = event_attendance.event_id
        INNER JOIN users ON users.id = event_attendance.user_id
        where end_at > now()
        and users.id = :user_id
        and is_attendance = :is_attendance
        ");       
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':is_attendance', $is_attendance, PDO::PARAM_BOOL);
        $stmt->execute();
        $attendant_events = $stmt->fetchAll();
        return $attendant_events;
    }

    public function read_unanswered_events($user_id)
    {
        $stmt = $this->db->prepare
        ("SELECT * FROM events WHERE id NOT IN(
        SELECT event_id FROM event_attendance 
        WHERE user_id = 1)
        ");       
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $unanswered_events = $stmt->fetchAll();
        return $unanswered_events;
    }
}
