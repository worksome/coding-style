<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Comments\DisallowTodoCommentsSniff;

class CommentWithTodoLower
{
    public function someMethod(): void
    {
        // todo is not allowed
    }
}
