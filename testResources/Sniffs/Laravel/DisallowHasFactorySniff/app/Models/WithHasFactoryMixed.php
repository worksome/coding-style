<?php

namespace Worksome\WorksomeSniff\Tests\Resources\Sniffs\Laravel\DisallowHasFactorySniff\app\Models;

use Carbon\Traits\Date;
use Illuminate\Database\Eloquent;

class WithHasFactoryMixed
{
    use Eloquent\Factories\HasFactory;
    use Date;

}
