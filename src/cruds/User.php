<?php


namespace cruds;

use PDO;

class User
{
    protected $db;
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }

    public function read_events()
    {

        $stmt = $this->db->query("SELECT events.id event_id, events.name, events.start_at, events.end_at,
        count(event_attendance.id) AS total_participants FROM events
        LEFT JOIN event_attendance ON events.id = event_attendance.event_id
        where end_at > now() GROUP BY events.id
        ORDER BY start_at");
        $num = $stmt->rowCount();

        if ($num > 0) {
            $events = array();
            while ($row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
                $row['attendance_users'] = $this->read_attendances($row['event_id']);
                array_push($events, $row);
            }
            return $events;
        }
    }
    public function get_user($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE users.email=:email');
        $stmt->bindValue(':email', $email, \PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    private function read_attendances($event_id)
    {
        $stmt = $this->db->prepare("SELECT
        event_attendance.is_attendance,
        user.username username
        from event_attendance
        INNER JOIN events as event
            ON event_attendance.event_id = event.id
        INNER JOIN users as user
            ON event_attendance.user_id = user.id
        WHERE event.id = :event_id
        AND event_attendance.is_attendance=TRUE");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
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

    public function update_user_password($email, $new_password)
    {
        $stmt = $this->db->prepare('UPDATE users SET hashed_password = :hashed_password
        WHERE email = :email');
        $hashed_password = sha1($new_password);
        $stmt->bindValue(':hashed_password', $hashed_password, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
