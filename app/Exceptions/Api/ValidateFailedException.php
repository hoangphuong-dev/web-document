<?php

namespace App\Exceptions\Api;

use Exception;

class ValidateFailedException extends Exception
{
    public function __construct(string $message = '', int $code = 302, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public function __toString()
    {
        parent::__toString();

        return json_encode([
            'code' => $this->getCode(),
            'message' => $this->getMessage(),
            'data' => [],
        ]);
    }
}
