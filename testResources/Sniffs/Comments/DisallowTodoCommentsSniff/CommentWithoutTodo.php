<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Comments\DisallowTodoCommentsSniff;

class CommentWithoutTodo
{
    public function someMethod(): void
    {
        // Comment is allowed
    }
}
