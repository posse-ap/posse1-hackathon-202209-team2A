<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
use cruds\Admin as Cruds;
use modules\auth\Admin as Auth;

$auth = new Auth($db);

$auth->validate();

$crud = new Cruds($db);

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

    home
  </body>

  </html>
