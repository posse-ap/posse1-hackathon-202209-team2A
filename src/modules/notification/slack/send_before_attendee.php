<?php
require_once('../../../config.php');
require_once('../../../cruds/Notification.php');
require_once('../../../cruds/domains/Slack.php');

use cruds\domains\Slack;
use cruds\Notification;

$crud = new Notification($db);
$attendees = $crud->get_users_and_event_info_before_day();

$events = array();

foreach ($attendees as $attendee) {
    $email = $attendee['username'];
    $event_name = $attendee['event_name'];
    $detail = $attendee['detail'];
    $start_at = $attendee['start_at'];
    $end_at = $attendee['end_at'];

    Slack::send_events_remind($email, $event_name, $detail, $start_at, $end_at);
};
