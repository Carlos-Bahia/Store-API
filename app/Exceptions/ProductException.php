<?php

namespace App\Exceptions;

use Exception;

class ProductException extends Exception
{
    public function __construct($message = "Produto não encontrado", $code = 404, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->code;
    }
}
