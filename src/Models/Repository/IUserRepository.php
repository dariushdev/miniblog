<?php

namespace App\Models\Repository;

interface IUserRepository {
    public function isUserExists($email);
    public function createUser($body);
    public function checkLogin($email);
}