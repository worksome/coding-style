<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

class ClassWithAllowedAttribute {
    #[Something]
    public function pureMethod()
    {
        return true;
    }
}

?>
