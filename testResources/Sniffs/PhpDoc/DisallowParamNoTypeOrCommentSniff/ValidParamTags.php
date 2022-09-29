<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\PhpDoc\DisallowParamNoTypeOrCommentSniff;


class ParamNoTypeOrComment
{
    /**
     * @param string $name
     * @param $type some random type
     * @param array $other
     * @param array $last with comment
     */
    public function someMethod($name, $type, $other, $last): void
    {
    }
}