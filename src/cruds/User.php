<?php


namespace cruds;

use PDO;

class User
{
    protected $db;
    public function __construct(PDO $db)
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
        $num = $stmt->rowCount();

        if ($num > 0) {
            $events = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['attendance_users'] = $this->read_attendances($row['event_id']);
                array_push($events, $row);
            }
            return $events;
        }
    }

    public function read_event($event_id, $user_id)
    {
        $stmt = $this->db->prepare("SELECT events.id id, events.name name, events.start_at start_at, events.end_at end_at,
        event_attendance.is_attendance is_attendance,
        count(event_attendance.id) total_participants FROM events
        INNER JOIN event_attendance ON events.id = event_attendance.event_id
        where event_attendance.event_id = :event_id AND
        event_attendance.user_id = :user_id
        GROUP BY event_attendance.is_attendance");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch();
        $row['attendance_users'] = $this->read_attendances($row['event_id']);
        return $row;
    }

    public function get_user($email)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE users.email=:email');
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
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
        AND event_attendance.is_attendance=1");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function read_attendance_events($user_id, $is_attendance)
    {
        $stmt = $this->db->prepare("SELECT
        events.id,
        events.name,
        events.start_at,
        events.end_at
        FROM events
        INNER JOIN event_attendance ON events.id = event_attendance.event_id
        INNER JOIN users ON users.id = event_attendance.user_id
        where end_at > now()
        and users.id = :user_id
        and event_attendance.is_attendance = :is_attendance
        ORDER BY start_at
        ");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':is_attendance', $is_attendance, PDO::PARAM_INT);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $events = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['attendance_users'] = $this->read_attendances($row['event_id']);
                array_push($events, $row);
            }
            return $events;
        }
        return array();
    }
    public function read_unanswered_events($user_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM events WHERE id NOT IN(
        SELECT event_id FROM event_attendance
        WHERE user_id = :user_id)
        and end_at > now()
        ");
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $num = $stmt->rowCount();

        if ($num > 0) {
            $events = array();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $row['attendance_users'] = $this->read_attendances($row['event_id']);
                array_push($events, $row);
            }
            return $events;
        }
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

    private function add_attendance($event_id, $user_id, $is_attendance)
    {
        $stmt = $this->db->prepare("INSERT INTO event_attendance SET
        event_id = :event_id,
        user_id = :user_id,
        is_attendance = :is_attendance");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':is_attendance', $is_attendance, PDO::PARAM_INT);
        return $stmt->execute();
    }

    private function update_attendance($event_id, $user_id, $is_attendance)
    {
        $stmt = $this->db->prepare("UPDATE event_attendance SET
        is_attendance = :is_attendance
        WHERE event_id = :event_id
        AND user_id = :user_id");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->bindValue(':is_attendance', $is_attendance, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function handle_attendance($event_id, $user_id, $is_attendance)
    {
        $stmt = $this->db->prepare("SELECT * FROM event_attendance
        WHERE event_id = :event_id
        AND user_id = :user_id");
        $stmt->bindValue(':event_id', $event_id, PDO::PARAM_INT);
        $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        $num = $stmt->rowCount();
        if ($num > 0) {
            return $this->update_attendance($event_id, $user_id, $is_attendance);
        } else {
            return $this->add_attendance($event_id, $user_id, $is_attendance);
        }
    }

    public function get_user_for_github($oauth_uid)
    {
        $stmt = $this->db->prepare('SELECT * FROM users WHERE oauth_uid = :oauth_uid');

        $stmt->bindValue(':oauth_uid', $oauth_uid, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function add_user_from_github($username, $email, $oauth_uid)
    {
        $stmt = $this->db->prepare("INSERT INTO users (username, email, oauth_uid) VALUES (:username, :email, :oauth_uid)");
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':oauth_uid', $oauth_uid, PDO::PARAM_STR);
        $stmt->execute();
        return $this->get_user_for_github($oauth_uid);
    }
}
