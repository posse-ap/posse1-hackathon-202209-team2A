<?php


namespace cruds;


class Admin
{
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
}
