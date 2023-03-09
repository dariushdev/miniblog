<?php


namespace App\Models\Repository;


use App\Models\Database;
use PDO;


class UserRepository
{
    private $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function isUserExists($email)
    {
        $q = $this->db->getConnection()->prepare('SELECT * FROM users WHERE email = ?');
        $q->execute([$email]);
        if($q->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function createUser($body)
    {
        $stmt= $this->db->getConnection()->prepare('INSERT INTO users (email, name, password) VALUES (?,?,?)');
        $stmt->execute([$body['email'], $body['name'], $body['password']]);
    }

    public function checkLogin($email)
    {
        $q = $this->db->getConnection()->prepare('SELECT * FROM users WHERE email = ?');
        $q->execute([$email]);
        $result = $q->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}