<?php

namespace modules\auth;


use cruds\Admin as Cruds;
use modules\auth\Auth;


class Admin extends Auth
{
    public function __construct(\PDO $db)
    {
        $this->cruds = new Cruds($db);
        $this->session = $_SESSION['admin']['id'];
        $this->address = 'admin/index.php';
    }
}
