<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Collection<int, Model> $models_valid (ensures valid syntax is not touched)
 * @property Collection|Model[] $models_invalid_a
 * @property \Illuminate\Database\Eloquent\Collection|Model[] $models_invalid_b
 * @property EloquentCollection|Model[] $models_invalid_c
 */
class ClassWithAllowedCollectionSyntax {}

?>
-----
<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Database\Eloquent\Model;

/**
 * @property Collection<int, Model> $models_valid (ensures valid syntax is not touched)
 * @property Collection<int, Model> $models_invalid_a
 * @property \Illuminate\Database\Eloquent\Collection<int, Model> $models_invalid_b
 * @property EloquentCollection<int, Model> $models_invalid_c
 */
class ClassWithAllowedCollectionSyntax {}

?>
