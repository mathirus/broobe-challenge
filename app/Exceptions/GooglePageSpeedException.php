<?php

namespace App\Exceptions;

use Exception;

class GooglePageSpeedException extends Exception
{
    public function __construct($message = "Error al obtener métricas de Google PageSpeed Insights.", $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
