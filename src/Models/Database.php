<?php


namespace App\Models;


use PDO;

class Database
{
    private $connection;
    const HOST = '127.0.0.1';
    const USER = 'root';
    const PASS = '';
    const DB = 'blogphp1';

    public function __construct()
    {
        try {
            $this->connection = new PDO("mysql:host=" . self::HOST . ";dbname=" . self::DB . "", self::USER, self::PASS);
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function getConnection()
    {
        return $this->connection;
    }


}