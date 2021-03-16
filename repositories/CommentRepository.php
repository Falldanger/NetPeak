<?php

namespace repositories;

include_once './repositories/contracts/CommentInterface.php';

use repositories\contracts\CommentInterface;
use PDO;

/**
 * Class CommentRepository
 * @package repositories
 */
class CommentRepository implements CommentInterface
{
    const COMMENTS_TABLE = 'comments';
    /**
     * @var PDO
     */
    private $db;

    /**
     * CommentRepository constructor.
     * @param PDO $pdo
     */
    public function __construct(PDO $pdo)
    {
        $this->db = $pdo;
    }

    /**
     * @return array
     */
    public function all()
    {
        $query = $this->db->query("SELECT * FROM " .self::COMMENTS_TABLE ." order by id desc");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     */
    public function create(array $data): void
    {
        $query = 'INSERT INTO ' . self::COMMENTS_TABLE . ' (product_id,commentator_name,mark,message) VALUES(:product_id,:commentator_name,:mark,:message)';
        $stmt = $this->db->prepare($query);

        // pass values to the statement
        $stmt->bindValue(':product_id', $data['product_id']);
        $stmt->bindValue(':commentator_name', $data['commentator_name']);
        $stmt->bindValue(':mark', $data['mark']);
        $stmt->bindValue(':message', $data['message']);

        // execute the insert statement
        $stmt->execute();
    }

    /**
     * @param array $data
     */
    public function update(array $data): void
    {
        //
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $query = "DELETE FROM " . self::COMMENTS_TABLE . " WHERE id=" . $id;
        $this->db->prepare($query)->execute();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getRecordById(int $id)
    {
        $query = $this->db->prepare("SELECT * FROM " . self::COMMENTS_TABLE . " WHERE id=:id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param int $productId
     * @return mixed
     */
    public function getCommentsByProductId(int $productId)
    {

        $query = $this->db->prepare("SELECT * FROM " . self::COMMENTS_TABLE . " WHERE product_id=:product_id");
        $query->execute(['product_id' => $productId]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}
