<?php

namespace cruds\domains;

class Slack
{
    protected static $headers = [
        'Authorization: Bearer ' . SLACK_OAUTH_USER_TOKEN, //（1)
        'Content-Type: application/json;charset=utf-8'
    ];

    protected static $url = "https://slack.com/api/chat.postMessage";

    private static function notificate_slack_channel($channel, $text)
    {
        $post_fields = [
            "channel" => "hackathon",
            "text" => $text,
            "as_user" => true
        ];

        $options = [
            CURLOPT_URL => self::$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => self::$headers,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => json_encode($post_fields)
        ];

        $ch = curl_init();

        curl_setopt_array($ch, $options);

        curl_exec($ch);

        curl_close($ch);
    }

    public static function send_events_remind($to, $event, $detail, $start_at, $end_at)
    {
        $body = <<<EOT
    @${to}
    @channel
    ${start_at}から${end_at}に${event}を開催します。
    詳細：
    ${detail}

    EOT;

    self::notificate_slack_channel('hackathon', $body);
    }
}
