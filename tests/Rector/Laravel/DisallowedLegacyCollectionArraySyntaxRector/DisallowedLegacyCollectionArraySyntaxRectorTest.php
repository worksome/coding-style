<?php

it('can replace disallowed Collection syntax', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/class_with_disallowed_collection_syntax.php.inc'
    );
});

it('does not replace allowed Collection syntax', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/class_with_allowed_collection_syntax.php.inc'
    );
});
