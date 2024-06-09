<?php

namespace App\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    protected $message;
    protected $code;

    public function render()
    {
        return response()->json(['message' => $this->message], $this->code);
    }
}
