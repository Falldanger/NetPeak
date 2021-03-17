<?php

namespace repositories;

include_once './repositories/contracts/ProductInterface.php';

use repositories\contracts\ProductInterface;
use PDO;

/**
 * Class ProductRepository
 * @package repositories
 */
class ProductRepository implements ProductInterface
{
    const PRODUCTS_TABLE = 'products';
    /**
     * @var PDO
     */
    private $db;

    /**
     * ProductRepository constructor.
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
        $query = $this->db->query("SELECT products.id, product_name, creator_name, avg_price, image, products.created_at, count(comments.id) as comments_amount FROM "
            . self::PRODUCTS_TABLE
            . " left join comments on comments.product_id = products.id 
                    group by products.id order by id desc");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * @param array $data
     */
    public function create(array $data): void
    {
        $query = 'INSERT INTO ' . self::PRODUCTS_TABLE . ' (product_name,image,avg_price,creator_name) VALUES(:product_name,:image,:avg_price,:creator_name)';
        $stmt = $this->db->prepare($query);

        // pass values to the statement
        $stmt->bindValue(':product_name', $data['product_name']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':avg_price', $data['avg_price']);
        $stmt->bindValue(':creator_name', $data['creator_name']);

        // execute the insert statement
        $stmt->execute();
    }

    /**
     * @param array $data
     */
    public function update(array $data): void
    {
        $query = 'UPDATE products '
            . 'SET product_name = :product_name, '
            . 'image = :image, '
            . 'creator_name = :creator_name, '
            . 'avg_price = :avg_price '
            . 'WHERE id = :id';

        $stmt = $this->db->prepare($query);

        // bind values to the statement
        $stmt->bindValue(':product_name', $data['product_name']);
        $stmt->bindValue(':image', $data['image']);
        $stmt->bindValue(':creator_name', $data['creator_name']);
        $stmt->bindValue(':avg_price', $data['avg_price']);
        $stmt->bindValue(':id', $data['id']);
        // update data in the database
        $stmt->execute();
    }

    /**
     * @param int $id
     */
    public function delete(int $id): void
    {
        $query = "DELETE FROM " . self::PRODUCTS_TABLE . " WHERE id=" . $id;
        $this->db->prepare($query)->execute();
    }

    /**
     * @param int $id
     * @return mixed
     */
    public function getProductById(int $id)
    {
        $query = $this->db->prepare("SELECT products.id,products.product_name,products.image,products.avg_price,products.created_at, avg(comments.mark) as avg_mark FROM " . self::PRODUCTS_TABLE
            . " left join comments on comments.product_id = products.id"
            . " WHERE products.id=:id"
            . " group by comments.product_id");
        $query->execute(['id' => $id]);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * @param string $column
     * @param string $sortRule
     * @return array
     */
    public function sortByColumn(string $column, $sortRule = 'desc')
    {
        $query = $this->db->query("SELECT products.id, product_name, creator_name, image, products.created_at, products.avg_price, count(comments.id) as comments_amount FROM "
            . self::PRODUCTS_TABLE
            . " left join comments on comments.product_id = products.id 
                    group by products.id order by $column $sortRule");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
}
