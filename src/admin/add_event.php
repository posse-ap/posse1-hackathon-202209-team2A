<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

use cruds\Admin as Cruds;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $event_name = $_REQUEST['event_name'];
    $start_at = $_REQUEST['start_at'];
    $end_at = $_REQUEST['end_at'];
    $detail = $_REQUEST['detail'];
    $error = array();
    if (!isset($event_name)) {
        $error['event_name'] = 'blank';
    }
    if (!isset($start_at)) {
        $error['start_at'] = 'blank';
    }
    if (!isset($end_at)) {
        $error['end_at'] = 'blank';
    }
    if (empty($error)) {
        $cruds = new Cruds($db);
        if ($cruds->create_event($event_name, $start_at, $end_at, $detail)) {
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="" method="POST">
        <?php if ($error['event_name'] === 'blank') : ?>
            <p>イベント名を入力してください</p>
        <?php endif ?>
        <label>
            <input type="text" name="event_name" placeholder="イベント名">
        </label>
        <?php if ($error['start_at'] === 'blank') : ?>
            <p>開始日時を入力してください</p>
        <?php endif ?>
        <label>
            <input type="datetime-local" name='start_at'>
        </label>
        <?php if ($error['end_at'] === 'blank') : ?>
            <p>終了日時を入力してください</p>
        <?php endif ?>
        <label>
            <input type="datetime-local" name="end_at">
        </label>
        <label>
            <input type="text" name="detail">
        </label>
        <input type="submit" value="登録">
    </form>
</body>

</html>
