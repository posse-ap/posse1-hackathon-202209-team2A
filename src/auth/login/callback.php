<?php
require_once($_SERVER['DOCUMENT_ROOT'] . '/config.php');
use cruds\User as Crud;

$crud = new Crud($db);
