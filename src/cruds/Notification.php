<?php

namespace cruds;

require_once('User.php');

class Notification
{
  protected $db;
  public function __construct(\PDO $db)
  {
    $this->db = $db;
  }

  public function get_all_user() {
    $stmt = $this->db ->prepare("SELECT email FROM users");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  public function before_attendance_event() {
    $stmt = $this->db ->prepare("SELECT name,detail,start_at,end_at FROM events WHERE DATE(start_at) = DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  public function get_attendee() {
    $stmt = $this->db ->prepare("SELECT name,email FROM users JOIN event_attendance on users.id = event_attendance.user_id
    JOIN events ON event_attendance.event_id = events.id WHERE is_attendance = true and DATE(start_at) = DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  //必要？
  public function tomorrow_event() {
    $stmt = $this->db ->prepare("SELECT event_id,count(*) FROM users JOIN event_attendance on users.id = event_attendance.user_id
    JOIN events ON event_attendance.event_id = events.id
    WHERE is_attendance = true and DATE(start_at) = DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)
    group by event_id");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  public function before_unanswered_event() {
    $stmt = $this->db ->prepare("SELECT name,detail,start_at,end_at FROM events WHERE DATE(start_at) = DATE_ADD(CURRENT_DATE,INTERVAL 3 DAY)");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  public function get_users_and_event_info_before_day()
  {
    $stmt = $this->db->query("SELECT users.email email, users.username username, events.name event_name,
    events.detail detail,
    events.start_at start_at,
    events.end_at end_at FROM users
    INNER JOIN event_attendance ON event_attendance.user_id = users.id
    INNER JOIN events ON events.id = event_attendance.event_id
    WHERE event_attendance.is_attendance = TRUE
    AND DATE(events.start_at) = DATE_ADD(CURRENT_DATE, INTERVAL 1 DAY)");
    return $stmt->fetchAll();
  }
}
