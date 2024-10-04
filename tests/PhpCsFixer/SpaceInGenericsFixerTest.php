<?php

declare(strict_types=1);

use Worksome\CodingStyle\PhpCsFixer\SpaceInGenericsFixer;

beforeEach(fn () => $this->setFixer(new SpaceInGenericsFixer()));

it('is not a risky test', function () {
    expect($this->fixer->isRisky())->toBeFalse();
});

/** @link https://github.com/kubawerlos/php-cs-fixer-custom-fixers Modified from "PhpdocTypesCommaSpacesFixerTest" */
it('works as expected', function (string $expected, string|null $input = null) {
    $this->doTest($expected, $input);
})->with(function () {
    yield ['<?php /** @var int $commaCount Number of "," in text. */'];

    yield [
        '<?php /** @var array<int, string> */',
        '<?php /** @var array<int,string> */',
    ];

    yield [
        '<?php /** @var array<int, string> */',
        '<?php /** @var array<int    ,    string> */',
    ];

    yield [
        '<?php
                /** @var array<int, string> $a */
                /** @var array<int, string> $b */
                /** @var array<int, string> $c */
                /** @var array<int, string> $d */
            ',
        '<?php
                /** @var array<int    ,string> $a */
                /** @var array<int,    string> $b */
                /** @var array<int, string> $c */
                /** @var array<int    ,    string> $d */
            ',
    ];

    yield [
        '<?php /**
                    * @param array<int, string> $a
                    * @param array<int, string> $b
                    * @param array<int, string> $c
                    * @param array<int, array<int, array<int, string>>> $d
                    */',
        '<?php /**
                    * @param array<int,string> $a
                    * @param array<int ,string> $b
                    * @param array<int , string> $c
                    * @param array<int    ,    array<int    ,    array<int    ,    string>>> $d
                    */',
    ];

    yield [
        '<?php /**
                    * @return array<    Foo, Bar, Baz    >
                    */',
        '<?php /**
                    * @return array<    Foo    ,    Bar    ,    Baz    >
                    */',
    ];

    yield [
        '<?php /**
                    * The "," in here should not be touched
                    *
                    * @param array<int, int> $x Comma in type should be fixed, but this one: "," should not
                    * @param array<int, int> $y Comma in type should be fixed, but this one: "," and "," should not
                    *
                    * @return array<string, Foo> Description having "," should not be touched
                    */',
        '<?php /**
                    * The "," in here should not be touched
                    *
                    * @param array<int,int> $x Comma in type should be fixed, but this one: "," should not
                    * @param array<int , int> $y Comma in type should be fixed, but this one: "," and "," should not
                    *
                    * @return array<string,Foo> Description having "," should not be touched
                    */',
    ];
});
