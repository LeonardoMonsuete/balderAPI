<?php

use Util\ConstantsGenericsUtil;
use Util\JsonUtil;
use \Util\RotasUtil;
use Validator\RequestValidator;

include "bootstrap.php";

try {
    $requestValidator = new RequestValidator(RotasUtil::getRoutes());    
    $return = $requestValidator->processRequest();

    $jsonUtil = new JsonUtil();
    $jsonUtil->processDataToReturn($return);


} catch (Exception $e) {
    
    echo json_encode([
        ConstantsGenericsUtil::STATUS => ConstantsGenericsUtil::TYPE_ERROR,
        ConstantsGenericsUtil::RESPONSE => $e->getMessage()
    ]);
}
