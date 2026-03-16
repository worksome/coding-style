<?php

namespace Worksome\CodingStyle\Tests\Rector\DisallowedAttributesRector\Fixture;

use JetBrains\PhpStorm\Pure;

class ClassWithDisallowedAttributeInGroup {
    #[Pure, Other]
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

class ClassWithDisallowedAttributeInGroup {
    #[Other]
    public function pureMethod()
    {
        return true;
    }
}

?>
