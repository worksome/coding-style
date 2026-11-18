<?php

namespace Worksome\CodingStyle\Tests\PHPStan\DisallowTodoCommentsRule;

use Worksome\CodingStyle\PHPStan\DisallowTodoCommentsRule;

it('disallows TODO comments', function (string $path, array ...$errors) {
    $this->rule = new DisallowTodoCommentsRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'comments with TODO' => [
        __DIR__ . '/Fixture/todo_comments.php.inc',
        ['Comments with TODO are disallowed.', 5],
        ['Comments with TODO are disallowed.', 12],
        ['Comments with TODO are disallowed.', 16],
        ['Comments with TODO are disallowed.', 17],
        ['Comments with TODO are disallowed.', 18],
    ],
    'comments without TODO' => [
        __DIR__ . '/Fixture/skip_no_todo_comments.php.inc',
    ],
    'file without TODO anywhere' => [
        __DIR__ . '/Fixture/skip_no_matching_text.php.inc',
    ],
]);
