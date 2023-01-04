<?php

# FQCN Facade
$env = \Illuminate\Support\Facades\App::environment();
$isLocal = \Illuminate\Support\Facades\App::environment('local');
$isLocalOrTest = \Illuminate\Support\Facades\App::environment('local', 'test');

# Facade alias
$env = App::environment();
$isLocal = App::environment('local');
$isLocalOrTest = App::environment('local', 'test');
