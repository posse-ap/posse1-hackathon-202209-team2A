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

include $_SERVER['DOCUMENT_ROOT'] . '/component/header.php';
?>
<header class="h-16">
      <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
        <div class="h-full">
          <img src="/img/header-logo.png" alt="" class="h-full">
        </div>
      </div>
    </header>
<body>
    <main class="bg-gray-100 h-screen">
        <div class="w-full mx-auto py-10 px-5">
            <h2 class="text-md font-bold mb-5">イベント登録</h2>
            <form action="" method="POST">
                <?php if ($error['event_name'] === 'blank') : ?>
                    <p>イベント名を入力してください</p>
                <?php endif ?>
                <input type="text" name="event_name" placeholder="イベント名" class="w-full p-4 text-sm mb-3">
                <?php if ($error['start_at'] === 'blank') : ?>
                    <p>開始日時を入力してください</p>
                <?php endif ?>
                <input type="datetime-local" name='start_at' class="w-full p-4 text-sm mb-3">
                <?php if ($error['end_at'] === 'blank') : ?>
                    <p>終了日時を入力してください</p>
                <?php endif ?>
                <input type="datetime-local" name="end_at" class="w-full p-4 text-sm mb-3">
                <textarea name="detail" id="" cols="30" rows="10" class="w-full p-4 text-sm mb-3" placeholder="イベント内容"></textarea>
                <input type="submit" value="登録" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
            </form>
            <div class="text-center text-xs text-gray-400 mt-6">
            </div>
        </div>
    </main>
</body>

</html>
