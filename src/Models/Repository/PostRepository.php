<?php


namespace App\Models\Repository;

use App\Models\Database;
use PDO;

class PostRepository implements IPostRepository
{
    protected $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getAllPost()
    {
        $stmt = $this->db->getConnection()->prepare('SELECT posts.id, posts.title, posts.body, posts.slug, posts.created, users.name FROM posts INNER JOIN users ON posts.author = users.id ORDER BY posts.id DESC');
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function getPostCount()
    {
        return $this->db->getConnection()->query('SELECT COUNT(*) FROM posts')->fetchColumn();
    }

    public function getPostById($slug)
    {
       $q = $this->db->getConnection()->prepare("SELECT posts.id, posts.title, posts.body, posts.slug, posts.created, users.name FROM posts INNER JOIN users ON posts.author = users.id WHERE slug = ? ");
       $q->execute([$slug]);
       $result = $q->fetch(PDO::FETCH_ASSOC);
       return $result;
    }

    public function createPost($value)
    {
        $stmt= $this->db->getConnection()->prepare('INSERT INTO posts (title, body, author, slug, created) VALUES (?,?,?,?,?)');
        $stmt->execute([$value['title'], $value['content'], $_SESSION['userid'], $value['slug'], date('Y-m-d H:i:s')]);
    }

    public function editPost($value, $id)
    {
        $stmt= $this->db->getConnection()->prepare('UPDATE posts SET title = ?, body = ?, author = ?, slug = ? WHERE id = ?');
        $stmt->execute([$value['title'], $value['content'], $_SESSION['userid'], $value['slug'], $id]);
    }

    public function deletePost($id)
    {
        $stmt= $this->db->getConnection()->prepare('DELETE FROM posts WHERE id = ?');
        $stmt->execute([$id]);
        $count = $stmt->rowCount();
        if($count > 0) {
            return true;
        }
    }
}