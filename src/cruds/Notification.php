<?php

namespace cruds;

require_once('User.php');
use cruds\User;

class Notification
{
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
 
}