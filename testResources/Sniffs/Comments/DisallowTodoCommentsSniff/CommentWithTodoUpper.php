<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Comments\DisallowTodoCommentsSniff;

class CommentWithTodoUpper
{
    public function someMethod(): void
    {
        // TODO is not allowed
    }
}
