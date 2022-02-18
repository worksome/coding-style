<?php

use Symplify\SmartFileSystem\SmartFileInfo;

it('can remove disallowed attributes', function () {
    $this->doTestFileInfo(
        new SmartFileInfo(__DIR__ . '/Fixture/class_with_disallowed_attribute.php.inc')
    );
});

it('does not remove allowed attributes', function () {
    $this->doTestFileInfo(
        new SmartFileInfo(__DIR__ . '/Fixture/class_with_allowed_attribute.php.inc')
    );
});

it('only deletes disallowed attribute from attribute group', function () {
    $this->doTestFileInfo(
        new SmartFileInfo(__DIR__ . '/Fixture/class_with_disallowed_attribute_in_group.php.inc')
    );
});
