<?php

namespace App\Models\Repository;

interface ICommentRepository {
    public function getCommentById($id);
    public function createComment($id, $value);
    public function deleteComment($id);
}