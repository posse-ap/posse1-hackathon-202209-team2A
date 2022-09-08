<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

use modules\auth\User as Auth;
use cruds\User as Cruds;

$auth = new Auth($db);
$cruds = new Cruds($db);

$error = '';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
  if(isset($_POST['email']) && isset($_POST['password'])){
    $login = $auth->login($_POST['email'], $_POST['password']);
    if($login){
      header('Location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
      exit();
    }else{
      $error = 'failed';
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
      <h2 class="text-md font-bold mb-5">ログイン</h2>
      <form action="" method="POST">
        <input type="email" placeholder="メールアドレス" class="w-full p-4 text-sm mb-3" name="email">
        <input type="password" placeholder="パスワード" class="w-full p-4 text-sm mb-3" name="password" value="<?= $_POST['email'] ?>">
        <?php if($error == 'failed'):?>
          <p>ログイン失敗しました</p>
        <?php endif?>
        <input type="submit" value="ログイン" class="cursor-pointer w-full p-3 text-md text-white bg-blue-400 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-300">
      </form>
      <div class="text-center text-xs text-gray-400 mt-6">
        <a href="/auth/login/github.php">Sign In by GitHub</a>
      </div>
    </div>
  </main>
</body>

</html>
