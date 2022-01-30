<?php

namespace Util;

abstract class ConstantsGenericsUtil
{
    /* REQUESTS */
    public const TYPE_REQUEST = ['GET', 'POST', 'DELETE', 'PUT'];
    public const TYPE_GET = ['tasks'];
    public const TYPE_POST = ['tasks'];
    public const TYPE_DELETE = ['tasks'];
    public const TYPE_PUT = ['tasks'];

    /* ERROS */
    public const MSG_ERROR_TYPE_ROUTE = 'Rota não permitida!';
    public const MSG_ERROR_INVALID_RESOURCE = 'Recurso inexistente!';
    public const MSG_ERROR_GENERIC = 'Algum erro ocorreu na requisição!';
    public const MSG_ERROR_NO_RETURN = 'Nenhum registro encontrado!';
    public const MSG_ERROR_NOT_FETCH = 'Nenhum registro afetado!';
    public const MSG_ERROR_TOKEN_NULL = 'É necessário informar um Token!';
    public const MSG_ERROR_TOKEN_UNAUTHORIZED = 'Token não autorizado!';
    public const MSG_ERROR_JSON_NULL = 'O Corpo da requisição não pode ser vazio!';

    /* SUCESSO */
    public const MSG_DELETED_SUCCESSFULLY = 'Registro deletado com Sucesso!';
    public const MSG_UPDATED_SUCCESSFULLY = 'Registro atualizado com Sucesso!';

    /* RECURSO USUARIOS */
    public const MSG_ERROR_ID_REQUIRED = 'ID é obrigatório!';
    public const MSG_ERROR_LOGIN_EXISTS_ALREAY = 'Login já existente!';
    public const MSG_ERROR_TASKS_DATA_REQUIRED = 'Dados de tarefa são obrigatórios!';

    /* RETORNO JSON */
    const TYPE_SUCCESS = 'sucess';
    const TYPE_ERROR = 'error';

    /* OUTRAS */
    public const YES = 'S';
    public const STATUS = 'status';
    public const RESPONSE = 'response';
}