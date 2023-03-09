<?php


namespace App\Controllers;


use App\Core\Controller as Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Repository\UserRepository;

class Login extends Controller
{
    private $userRepository;
    private $session;
    private $validator;
    public function __construct(UserRepository $userRepository, Session $session, Validator $validator)
    {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->validator = $validator;
    }

    public function showLogin()
    {
        $this->render('login.html.twig', []);
    }

    public function newLogin($body)
    {
        $data = $body->getBody();
        $this->validator->name('email')->value($data['email'])->pattern('email')->required();

        if($this->validator->isSuccess()) {
            if ($this->userRepository->isUserExists($data['email'])) {
                $userData = $this->userRepository->checkLogin($data['email']);
                if (password_verify($data['password'], $userData[0]['password'])) {
                    $this->session->set($userData[0]['id'], $userData[0]['name']);
                    header("Location: http://{$_SERVER['HTTP_HOST']}");
                    die();
                } else {
                    http_response_code(403);
                    $this->session->addError(['Wrong email or password.']);
                    header('Location: http://' . $_SERVER['HTTP_HOST'] . '/user/login');
                }
            } else {
                http_response_code(404);
                $this->session->addError(['User not found.']);
                header('Location: http://' . $_SERVER['HTTP_HOST'] . '/user/login');
            }
        } else {
            http_response_code(403);
            $this->session->addError($this->validator->getErrors());
            header('Location: http://' . $_SERVER['HTTP_HOST'] . '/user/login');
        }


    }
}