<?php

namespace controllers;

include_once './repositories/CommentRepository.php';
include_once './rules/BlackListSymbolsInterface.php';

use database\Connection;
use repositories\CommentRepository;
use rules\BlackListSymbolsInterface;
use PDO;


/**
 * Class CommentController
 * @package controllers
 */
class CommentController implements BlackListSymbolsInterface
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
     * CommentController constructor.
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


    /**
     * @param $id
     * @return mixed
     */
    public function getDataById($id)
    {
        return $this->connection->getRecordById($id);
    }

    /**
     *
     */
    public function setConnection()
    {
        $this->connection = new CommentRepository($this->db);
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
            return 'Comments not found';
        }
        $tableFirstPart = '<tr>
                        <th>Id</th>
                        <th>Commentator</th>
                        <th>Mark</th>
                        <th>Message</th>
                        <th>Creation Date</th>
                        </tr>';
        $tableMiddlePart = '';
        foreach ($records as $data) {
            $tableMiddlePart .= '<tr><td>' . $data['id'] . '<td>' . $data['commentator_name'] . '</td>' . '<td>' . $data['mark'] . '</td>'
                . '<td>' . $data['message'] . '</td>'
                . '<td>' . $data['created_at'] . '</td>'
                . '</tr>';
        }
        return $tableFirstPart . $tableMiddlePart;
    }

}
