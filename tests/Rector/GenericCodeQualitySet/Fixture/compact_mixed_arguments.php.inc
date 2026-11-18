<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class CompactMixedArguments
{
    public function someMethod(): array
    {
        $a = 1;
        $b = 2;
        $c = 3;

        return compact(['a', ['b']], 'c', 'a');
    }
}

?>
-----
<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class CompactMixedArguments
{
    public function someMethod(): array
    {
        $a = 1;
        $b = 2;
        $c = 3;

        return ['a' => $a, 'b' => $b, 'c' => $c];
    }
}

?>
