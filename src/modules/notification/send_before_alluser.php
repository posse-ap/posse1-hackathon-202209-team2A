<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$before_attendance_users = $crud -> before_attendance_user();
$before_attendance_event = $crud -> before_attendance_event();
// var_dump($before_attendance_event);
$to = "";
foreach($before_attendance_users as $before_attendance_user) {
  $to .= $before_attendance_user['email'] . ",";
};
echo $to;
$mail -> send_mail($to);