<?php

# Global helper function
$env = app()->environment();
$isLocal = app()->environment('local');
$isLocalOrTest = app()->environment('local', 'test');
