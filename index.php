<?php
error_reporting(E_ALL & ~E_DEPRECATED);
require __DIR__ . '/vendor/autoload.php';
use StdCmp\DI\DIContainer;

session_start();
$container = new DI\Container();
$container->set(DIContainer::class, $container);

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

$router = new \App\Core\Router($container);

$router->add('', 'Blog@getBlogPage');
$router->add('/page/:id', 'Blog@getBlogPage');

$router->add('user/login', 'Login@showLogin');
$router->add('user/login/check', 'Login@newLogin');
$router->add('user/register', 'Register@showRegister');

$router->add('posts/:id', 'Post@getPost');

$router->add('admin/posts/create', 'Post@showCreatePost');
$router->add('admin/posts/edit/show/:id', 'Post@showEditPost');
$router->add('admin/posts/create/new', 'Post@CreatePost');
$router->add('admin/posts/edit/:id', 'Post@editPost');
$router->add('admin/posts/delete/:id', 'Post@deletePost');
$router->add('comment/create/:id', 'Comment@postComment');
$router->add('comment/delete/:id', 'Comment@deleteComment');
$router->add('admin/posts', 'Dashboard@showPostDashboard');

$router->run();
