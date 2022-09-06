<?php


namespace curds;


class User
{
    public function __construct(\PDO $db)
    {
        $this->db = $db;
    }
    
}
