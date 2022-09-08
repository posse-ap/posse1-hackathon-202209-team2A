<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$all_users = $crud -> get_all_user();
$before_3days_events = $crud -> before_3days_event();

$to = "";
foreach($all_users as $all_user) {
  $to .= $all_user['email'] . ",";
};
foreach($before_3days_events as $before_3days_event) {
  $event = $before_3days_event['name'];
  $detail = $before_3days_event['detail'];
  $start_at = $before_3days_event['start_at'];
  $end_at = $before_3days_event['end_at'];
  $mail -> send_remind_mail($to,$event,$detail,$start_at,$end_at);
};
