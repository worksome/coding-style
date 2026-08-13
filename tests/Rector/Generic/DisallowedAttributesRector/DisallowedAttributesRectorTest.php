<?php

it('can remove disallowed attributes', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/class_with_disallowed_attribute.php.inc'
    );
});

it('does not remove allowed attributes', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/class_with_allowed_attribute.php.inc'
    );
});

it('only deletes disallowed attribute from attribute group', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/class_with_disallowed_attribute_in_group.php.inc'
    );
});
