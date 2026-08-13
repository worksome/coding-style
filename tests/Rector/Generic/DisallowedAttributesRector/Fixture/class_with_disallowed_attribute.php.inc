<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

use JetBrains\PhpStorm\Pure;

class ClassWithDisallowedAttribute {
    #[Pure]
    public function pureMethod()
    {
        return true;
    }
}

?>
-----
<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

use JetBrains\PhpStorm\Pure;

class ClassWithDisallowedAttribute {
    public function pureMethod()
    {
        return true;
    }
}

?>
