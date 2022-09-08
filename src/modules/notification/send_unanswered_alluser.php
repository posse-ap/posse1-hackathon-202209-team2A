<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$get_all_users = $crud -> get_all_user();
$before_unanswered_events = $crud -> before_unanswered_event();

$to = "";
foreach($get_all_users as $get_all_user) {
  $to .= $get_all_user['email'] . ",";
};
foreach($before_unanswered_events as $before_unanswered_event) {
  $event = $before_unanswered_event['name'];
  $detail = $before_unanswered_event['detail'];
  $start_at = $before_unanswered_event['start_at'];
  $end_at = $before_unanswered_event['end_at'];
  $mail -> send_remind_mail($to,$event,$detail,$start_at,$end_at);
};