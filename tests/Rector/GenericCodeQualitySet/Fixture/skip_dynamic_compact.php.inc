<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class SkipDynamicCompact
{
    public function someMethod(string $name, array $names): array
    {
        $a = 1;

        return [compact($name), compact('a', $name), compact(...$names), compact(['a', $name]), compact(), compact(...)];
    }
}

?>
