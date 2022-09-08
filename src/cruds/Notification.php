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
    // $stmt -> bindValue();
    $stmt -> execute();
    return $stmt -> fetchAll();
  }
}
