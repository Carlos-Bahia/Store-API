<?php

namespace App\Exceptions;

use Exception;

class CategoryException extends Exception
{
    public function __construct($message = "Categoria não encontrada", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->code;
    }
}
