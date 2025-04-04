<?php

namespace App\Exceptions\Payment;

use Exception;
use ReturnTypeWillChange;
use Throwable;

class NotEnoughMoney extends Exception
{
    public function __construct($message = 'Giao dịch này chưa thanh toán đủ số tiền', $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    #[ReturnTypeWillChange] public function __toString()
    {
        return $this->message;
    }
}
