<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/** @property Collection<int, Model> $models */
class ClassWithAllowedCollectionSyntax {}

?>
