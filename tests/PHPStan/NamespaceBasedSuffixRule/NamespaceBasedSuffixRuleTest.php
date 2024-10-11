<?php

namespace Worksome\CodingStyle\Tests\PHPStan\NamespaceBasedSuffixRule;

use Worksome\CodingStyle\PHPStan\NamespaceBasedSuffixRule;

it('checks app helper rule', function (string $path, array ...$errors) {
    $this->rule = new NamespaceBasedSuffixRule([
        'App\\Events' => 'Event',
    ]);

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'has namespace' => [
        __DIR__ . '/Fixture/fixture.php.inc',
        [
            'Classes in namespace App\\Events should always be suffixed with Event.',
            5,
        ],
    ],
    'has other namespace' => [
        __DIR__ . '/Fixture/skip_non_event_namespace.php.inc',
    ],
    'has namespace and suffix' => [
        __DIR__ . '/Fixture/skip_suffix_event.php.inc',
    ],
    'has namespace, but is anonymous class' => [
        __DIR__ . '/Fixture/skip_annonymous_class_in_namespace.php.inc',
    ],
]);
