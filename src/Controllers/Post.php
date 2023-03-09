<?php


namespace App\Controllers;
use App\Core\Controller as Controller;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Repository\PostRepository;
use Dotenv\Parser\Value;

class Post extends Controller
{
    protected $postRepository;
    protected $comment;
    protected $session;
    protected $validator;

    public function __construct(PostRepository $postRepository, Comment $comment, Session $session, Validator $validator)
    {
        parent::__construct();
        $this->postRepository = $postRepository;
        $this->comment = $comment;
        $this->session = $session;
        $this->validator = $validator;
    }

    public function getAllPost()
    {
        return $this->postRepository->getAllPost();
    }

    public function getPostCount()
    {
        return $this->postRepository->getPostCount();
    }

    public function getPost($id)
    {
        $post = $this->postRepository->getPostById($id);
        $comments = $this->comment->getCommentsById($id);
        $post['body'] = html_entity_decode($post['body']);

        $this->render('post.html.twig', ['post' => [$post], 'comments' => $comments]);
    }

    public function showCreatePost()
    {
        $this->session->isLoggedin();
        $this->render('admin/posts/newpost.html.twig', []);
    }

    public function createPost($body)
    {
        $this->session->isLoggedin();

        $data = $body->getBody();

        $this->validator->name('title')->value($data['title'])->pattern('title')->required();
        $this->validator->name('slug')->value($data['slug'])->pattern('slug')->required();

        if ($this->validator->isSuccess()) 
        {
            $this->postRepository->createPost($data);
            $this->session->addSuccess('Post created successfully!');
        } else {
            $this->session->addError($this->validator->getErrors());
        }

    }

    public function showEditPost($slug)
    {
        $this->session->isLoggedin();
        $post = $this->postRepository->getPostById($slug);
        $post['body'] = html_entity_decode($post['body']);
        $this->render('admin/posts/editpost.html.twig', ['post' => $post]);
    }

    public function editPost($body, $id)
    {
        $data = $body->getBody();
        $this->session->isLoggedin();

        $this->validator->name('title')->value($data['title'])->pattern('title')->required();
        $this->validator->name('slug')->value($data['slug'])->pattern('slug')->required();

        if($this->validator->isSuccess()) {
            $this->postRepository->editPost($data, $id);
            $this->session->addSuccess('Post edited successfully!');
        } else {
            $this->session->addError($this->validator->getErrors());
        }
    }

    public function deletePost($body, $id)
    {
        $this->session->isLoggedin();
        $deleted = $this->postRepository->deletePost($id);
        if($deleted) {
            $this->session->addSuccess('Post deleted successfully!');
        } else {
            $this->session->addError($this->validator->getErrors());
        }
    }
}