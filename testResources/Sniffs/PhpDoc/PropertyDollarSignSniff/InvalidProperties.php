<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\PhpDoc\PropertyDollarSignSniff;

/**
 * @property string foo
 * @property int bar
 * @property bar works well
 * @property Collection<int, callable(string): bool|null> boom This is a collection
 * @property array{foo: string, bar: array<int, string>} | null bam This is a collection
 * @property-read foo
 * @property string[] whoops
 * @property positive-int nice_int
 * @property non-empty-array<\Exception> non_empty_array
 * @property ABC|EFG union_type
 * @property ABC&EFG intersection_type
 */
class InvalidProperties
{

}
