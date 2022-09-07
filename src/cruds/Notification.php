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

  public function before_attendance_user() {
    $stmt = $this->db ->prepare("SELECT email FROM users");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }

  public function before_attendance_event() {
    $stmt = $this->db ->prepare("SELECT name,details,start_at FROM events WHERE start_at -1=now()");
    $stmt -> execute();
    return $stmt -> fetchAll();
  }
}