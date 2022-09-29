<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\PhpDoc\DisallowParamNoTypeOrCommentSniff;


class ParamNoTypeOrComment
{
    /**
     * @param string $name
     * @param $type some random type
     */
    public function someMethod($name, $type, $other): void
    {
    }
}