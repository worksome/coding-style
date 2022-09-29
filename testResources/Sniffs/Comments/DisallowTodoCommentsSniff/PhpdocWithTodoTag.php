<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Comments\DisallowTodoCommentsSniff;

class PhpdocWithTodoTag
{
    /**
     * @TODO phpdoc not allowed
     *
     * @return void
     */
    public function someMethod(): void
    {
    }
}
