<?php

use Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResourceRule;

it('checks for partial route resources', function (string $path, array ...$errors) {
    $this->rule = new DisallowPartialRouteResourceRule();

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'calls route resource with except' => [
        __DIR__ . '/Fixture/route_resource_with_except.php.inc',
        [
            'Usage of [except] method on route resource is disallowed. Please split the resource into multiple routes.',
            5
        ]
    ],
    'calls route resource with only' => [
        __DIR__ . '/Fixture/route_resource_with_only.php.inc',
        [
            'Usage of [only] method on route resource is disallowed. Please split the resource into multiple routes.',
            5
        ]
    ],
    'calls API route resource with except' => [
        __DIR__ . '/Fixture/api_route_resource_with_except.php.inc',
        [
            'Usage of [except] method on route resource is disallowed. Please split the resource into multiple routes.',
            5
        ]
    ],
    'calls complete route resource' => [
        __DIR__ . '/Fixture/route_resource.php.inc'
    ],
]);
