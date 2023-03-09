<?php


namespace App\Controllers;


use App\Core\Controller as Controller;
use App\Core\Session;


class Dashboard extends Controller
{
    protected $session;
    protected $post;

    public function __construct(Session $session, Post $post)
    {
        parent::__construct();
        $this->session = $session;
        $this->post = $post;
        $this->session->isLoggedin();
    }


    public function showPostDashboard($id = 0)
    {
        $posts = $this->post->getAllPost($id);
        $this->render('admin/posts/posts.html.twig', 
        [
            'posts' => $posts,
            'pages' => ceil($this->post->getPostCount() / 4)
        ]);
    }
}