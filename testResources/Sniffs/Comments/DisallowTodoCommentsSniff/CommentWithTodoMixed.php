<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Comments\DisallowTodoCommentsSniff;

class CommentWithTodoMixed
{
    public function someMethod(): void
    {
        // ToDo is not allowed
    }
}
