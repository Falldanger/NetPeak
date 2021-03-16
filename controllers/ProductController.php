<?php

namespace controllers;

include_once './repositories/ProductRepository.php';
include_once './rules/BlackListSymbolsInterface.php';

use database\Connection;
use repositories\ProductRepository;
use rules\BlackListSymbolsInterface;
use PDO;


/**
 * Class ProductController
 * @package controllers
 */
class ProductController implements BlackListSymbolsInterface
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

    public function validate($data)
    {
        $errors = [];
//        $data = str_replace(self::BLACK_LIST, "", $data);
//        if (!isset($data['reviewer_name']) || empty($data['reviewer_name'])) {
//            $errors['reviewer_name'] = 'Name is required! ';
//        }
//        if (!isset($data['reviewer_email']) || empty($data['reviewer_email'])) {
//            $errors['reviewer_email'] = 'Email is required! ';
//        }
//        if (!isset($data['message']) || strlen(trim($data['message'])) == 0) {
//            $errors['message'] = 'Message are required! ';
//        }
//        if (isset($data['reviewer_name']) && strlen($data['reviewer_name']) > 32) {
//            $errors['reviewer_name'] .= 'Name should be less than 32 symbols! ';
//        }
//        if (isset($data['reviewer_email']) && strlen($data['reviewer_email']) > 128) {
//            $errors['reviewer_email'] .= 'Email should be less than 128 symbols! ';
//        }
//        if (isset($data['reviewer_email']) && (!filter_var($data['reviewer_email'], FILTER_VALIDATE_EMAIL))) {
//            $errors['reviewer_email'] .= 'Email not valid!';
//        }

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
                . '<td>' . $data['created_at'] . '</td>'
                . '<td>' . $data['comments_amount'] . '</td>'
                . '<td><img width="38" height=54" src=' . $data['image'] . '></td>'
                . '<td><button id=filmPage' . ' name=' . $id . ">$link</button></td>"
                . '</tr>';
        }
        return $tableFirstPart . $tableMiddlePart;
    }

}
