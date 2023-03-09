<?php

namespace App\Core;

use \Twig\Environment as TwigEnvironment;
use \Twig\Loader as TwigLoader;
use App\Core\Session as Session;

class Controller
{
    public $loader;
    public $twig;


    public function __construct()
    {
        $this->loader = new TwigLoader\FilesystemLoader(dirname(__DIR__) . '/templates');
        $this->twig = new TwigEnvironment($this->loader);
        $this->twig->addGlobal('session', $_SESSION);
        $function = new \Twig\TwigFunction('unset', function() {
            if(isset($_SESSION['flash']))
            {
                unset($_SESSION['flash']);
            }
        });
        $this->twig->addFunction($function);
    }

    public function render($view, $variable = [])
    {
        echo $this->twig->render($view, $variable);
    }

}