<?php

use Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource\DisallowPartialRouteFacadeResourceRule;
use Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource\DisallowPartialRouteVariableResourceRule;
use Worksome\CodingStyle\PHPStan\Laravel\DisallowPartialRouteResource\PartialRouteResourceInspector;

it('checks for partial route facade resources', function (string $path, array ...$errors) {
    $this->rule = new DisallowPartialRouteFacadeResourceRule(new PartialRouteResourceInspector());

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
    'calls except at end of method chain' => [
        __DIR__ . '/Fixture/route_resource_with_except_after_after_chain.php.inc',
        [
            'Usage of [except] method on route resource is disallowed. Please split the resource into multiple routes.',
            5
        ]
    ],
    'calls complete route resource' => [
        __DIR__ . '/Fixture/route_resource.php.inc'
    ],
]);

it('checks for partial route variable resources', function (string $path, array ...$errors) {
    $this->rule = new DisallowPartialRouteVariableResourceRule(new PartialRouteResourceInspector());

    expect($path)->toHaveRuleErrors($errors);
})->with([
    'calls grouped resource' => [
        __DIR__ . '/Fixture/grouped_route_resource_with_except.php.inc',
        [
            'Usage of [except] method on route resource is disallowed. Please split the resource into multiple routes.',
            6
        ],
        [
            'Usage of [only] method on route resource is disallowed. Please split the resource into multiple routes.',
            7
        ]
    ],
    'calls complete route resource' => [
        __DIR__ . '/Fixture/route_resource.php.inc',
    ],
]);