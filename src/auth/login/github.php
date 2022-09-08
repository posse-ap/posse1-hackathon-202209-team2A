<?php

require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');

use cruds\User as Crud;

$crud = new Crud($db);

if (isset($access_token)) {
    $git_user = $git_client->get_authoricated_user($access_token);
    $git_email = $git_client->get_authoricated_email($access_token);

    if (!empty($git_user)) {
        $oauth_uid = $git_user->id;
        $user = $crud->get_user_for_github($oauth_uid);
        if (!$user) {
            $user = $crud->add_user_from_github($git_user->login,
                                                $git_email,
                                                $oauth_uid);

        }
        if (isset($user)) {
            $_SESSION['user']['id'] = $user['id'];

            header('Location: http://' . $_SERVER['HTTP_HOST']);
            exit();
        }
    }
} elseif (isset($_GET['code'])) {
    // Verify the state matches the stored state
    if (!$_GET['state'] || $_SESSION['state'] != $_GET['state']) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }

    // Exchange the auth code for a token
    $access_token = $git_client->get_access_token($_GET['state'], $_GET['code']);

    $_SESSION['access_token'] = $access_token;

    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/auth/login/github.php');
    exit();
} else {
    // Generate a random hash and store in the session for security
    $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand() . $_SERVER['REMOTE_ADDR']);

    // Remove access token from the session
    unset($_SESSION['access_token']);

    // Get the URL to authorize
    $auth_url = $git_client->get_authorize_url($_SESSION['state']);

    // Render Github login button
    $output = '<a href="' . htmlspecialchars($auth_url) . '">Sign In by GitHub</a>';
    echo $output;
}
