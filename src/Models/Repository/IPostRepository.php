<?php

namespace App\Models\Repository;

interface IPostRepository {
    public function getAllPost();
    public function getPostById($id);
    public function getPostCount();
    public function createPost($value);
    public function editPost($value, $id);
    public function deletePost($id);
}