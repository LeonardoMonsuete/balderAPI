<?php

namespace Service;

use InvalidArgumentException;
use Repository\TasksRepository;
use Util\ConstantsGenericsUtil;

class TasksService 
{

    const TABELA = 'tasks';
    const RESOURCES_GET = ['list'];
    const RESOURCES_DELETE = ['delete'];
    const RESOURCES_POST = ['insert'];
    const RESOURCES_PUT = ['update'];
    /**
     * @var array
     */
    private array $data;
    /**
     * @var array
     */
    private array $requestData = [];
    /**
     * @var object
     */
    private object $tasksRepository;

    /**
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->tasksRepository = new TasksRepository();
    }

    /**
     * @return array
     */
    public function getValidation() 
    {
        $response = null;
        $resource = $this->data['resource'];

        if (!in_array($resource, self::RESOURCES_GET, true)) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_GENERIC);
        }
        
        $response = $this->returnData($resource);

        $this->requestResponseValidation($response);
        
        return $response;
    }

    /**
     * @return array
     */
    public function postValidation() 
    {
        $response = null;
        $resource = $this->data['resource'];

        if (!in_array($resource, self::RESOURCES_POST, true)) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
        }

        $response = $this->$resource();

        $this->requestResponseValidation($response);

        return $response;
    }

    /**
     * @return array
     */
    public function deleteValidation() 
    {
        $response = null;
        $resource = $this->data['resource'];

        if (!in_array($resource, self::RESOURCES_DELETE, true)) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
        }

        if (!$this->data['id'] > 0) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_ID_REQUIRED);
        }
        $response = $this->$resource();

        $this->requestResponseValidation($response);

        return $response;
    }

    /**
     * @return array
     */
    public function putValidation() 
    {
        $response = null;
        $resource = $this->data['resource'];

        if (!in_array($resource, self::RESOURCES_PUT, true)) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
        }

        if (!$this->data['id'] > 0) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_ID_REQUIRED);
        }
        $response = $this->$resource();

        if ($response === null) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_GENERIC);
        }

        return $response;
    }


    /**
     * @param mixed $dataRequest
     * 
     * @return void
     */
    public function setBodyDataRequest($dataRequest)
    {
        $this->requestData = $dataRequest;
    }

    /**
     * @return array
     */
    private function getOneByKey()
    {
        return $this->tasksRepository->getMySQL()->getOneByKey(self::TABELA, $this->data['id']);
    }

    /**
     * @return array
     */
    private function list()
    {
        return $this->tasksRepository->getMySQL()->getAll(self::TABELA);
    }

    /**
     * @return string
     */
    private function delete()
    {
        return $this->tasksRepository->getMySQL()->delete(self::TABELA, $this->data['id']);
    }

    /**
     * @return int
     */
    private function insert()
    {
        [$description, $status] = [$this->requestData['description'], $this->requestData['status']];

        if ($description != '' && $status != '' ) {
            
            if ($this->tasksRepository->insertTask(['description' => $description, 'status' => $status]) > 0) {
                $lastInsertId = $this->tasksRepository->db->lastInsertId();
                $this->tasksRepository->db->commit();
                return ['insertedId' => $lastInsertId];
            }

            $this->tasksRepository->db->rollBack();
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_GENERIC);
        }

        throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_TASKS_DATA_REQUIRED);
    }

    /**
     * @return string
     */
    private function update()
    {
        [$description, $status] = [$this->requestData['description'], $this->requestData['status']];

        if ($this->tasksRepository->updateTask($this->data['id'], ['description' => $description, 'status' => $status]) === 1) {
            $this->tasksRepository->db->commit();
            return ConstantsGenericsUtil::MSG_UPDATED_SUCCESSFULLY;
        }

        if ($this->tasksRepository->updateTask($this->data['id'], ['description' => $description, 'status' => $status]) > 1) {
            $this->tasksRepository->db->rollBack();
            throw new InvalidArgumentException('Mais de um ID encontrado, alteração não realizada !');
        }

        $this->tasksRepository->db->rollBack();
        throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_NOT_FETCH);
    }


    /**
     * @param mixed $resource
     * 
     * @return mixed
     */
    private function returnData($resource)
    {
        return $this->data['id'] > 0 ? $this->getOneByKey() : $this->$resource();
    }

    /**
     * @param mixed $response
     * 
     * @return mixed
     */
    private function requestResponseValidation($response)
    {
        if ($response === null) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_GENERIC);
        }
    }

}