<?php


namespace cruds;


class User
{
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
    
}
