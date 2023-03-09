<?php


namespace App\Models\Repository;

use App\Models\Database;
use PDO;

class CommentRepository implements ICommentRepository
{
    protected $db;
    public function __construct(Database $db)
    {
        $this->db = $db;
    }

    public function getCommentById($id)
    {
        $q = $this->db->getConnection()->prepare('SELECT comments.id, comments.name, comments.comment, comments.replyto FROM comments INNER JOIN posts ON posts.id =  comments.post_id WHERE slug = ?');
        $q->execute([$id]);
        $result = $q->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function createComment($id, $value)
    {
        $stmt= $this->db->getConnection()->prepare('INSERT INTO comments (email, name, comment, replyto, post_id) VALUES (?,?,?,?,?)');
        $stmt->execute([$value['email'], $value['name'], $value['comment'], $value['reply'], $id]);

    }

    public function deleteComment($id)
    {
        $stmt= $this->db->getConnection()->prepare('DELETE FROM comments WHERE id = ?');
        $stmt->execute([$id]);
        $count = $stmt->rowCount();
        if($count > 0) {
            return true;
        }
    }
}