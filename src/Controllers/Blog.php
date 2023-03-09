<?php


namespace App\Controllers;

use App\Core\Controller as Controller;

class Blog extends Controller
{
    public function __construct(Post $post)
    {
        parent::__construct();
        $this->post = $post;
    }
    public function getBlogPage()
    {
        $posts = $this->post->getAllPost();
        foreach ($posts as $key => $v) {
            $posts[$key]['body'] = html_entity_decode($v['body']);
        }
        $this->render(
            'index.html.twig',
            ['posts' => $posts]
        );
    }
}
