<?php

namespace Repository;

use DB\MySQL;

class TasksRepository
{
    private object $MySQL;
    public object $db;
    private const TABELA = 'tasks';

    public function __construct()
    {
        $this->MySQL = new MySQL();
        $this->db = $this->MySQL->getDb();
    }

    /**
     * @param mixed $data
     * 
     * @return int
     */
    public function insertTask($data)
    {
       
        $query = 'INSERT INTO ' . self::TABELA . ' (description, status) VALUES (:description, :status)';

        $this->db->beginTransaction();
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @param mixed $id
     * @param mixed $data
     * 
     * @return int
     */
    public function updateTask($id, $data)
    {

        $query = 'UPDATE ' . self::TABELA . ' SET description = :description, status = :status WHERE id = :id';

        $this->db->beginTransaction();
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':description', $data['description']);
        $stmt->bindParam(':status', $data['status']);
        $stmt->execute();

        return $stmt->rowCount();
    }

    /**
     * @return object
     */
    public function getMySQL()
    {
        return $this->MySQL;
    }

}