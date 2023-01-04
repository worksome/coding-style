<?php

use Illuminate\Support\Facades\App;

# Facade alias
$env = App::environment();
$isLocal = App::environment('local');
$isLocalOrTest = App::environment('local', 'test');
