<?php
require_once('../../cruds/Notification.php');
require_once('../../cruds/domains/Email.php');

use cruds\domains\Email;
use cruds\Notification;

$mail = new Email;
$crud = new Notification($db);
$attendees = $crud -> get_attendee();
$before_attendance_events = $crud -> before_attendance_event();
$tomrrow_events = $crud -> tomorrow_event();
$to = "";

$before_attendee = array();
// for($i = 0;$i <=$tomrrow_events[0]['count(*)'];$i++){
//     $to .= $get_attendees['email'] . ",";
// };
foreach ($attendees as $attendee) {
  $event_name = $attendee['name'];
  $email = $attendee['email'];
  if(array_search($attendee['name'],$before_attendee)==False){
    $before_attendee[$event_name] = array();
    array_merge($before_attendee[$event_name],array($event_name=>$email));
  }else{
    array_merge($before_attendee[$event_name],array($event_name=>$email));
  }
};

// var_dump($before_attendee);
// print_r($before_attendee);

foreach($before_attendance_events as $before_attendance_event) {
  $event = $before_attendance_event['name'];
  $detail = $before_attendance_event['detail'];
  $start_at = $before_attendance_event['start_at'];
  $end_at = $before_attendance_event['end_at'];
  $mail -> send_mail($to,$event,$detail,$start_at,$end_at);
};

// print_r($get_attendee);
// print_r($tomrrow_events);
// echo $tomrrow_events[0]['count(*)'];