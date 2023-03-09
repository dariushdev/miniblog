<?php


namespace App\Controllers;


use App\Core\Controller as Controller;
use App\Models\Repository\UserRepository;

class Register extends Controller
{
    private $userRepository;
    public function __construct(UserRepository $userRepository)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
    }

    public function showRegister()
    {
        $this->render('admin/adminregister.html.twig', []);
    }

    public function newRegistration($body)
    {
        $data = $body->getBody();
        if($this->userRepository->isUserExists($data['email'])) {
            $password = password_hash($data['password'], PASSWORD_DEFAULT);
            $data['password'] = $password;
            $this->userRepository->createUser($data);
        }
    }
}