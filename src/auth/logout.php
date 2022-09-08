<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
use modules\auth\User;

$auth = new User($db);
$auth->logout();
