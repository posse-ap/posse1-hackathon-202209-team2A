<?php
require_once('config.php');

use cruds\User as Cruds;
use modules\auth\User as Auth;
use modules\Utils;

$auth = new Auth($db);

$auth->validate();
$user_id = $_SESSION['user']['id'];

$crud = new Cruds($db);

$event_id = $_GET['event_id'];
if (!isset($event_id)) {
    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/');
    exit();
}

$event = $crud->read_event($event_id, $user_id);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_REQUEST['is_attendance'])) {
        $event_id = $_REQUEST['event_id'];
        $is_attendance = $_REQUEST['is_attendance'];

        $success = $crud->handle_attendance($event_id, $user_id, $is_attendance);
        if ($success) {
            header("Location: http://" . $_SERVER['HTTP_HOST'] . '/?is_attendance=' . $is_attendance);
            exit();
        }
    }
}

include dirname(__FILE__) . '/component/header.php';
?>
<header class="h-16">
    <div class="flex justify-between items-center w-full h-full mx-auto pl-2 pr-5">
        <div class="h-full">
            <img src="img/header-logo.png" alt="" class="h-full">
        </div>

        <div>
            <a href="/auth/password_reset" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">password reset</a>
        </div>

    </div>
</header>

<main class="bg-gray-100">
    <div id="events-list">
        <div class="flex justify-between items-center mb-3">
            <h2 class="text-sm font-bold">一覧</h2>
        </div>
        <?php
        $start_date = strtotime($event['start_at']);
        $end_date = strtotime($event['end_at']);
        $day_of_week = Utils::get_day_of_week(date("w", $start_date));
        ?>
        <div class="modal-open bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>">
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
                <p class="text-sm"><span class="text-xl"><?= count($event['attendance_users']) ?></span>人参加 ></p>
                <?php foreach ($event['attendance_users'] as $attendance) :  ?>
                    <div><?= $attendance['username'] ?></div>
                <?php endforeach ?>
            </div>
        </div>

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
            <p class="text-sm"><span class="text-xl"><?= count($event['attendance_users']) ?></span>人参加 ></p>
            <?php foreach ($event['attendance_users'] as $attendance) :  ?>
                <div><?= $attendance['username'] ?></div>
            <?php endforeach ?>
        </div>
        <form action="" method="POST">
            <input type="hidden" name="event_id" value="<?= $event['id'] ?>">
            <label for="attendance_radio"><input id="attendance_radio" type="radio" value="1" name="is_attendance" <?php if ($event['is_attendance']) {
                echo 'disabled';
            } ?>>参加</label>
            <label for="unattendance_radio"><input id="unattendance_radio" type="radio" value="0" name="is_attendance" <?php if (!$event['is_attendance']) {
                echo 'disabled';
            } ?>>不参加</label>
            <br>
            <input type="submit" value="登録" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">
        </form>
    </div>
    </div>
</main>
