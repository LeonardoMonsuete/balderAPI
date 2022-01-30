<?php

namespace Repository;

use DB\MySQL;
use InvalidArgumentException;
use Util\ConstantsGenericsUtil;

class AuthorizedTokensRepository
{
    private object $MySQL;
    private const TABELA = 'tokens_autorizados';

    public function __construct()
    {
        $this->MySQL = new MySQL();
    }

    /**
     * @param mixed $token
     * 
     * @return void
     */
    public function tokenValidator($token) 
    {
        $token = trim(str_replace("Bearer", "", $token));

        if (!$token) {
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_TOKEN_NULL);
        }

        $tokenQuery = 'SELECT * FROM ' . seLF::TABELA . ' WHERE token = :token and status = :status';
        $db = $this->getMySQL()->getDb();
        $stmt = $db->prepare($tokenQuery);
        $stmt->bindValue(':token', $token);
        $stmt->bindValue(':status', ConstantsGenericsUtil::YES);
        $stmt->execute();
        
        if ($stmt->rowCount() !== 1){
            header('HTTP/1.1 401 Unauthorized');
            throw new InvalidArgumentException(ConstantsGenericsUtil::MSG_ERROR_TOKEN_UNAUTHORIZED);
        }

    }

    /**
     * @return object
     */
    public function getMySQL()
    {
        return $this->MySQL;
    }



}