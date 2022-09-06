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
        where end_at > now() GROUP BY events.id");
        $events = $stmt->fetchAll();
        return $events;
    }
}
