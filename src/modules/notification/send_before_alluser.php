<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$get_all_users = $crud -> get_all_user();
$before_attendance_events = $crud -> before_attendance_event();
// var_dump($before_attendance_event);
$to = "";
foreach($get_all_users as $get_all_user) {
  $to .= $get_all_user['email'] . ",";
};
foreach($before_attendance_events as $before_attendance_event) {
  $event = $before_attendance_event['name'];
  $detail = $before_attendance_event['detail'];
  $start_at = $before_attendance_event['start_at'];
  $end_at = $before_attendance_event['end_at'];
  $mail -> send_mail($to,$event,$detail,$start_at,$end_at);
};