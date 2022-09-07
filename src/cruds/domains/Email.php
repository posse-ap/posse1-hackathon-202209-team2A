<?
namespace cruds\domains;
require_once('../../config.php');
mb_language('ja');
mb_internal_encoding('UTF-8');



class Email
{
  public function send_mail($to,$event,$detail,$start_at,$end_at) {
    $subject = "イベント前日通知";
    $body = "本文";
    $headers = ["From"=>"system@posse-ap.com", "Content-Type"=>"text/plain; charset=UTF-8", "Content-Transfer-Encoding"=>"8bit"];
    
    $body = <<<EOT
    
    ${start_at}から${end_at}に${event}を開催します。
    詳細：
    ${detail}


    参加／不参加の回答をお願いします。
    http://localhost/auth/login
    EOT;

    mb_send_mail($to, $subject, $body, $headers);
    echo "メールを送信しました";
  }
  
}
