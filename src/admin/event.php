<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

use cruds\Admin as Cruds;
use modules\auth\Admin as Auth;
use modules\Utils;

$auth = new Auth($db);

$auth->validate();

$crud = new Cruds($db);

$events = $crud->get_events();

$event_id = $_GET['id'];

if (!isset($event_id)) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/index.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_REQUEST['name'];
    $start_at = $_REQUEST['start_at'];
    $end_at = $_REQUEST['end_at'];
    $detail = $_REQUEST['detail'];

    $error = array();

    if (!isset($name)) {
        $error['name'] = 'blank';
    }
    if (!isset($start_at)) {
        $error['start_at'] = 'blank';
    }
    if (!isset($end_at)) {
        $error['end_at'] = 'blank';
    }
    if (!isset($detail)) {
        $error['detail'] = 'blank';
    }

    if (empty($error)) {
        $update = $crud->update_event($event_id, $name, $start_at, $end_at, $detail);
        if ($update) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] .'/admin');
            exit();
        }
    }
}

$event = $crud->get_event($event_id);

?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <title>Schedule | POSSE</title>
</head>

<body>
    <header class="h-16">
        <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
            <div class="h-full">
                <img src="/img/header-logo.png" alt="" class="h-full">
            </div>
        </div>
    </header>


    <main class="bg-gray-100">
        <div class="w-full mx-auto p-5">
            <div id="filter" class="mb-8">
                <h2 class="text-sm font-bold mb-3">フィルター</h2>
                <div id="attendance_button_container" class="flex">
                    <a href="index.php" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">全て</a>
                    <a href="index.php?is_attendance=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">参加</a>
                    <a href="index.php?is_attendance=0" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">不参加</a>
                    <a href="index.php?is_answered=1" class="px-3 py-2 text-md font-bold mr-2 rounded-md shadow-md bg-white">未回答</a>
                </div>
            </div>




            <div id="events-list">
                <div class="flex justify-between items-center mb-3">
                    <h2 class="text-sm font-bold">一覧</h2>
                </div>
                <?php
                $start_date = strtotime($event['start_at']);
                $end_date = strtotime($event['end_at']);
                $day_of_week = Utils::get_day_of_week(date("w", $start_date));
                ?>
                <form class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>" action="" method="POST">
                    <div>
                        <input class="font-bold text-lg mb-2" value="<?= $event['name'] ?>" placeholder="イベント名" name="name">
                        <br>
                        <label>開始時刻：<input type="datetime-local" name="start_at" value="<?= $event['start_at'] ?>"></label>
                        <br>
                        <label>終了時刻：<input type="datetime-local" name="end_at" value="<?= $event['end_at'] ?>"></label>
                        <textarea name="detail" id="" cols="30" rows="10" class="w-full p-4 text-sm mb-3" placeholder="イベント内容"><?= $event['detail'] ?></textarea>
                        <input type="submit" value="変更" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
                    </div>
                </form>
            </div>
        </div>
</body>

</html>
