<?php

namespace Util;

use InvalidArgumentException;
use JsonException as JsonExceptionAlias;

class JsonUtil 
{


    public function processDataToReturn($response)
    {
        $data = [];

        $data[ConstantsGenericsUtil::STATUS] = ConstantsGenericsUtil::TYPE_ERROR;

        if (is_array($response) && count($response) > 0 || strlen($response) > 10) {
            $data[ConstantsGenericsUtil::STATUS] = ConstantsGenericsUtil::TYPE_SUCCESS;
            $data[ConstantsGenericsUtil::RESPONSE] = $response;
        }

        $this->returnJson($data);
    }

    private function returnJson($json)
    {
        header('Content-Type: application/json');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Access-Control-Allow-Methods: GET,POST,PUT,DELETE');
        echo json_encode($json);
        exit;
    }

    public static function getBodyReq()
    {

        try {
            $jsonPost = json_decode(file_get_contents('php://input'), true);
        } catch (JsonExceptionAlias $exception) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_JSON_NULL);
        }

        if (is_array($jsonPost) && count($jsonPost) > 0) {
            return $jsonPost;
        }

        return [];

    }


}

