<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Comments\DisallowTodoCommentsSniff;

class PhpdocWithTodo
{
    /**
     * TODO phpdoc not allowed
     *
     * @return void
     */
    public function someMethod(): void
    {
    }
}
