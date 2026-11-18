<?php

it('replaces `compact` calls with arrays', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/compact_call.php.inc'
    );
});

it('does not change code without `compact` calls', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/no_compact_call.php.inc'
    );
});
