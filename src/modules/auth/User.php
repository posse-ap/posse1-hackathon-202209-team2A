<?php

namespace modules\auth;
use cruds\User as Cruds;
use modules\auth\Auth;

class User extends Auth{

    public function __construct(\PDO $db)
    {
        $this->cruds = new Cruds($db);
        $this->session = $_SESSION['user']['id'];
        $this->address = 'index.php';
    }
}
