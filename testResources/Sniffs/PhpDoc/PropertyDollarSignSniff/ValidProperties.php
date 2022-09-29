<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\PhpDoc\PropertyDollarSignSniff;

/**
 * @property array<string, string> $foo
 * @property array<string,string> $bam
 * @property array{foo: string, bar: int} $foobar
 * @property string $bar
 * @property int $baz that is really cool
 * @property string|int $foz
 * @property $for kinda cool
 * @property $far
 * @property int    $test
 * @property int[] $integers
 * @property string|int[] $stringsOrIntegers
 * @property \Illuminate\Support\Collection $myCollection
 */
class ValidProperties
{

}
