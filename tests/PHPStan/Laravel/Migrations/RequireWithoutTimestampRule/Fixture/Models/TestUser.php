<?php

namespace Worksome\CodingStyle\Tests\PHPStan\Laravel\Migrations\RequireWithoutTimestampRule\Fixture\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestUser extends Model
{
    use SoftDeletes;
}
