<?php

namespace Worksome\CodingStyle\Tests\Rector\GenericCodeQualitySet\Fixture;

class SkipPossiblyUndefinedCompact
{
    public function someMethod(bool $condition): array
    {
        $checkout = 1;

        if ($condition) {
            $form = 2;
        }

        return compact('checkout', 'form');
    }
}

?>
