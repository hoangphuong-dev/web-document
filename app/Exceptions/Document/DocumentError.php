<?php

namespace App\Exceptions\Document;

use Exception;
use ReturnTypeWillChange;
use Throwable;

class DocumentError extends Exception
{
    public function __construct($message = 'Tài liệu bị lỗi, vui lòng liên hệ admin', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    #[ReturnTypeWillChange] public function __toString()
    {
        return $this->message;
    }
}
