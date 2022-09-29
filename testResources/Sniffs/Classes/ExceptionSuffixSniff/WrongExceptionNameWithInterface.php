<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Classes\ExceptionSuffixSniff\App;

use Exception;
use Stringable;

class WrongExceptionName extends Exception implements Stringable
{

}
