<?php
define('DSN', 'mysql:host=' . getenv('MYSQL_HOST') . ';dbname=' . getenv('MYSQL_DATABASE') . ';charset=utf8mb4');
define('DB_USER', getenv('MYSQL_USER'));
define('DB_PASS', getenv('MYSQL_PASSWORD'));
define('SITE_URL', 'http://' . $_SERVER['HTTP_HOST']);
define('GITHUB_CLIENT_ID', getenv('GITHUB_CLIENT_ID'));
define('GITHUB_CLIENT_SECRET', getenv('GITHUB_CLIENT_SECRET'));
define('GITHUB_REDIRECT_URL', SITE_URL . getenv('GITHUB_REDIRECT_URL'));
define('SLACK_OAUTH_USER_TOKEN', getenv('SLACK_OAUTH_USER_TOKEN'));
define('SLACK_OAUTH_BOT_TOKEN', getenv('SLACK_OAUTH_BOT_TOKEN'));

require_once(dirname(__FILE__) . '/database/Database.php');
require_once(dirname(__FILE__) . '/cruds/domains/GitHub.php');
session_start();

use database\Database;
use cruds\domains\GitHub;

// クラスを自動ロードする関数
spl_autoload_register(function ($classname) {
    //クラス名を\で分割した配列を作成。
    $classNameArray = explode("\\", $classname);  // （2）
    //ファイルパス用文字列変数を用意。
    $filepath = "";
    //分割されたクラス名配列をループさせながらファイルパスを生成。
    for ($i = 0; $i < count($classNameArray); $i++) {  // （3）
        $filepath .= "/" . $classNameArray[$i];
    }
    //ファイルパスの前にドキュメントルートのパス、後に拡張子を追加。
    $filepath = $_SERVER["DOCUMENT_ROOT"] . $filepath . ".php";  // （4）
    //ファイルパスの先が正常ファイルかどうかを判定。
    if (is_file($filepath)) {  // （5）
        //正常パスなら読込。
        require_once  $filepath;  // （6）
    }
});

$db = Database::getInstance();
$git_client= new GitHub(array(
    'client_id' => GITHUB_CLIENT_ID,
    'client_secret' => GITHUB_CLIENT_SECRET,
    'redirect_uri' => GITHUB_REDIRECT_URL
));

if(isset($_SESSION['access_token'])){
    $access_token = $_SESSION['access_token'];
}
