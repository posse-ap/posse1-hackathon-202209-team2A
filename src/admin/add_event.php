<?php

if ($_SERVER['HTTP_METHOD'] === 'POST')
{
    $event_name = $_REQUEST['event_name'];
    $start_at = $_REQUEST['start_at'];
    $end_at = $_REQUEST['end_at'];
    $detail = $_REQUEST['detail'];
    $error = array(
        'event_name' => '',
        'start_at' => '',
        'end_at' => '',
    );
    if (!isset($event_name)){
        $error['event_name'] = 'blank';
    }
    if (!isset($start_at)){
        $error['start_at'] = 'blank';
    }
    if (!isset($end_at)){
        $error['end_at'] = 'blank';
    }
    if (empty($error)) {
        
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
    <form action="" method="post">
        <input type="text" name="event_name" placeholder="イベント名">
        <input type="text" name='start_at'>
        <input type="text" name="end_at">
        <input type="text" name="detail">
        <input type="submit" value="登録">
    </form>
</body>

</html>
