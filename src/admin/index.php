<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
use cruds\Admin as Cruds;
use modules\auth\Admin as Auth;
use modules\Utils;

$auth = new Auth($db);

$auth->validate();

$crud = new Cruds($db);

$events = $crud->get_events();

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

        <?php foreach ($events as $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = Utils::get_day_of_week(date("w", $start_date));
          ?>
          <a class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>" href="event.php?id=<?= $event['id'] ?>">
            <div>
              <h3 class="font-bold text-lg mb-2"><?php echo $event['name'] ?></h3>
              <p><?php echo date("Y年m月d日（${day_of_week}）", $start_date); ?></p>
              <p class="text-xs text-gray-600">
                <?php echo date("H:i", $start_date) . "~" . date("H:i", $end_date); ?>
              </p>
            </div>
            <div class="flex flex-col justify-between text-right">
              <div>
                <?php if ($event['id'] % 3 === 1) : ?>
                  <!--
                  <p class="text-sm font-bold text-yellow-400">未回答</p>
                  <p class="text-xs text-yellow-400">期限 <?php echo date("m月d日", strtotime('-3 day', $end_date)); ?></p>
                  -->
                <?php elseif ($event['id'] % 3 === 2) : ?>
                  <!--
                  <p class="text-sm font-bold text-gray-300">不参加</p>
                  -->
                <?php else : ?>
                  <!--
                  <p class="text-sm font-bold text-green-400">参加</p>
                  -->
                <?php endif; ?>
              </div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </body>

  </html>
