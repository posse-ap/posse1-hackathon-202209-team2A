<?php
require_once('config.php');

use cruds\User as Cruds;
use modules\auth\User as Auth;
use modules\Utils;

$auth = new Auth($db);

$auth->validate();
$user_id = $_SESSION['user']['id'];

$crud = new Cruds($db);

$events = $crud->read_events();

if (isset($_GET['is_attendance'])) {
  $is_attendance = $_GET['is_attendance'];
  $events = $crud->read_attendance_events($user_id, $is_attendance);
}
if (isset($_GET['is_answered'])) {
  $is_answered = $_GET['is_answered'];
  $events = $crud->read_unanswered_events($user_id, $is_attendance);
}

if(isset($_GET['page'])){
  $page = $_GET['page'];
}else{
  $page = 1;
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
        <?php foreach (array_slice($events,10*($page-1),10) as $event) : ?>
          <?php
          $start_date = strtotime($event['start_at']);
          $end_date = strtotime($event['end_at']);
          $day_of_week = Utils::get_day_of_week(date("w", $start_date));
          ?>
          <a class="bg-white mb-3 p-4 flex justify-between rounded-md shadow-md cursor-pointer" id="event-<?php echo $event['id']; ?>" href="/attendance.php?event_id=<?= $event['id'] ?>">
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
        </a>
        <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center">
          <div class="modal-overlay absolute w-full h-full bg-black opacity-80"></div>

          <div class="modal-container absolute bottom-0 bg-white w-screen h-4/5 rounded-t-3xl shadow-lg z-50">
            <div class="modal-content text-left py-6 pl-10 pr-6">
              <div class="z-50 text-right mb-5">
                <svg class="modal-close cursor-pointer inline bg-gray-100 p-1 rounded-full" xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 18 18">
                  <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
                </svg>
              </div>

              <div id="modalInner">
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
                  <label for="attendance_radio"><input id="attendance_radio" type="radio" value="1" name="is_attendance">参加</label>
                  <label for="unattendance_radio"><input id="unattendance_radio" type="radio" value="0" name="is_attendance">不参加</label>
                  <br>
                  <input type="submit" value="登録" class="text-white bg-blue-400 px-4 py-2 rounded-3xl bg-gradient-to-r from-blue-600 to-blue-200">
                </form>
              </div>

            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>



  <!-- ページネーション -->
  <!-- This example requires Tailwind CSS v2.0+ -->
  <div class="flex items-center justify-items-center px-4 py-3 sm:px-6">
    <!-- <div class="flex flex-1 justify-between sm:hidden">
      <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
      <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
    </div> -->
    <div class="sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div>
        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
          <a href="#" class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
            <span class="sr-only">Previous</span>
            <!-- Heroicon name: mini/chevron-left -->
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 01-.02 1.06L8.832 10l3.938 3.71a.75.75 0 11-1.04 1.08l-4.5-4.25a.75.75 0 010-1.08l4.5-4.25a.75.75 0 011.06.02z" clip-rule="evenodd" />
            </svg>
          </a>
          <?php for($page = 1;$page <= ceil(count($events)/10);$page++) : ?>
          <a href="<?="index.php?page=" . $page; ?>" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20"><?=$page; ?>
          <?php endfor; ?>
          <a href="#" class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20">
            <span class="sr-only">Next</span>
            <!-- Heroicon name: mini/chevron-right -->
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
              <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 01.02-1.06L11.168 10 7.23 6.29a.75.75 0 111.04-1.08l4.5 4.25a.75.75 0 010 1.08l-4.5 4.25a.75.75 0 01-1.06-.02z" clip-rule="evenodd" />
            </svg>
          </a>
        </nav>
      </div>
    </div>
  </div>
</main>


<script src="/js/main.js"></script>
<script>
  const attendance_buttons = document.querySelectorAll('#attendance_button_container>a');

  function changedButtonColor(attendance_id) {
    attendance_buttons[attendance_id].classList.add('bg-blue-600');
    attendance_buttons[attendance_id].classList.add('text-white');

  }
</script>
<?php if ($is_answered == '1') { ?>
  <script>
    changedButtonColor(3);
  </script>
<?php } else if ($is_attendance == '1') { ?>
  <script>
    changedButtonColor(1);
  </script>
<?php } else if ($is_attendance == '0') { ?>
  <script>
    changedButtonColor(2);
  </script>
<?php } else { ?>
  <script>
    changedButtonColor(0);
  </script>
<?php } ?>


</body>

</html>
