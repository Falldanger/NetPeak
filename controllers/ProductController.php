<?php

namespace controllers;

include_once './repositories/ProductRepository.php';
include_once './rules/BlackListSymbolsInterface.php';
include_once './rules/ImageTypesInterface.php';

use database\Connection;
use repositories\ProductRepository;
use rules\BlackListSymbolsInterface;
use rules\ImageTypesInterface;
use PDO;


/**
 * Class ProductController
 * @package controllers
 */
class ProductController implements BlackListSymbolsInterface, ImageTypesInterface
{
    /**
     * @var PDO
     */
    private $db;
    /**
     * @var
     */
    private $connection;

    /**
     * ProductController constructor.
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->setConnection();
    }

    /**
     * @param $data
     * @return array
     */
    public function create($data)
    {
        $errors = $this->validate($data);
        if (count($errors)) {
            return $errors;
        }
        $this->connection->create($data);
        return $errors;
    }

    public function validate(&$data)
    {
        $errors = [];
        $image_dir = './images/';
        if ($_FILES['uploadImage']['error'] == 0) {
            if (in_array($_FILES['uploadImage']['type'], self::ACCEPT_IMAGE_TYPES)) {
                move_uploaded_file($_FILES['uploadImage']['tmp_name'], $image_dir . $_FILES['uploadImage']['name']);
                $data['image'] = $image_dir . $_FILES['uploadImage']['name'];
            } else {
                $errors['uploadImage'] = 'File type unsupported';
            }
        } else {
            $data['image'] = $data['link'];
        }

        $data = str_replace(self::BLACK_LIST, "", $data);
        if (!isset($data['product_name']) || empty($data['product_name'])) {
            $errors['product_name'] = 'Product name is required! ';
        }
        if (isset($data['product_name']) && strlen($data['product_name']) > 128) {
            $errors['product_name'] .= 'Product name should be less than 128 symbols! ';
        }
        if (isset($data['link']) && strlen(trim($data['link'])) > 255) {
            $errors['link'] = 'Link too long! Need less than 255 symbols! ';
        }
        if (!isset($data['creator_name']) || empty($data['creator_name'])) {
            $errors['creator_name'] = 'Message is required! ';
        }
        if (isset($data['creator_name']) && strlen($data['creator_name']) > 64) {
            $errors['creator_name'] .= 'Creator name should be less than 64 symbols! ';
        }
        if (!isset($data['avg_price']) || empty($data['avg_price'])) {
            $errors['avg_price'] .= 'Price is required!';
        }
        if (isset($data['avg_price']) && !is_numeric($data['avg_price'])) {
            $errors['avg_price'] .= 'Price should be a number! ';
        }

        return $errors;
    }

    public function update($data)
    {
        $errors = $this->validate($data);
        if (count($errors)) {
            return $errors;
        }
        $this->connection->update($data);
        return $errors;
    }

    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->connection->delete($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function getDataById($id)
    {
        return $this->connection->getProductById($id);
    }

    /**
     * @param string $column
     * @param string $sortRule
     * @return mixed
     */
    public function sortByColumn(string $column, $sortRule = 'desc')
    {
        return $this->connection->sortByColumn($column, $sortRule);
    }

    /**
     *
     */
    public function setConnection()
    {
        $this->connection = new ProductRepository($this->db);
    }

    /**
     * @return mixed
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param array $records
     * @return string
     */
    public function generateTable($records = [])
    {
        if (empty($records)) {
            return 'Data not found';
        }
        $tableFirstPart = '<tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Creator</th>
                        <th>Price</th>
                        <th>Creation Date</th>
                        <th>Comments amount</th>
                        <th>Image</th>
                        <th>Page</th>
                        </tr>';
        $tableMiddlePart = '';
        foreach ($records as $data) {
            $id = $data['id'];
            $link = '<a href=' . "/ProductPage.php?page=$id" . '>See More</a>';
            $tableMiddlePart .= '<tr><td>' . $id . '<td>' . $data['product_name'] . '</td>' . '<td>' . $data['creator_name'] . '</td>'
                . '<td>' . $data['avg_price'] . '</td>'
                . '<td>' . $data['created_at'] . '</td>'
                . '<td>' . $data['comments_amount'] . '</td>'
                . '<td><img width="38" height=54" src=' . $data['image'] . '></td>'
                . '<td><button id=filmPage' . ' name=' . $id . ">$link</button></td>"
                . '</tr>';
        }
        return $tableFirstPart . $tableMiddlePart;
    }

}
