<?
  namespace cruds\domains;
  require_once('../../config.php');
  require_once('../User.php');
  use cruds\User;
  mb_language('ja');
  mb_internal_encoding('UTF-8');



class Email
{
  public function mail_send($to) {
    $subject = "イベント前日通知";
    $body = "本文";
    $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
    
    $date = "2021年08月01日（日） 21:00~23:00";
    $event = "縦モク";
    $body = <<<EOT
    
    ${date}に${event}を開催します。
    参加／不参加の回答をお願いします。
    
    http://localhost/auth/login
    EOT;
    
    mb_send_mail($to, $subject, $body, $headers);
    echo "メールを送信しました";
  }
  
  }

  $mail = new Email;
  $crud = new User($db);
  $before_attendance_users = $crud -> before_attendance_user();
  foreach($before_attendance_users as $before_attendance_user) {
    $to = $before_attendance_user['email'];
  };
  $mail -> mail_send($to);
