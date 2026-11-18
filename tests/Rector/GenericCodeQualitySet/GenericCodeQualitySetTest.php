<?php

it('replaces `compact` calls with arrays', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/compact_call.php.inc'
    );
});

it('keeps every argument when replacing `compact` calls', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/compact_mixed_arguments.php.inc'
    );
});

it('does not replace `compact` calls with dynamic names', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/skip_dynamic_compact.php.inc'
    );
});

it('does not change code without `compact` calls', function () {
    $this->doTestFile(
        __DIR__ . '/Fixture/no_compact_call.php.inc'
    );
});
