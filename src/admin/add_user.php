<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

use modules\auth\Admin as Auth;
use cruds\Admin as Cruds;
use schemas\User as CreateUserSchema;
use modules\Utils;

$auth = new Auth($db);
$cruds = new Cruds($db);

$auth->validate();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $error = array();

  $username = $_REQUEST['username'];
  $email = $_REQUEST['email'];
  $password = $_REQUEST['password'];

  if ($username === '') {
    $error['username'] = 'blank';
  }
  if ($email === '') {
    $error['email'] = 'blank';
  }
  if ($password === '') {
    $error['password'] = 'blank';
  }

  $confirm_password = $_REQUEST['confirm_password'];

  if ($password !== $confirm_password) {
    $error['password'] = 'not confirmed';
  }

  if (empty($error)) {
    $_SESSION['add_user']['username'] = $username;
    $_SESSION['add_user']['email'] = $email;
    $_SESSION['add_user']['password'] = $password;
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/admin/confirm_add_user.php');
    exit();
  }
  echo 'error passed';
}

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
  <main class="bg-gray-100 h-screen">
    <div class="w-full mx-auto py-10 px-5">
      <h2 class="text-md font-bold mb-5">ユーザー登録</h2>
      <form action="" method="POST">
    <input type="username" placeholder="ユーザーネーム" class="w-full p-4 text-sm mb-3" name="username">
    <input type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" name="email">
    <input type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3" name="password">
    <input type="password" placeholder="パスワード確認" class="w-full p-4 text-sm mb-3" name="confirm_password">
    <input type="submit" value="確認" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
  </form>
  <div class="text-center text-xs text-gray-400 mt-6">
      </div>
    </div>
  </main>
</body>

</html>
