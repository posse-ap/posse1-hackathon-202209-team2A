<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$all_users = $crud -> get_all_user();
$attendees = $crud->get_unanswerd_3days_before_event();


// var_dump($before_attendance_event);
$to = "";
foreach($all_users as $all_user) {
  $to .= $all_user['email'] . ",";
};
foreach($attendees as $attendee) {
  $event = $attendee['email'];
  $detail = $attendee['detail'];
  $start_at = $attendee['start_at'];
  $end_at = $attendee['end_at'];
  $mail -> send_remind_mail($to,$event,$detail,$start_at,$end_at);
};
