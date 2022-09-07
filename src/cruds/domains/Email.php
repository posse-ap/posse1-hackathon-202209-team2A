<?
  namespace cruds\domains;
  require_once('../../config.php');
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