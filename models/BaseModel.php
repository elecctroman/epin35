<?php
namespace Models;

use PDO;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = require __DIR__ . '/../config/db.php';
    }
}
