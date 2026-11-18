<?php

namespace App\Exceptions;

class WrongExceptionName extends \InvalidArgumentException implements \Stringable
{
    public function __toString(): string
    {
        return $this->getMessage();
    }
}
