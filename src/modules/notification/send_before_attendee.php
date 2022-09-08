<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$attendees = $crud->get_users_and_event_info_before_day();


foreach ($attendees as $attendee) {
  $event_name = $attendee['event_name'];
  $email = $attendee['email'];
  $detail = $attendee['detail'];
  $start_at = $attendee['start_at'];
  $end_at = $attendee['end_at'];

  $mail->send_mail($email, $event_name, $detail, $start_at, $end_at);
};
