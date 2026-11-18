<?php

namespace App;

// TODO: upper case

class CommentsWithTodo
{
    /**
     * Some description.
     *
     * @todo phpdoc tag
     */
    public function someMethod(): void
    {
        // ToDo: mixed case
        $foo = 1; # todo: hash comment
        /* todo: block comment */
    }
}
