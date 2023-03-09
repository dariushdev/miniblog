<?php


namespace App\Controllers;

use App\Core\Controller;
use App\Core\Request;
use App\Core\Session;
use App\Core\Validator;
use App\Models\Repository\CommentRepository;

class Comment extends Controller
{
    protected $commentRepository;
    protected $validator;
    protected $session;

    public function __construct(CommentRepository $commentRepository, Validator $validator, Session $session)
    {
        parent::__construct();
        $this->commentRepository = $commentRepository;
        $this->validator = $validator;
        $this->session = $session;
    }

    public function getCommentsById($id)
    {
        return $this->commentRepository->getCommentById($id);
    }

    public function postComment($body, $id)
    {
        $comment = $body->getBody();

        $this->validator->name('email')->value($comment['email'])->pattern('email')->required();
        $this->validator->name('name')->value($comment['name'])->pattern('text')->required();
        $this->validator->name('comment')->value($comment['comment'])->pattern('text')->required();
        if($this->validator->isSuccess()) {
            $this->commentRepository->createComment($id, $comment);
        } else {
            $this->session->addError($this->validator->getErrors());
        }
    }

    public function deleteComment($body, $id)
    {
        $this->session->isLoggedin();
        $this->commentRepository->deleteComment($id);
    }

}
