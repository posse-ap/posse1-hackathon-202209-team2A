<?php

namespace cruds\domains;

class GitHub
{
    protected $authorize_url = "https://github.com/login/oauth/authorize";
    protected $token_url = "https://github.com/login/oauth/access_token";
    protected $api_url_base = "https://api.github.com";
    protected $client_id;
    protected $client_secret;
    protected $redirect_uri;

    public function __construct($config = [])
    {
        $this->client_id = isset($config['client_id']) ? $config['client_id'] : '';
        if (!$this->client_id) {
            die('Required "client_id" key not supplied in config');
        }
        $this->client_secret = isset($config['client_secret']) ? $config['client_secret'] : '';
        if (!$this->client_secret) {
            die('Required "client_secret" key not supplied in config');
        }
        $this->redirect_uri = isset($config['redirect_uri']) ? $config['redirect_uri'] : '';
    }

    public function get_authorize_url($state)
    {
        return $this->authorize_url . '?' . http_build_query([
            'client_id' => $this->client_id,
            'redirect_uri' => $this->redirect_uri,
            'state' => $state,
            'scope' => 'user:email',
        ]);
    }

    public function api_request($access_token_url)
    {
        $api_url = filter_var($access_token_url, FILTER_VALIDATE_URL) ? $access_token_url : $this->api_url_base  . 'user?access_token=' . $access_token_url;

        $context  = stream_context_create([
            'http' => [
                'user_agent' => 'CodexWorld GitHub OAuth Login',
                'header' => 'Accept: application/json'
            ]
        ]);
        $res = file_get_contents($api_url, false, $context);

        return $res ? json_decode($res) : $res;
    }

    public function get_authoricated_user($access_token)
    {
        $api_url = $this->api_url_base . '/user';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Authorization: token ' . $access_token));
        curl_setopt($ch, CURLOPT_USERAGENT, 'CodexWorld GitHub OAuth Login');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        $api_response = curl_exec($ch);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($http_code != 200) {
            if (curl_errno($ch)) {
                $error_msg = curl_error($ch);
            } else {
                $error_msg = $api_response;
            }
            throw new Exception('Error ' . $http_code . ': ' . $error_msg);
        } else {
            return json_decode($api_response);
        }
    }
}
