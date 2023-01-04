<?php

use Illuminate\Contracts\Foundation\Application;

function (Application $application) {
    return $application->environment('local', 'testing');
};

function (\Illuminate\Foundation\Application $application) {
    return $application->environment('local', 'testing');
};
