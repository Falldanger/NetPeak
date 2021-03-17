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
        $data = str_replace(self::BLACK_LIST, "", $data);
        if (!isset($data['commentator_name']) || empty($data['commentator_name'])) {
            $errors['commentator_name'] = 'Name is required! ';
        }
        if (isset($data['commentator_name']) && strlen($data['commentator_name']) > 64) {
            $errors['commentator_name'] .= 'Name should be less than 64 symbols! ';
        }
        if (!isset($data['mark']) || empty($data['mark'])) {
            $errors['mark'] = 'Mark is required! ';
        }
        if (isset($data['mark']) && !is_numeric($data['mark'])) {
            $errors['mark'] = 'Mark should be a number! ';
        }
        if (!isset($data['message']) || strlen(trim($data['message'])) == 0) {
            $errors['message'] = 'Message are required! ';
        }

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
