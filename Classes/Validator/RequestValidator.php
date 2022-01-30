<?php

namespace Validator;

use InvalidArgumentException;
use Repository\AuthorizedTokensRepository;
use Service\TasksService;
use Util\ConstantsGenericsUtil;
use Util\jsonUtil;

class RequestValidator 
{
    /**
     * @var array
     */
    private array $request;
    /**
     * @var array
     */
    private array $requestData = [];
    /**
     * @var object
     */
    private object $AuthorizedTokensRepository;
    const GET = 'GET';
    const DELETE = 'DELETE';
    const TASKS = 'tasks';
    /**
     * @param mixed $request
     */
    public function __construct($request)
    {
        $this->request = $request;
        $this->AuthorizedTokensRepository = new AuthorizedTokensRepository();
    }

    /**
     * @return mixed
     */
    public function processRequest()
    {
        $return = ConstantsGenericsUtil::MSG_ERROR_TYPE_ROUTE;
        if (in_array($this->request['method'], ConstantsGenericsUtil::TYPE_REQUEST, true)) {
            $return = $this->requestRedirect();
        }
        return $return;
    }

    /**
     * @return string
     */
    private function requestRedirect()
    {
        if ($this->request['method'] !== self::GET && $this->request['method'] !== self::DELETE) {
            $this->requestData = jsonUtil::getBodyReq();
        }

        $this->AuthorizedTokensRepository->tokenValidator(getallheaders()['Authorization']);
        $method = $this->request['method'];  

        return $this->$method();

    }

    /**
     * @return mixed
     */
    private function get()
    {
        $return = ConstantsGenericsUtil::MSG_ERROR_TYPE_ROUTE;

        if (in_array($this->request['route'], ConstantsGenericsUtil::TYPE_GET, true)) {
            switch ($this->request['route']) {
                case self::TASKS:
                    $taskService = new TasksService($this->request);
                    $return = $taskService->getValidation();
                    break;
                
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
                    break;
            }
        }

        return $return;
    }

    /**
     * @return mixed
     */
    private function delete()
    {
        $return = ConstantsGenericsUtil::MSG_ERROR_TYPE_ROUTE;
        if (in_array($this->request['route'], ConstantsGenericsUtil::TYPE_DELETE, true)) {
            switch ($this->request['route']) {
                case self::TASKS:
                    $taskService = new TasksService($this->request);
                    $return = $taskService->deleteValidation();
                    break;
                
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
                    break;
            }
        }

        return $return;
    }

    /**
     * @return mixed
     */
    private function post()
    {
        $return = ConstantsGenericsUtil::MSG_ERROR_TYPE_ROUTE;
        if (in_array($this->request['route'], ConstantsGenericsUtil::TYPE_POST, true)) {
            switch ($this->request['route']) {
                case self::TASKS:
                    $taskService = new TasksService($this->request);
                    $taskService->setBodyDataRequest($this->requestData);
                    $return = $taskService->postValidation();
                    break;
                
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
                    break;
            }
        }

        return $return;
    }

    /**
     * @return mixed
     */
    private function put()
    {
        $return = ConstantsGenericsUtil::MSG_ERROR_TYPE_ROUTE;
        if (in_array($this->request['route'], ConstantsGenericsUtil::TYPE_PUT, true)) {
            switch ($this->request['route']) {
                case self::TASKS:
                    $taskService = new TasksService($this->request);
                    $taskService->setBodyDataRequest($this->requestData);
                    $return = $taskService->putValidation();   
                    break;
                
                default:
                    throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_INVALID_RESOURCE);
                    break;
            }
        }

        return $return;
    }

}