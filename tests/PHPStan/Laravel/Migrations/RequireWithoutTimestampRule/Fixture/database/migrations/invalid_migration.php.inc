<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Worksome\CodingStyle\Tests\PHPStan\Laravel\Migrations\RequireWithoutTimestampRule\Fixture\Models\TestUser;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('test', 50)
                ->nullable();
        });

        TestUser::withTrashed()->update([
            'test' => 'test',
        ]);

        TestUser::withTrashed()->insert([
            'test' => 'test',
        ]);

        TestUser::make(['test' => 'test'])->save();

        TestUser::make(['test' => 'test'])->saveQuietly();

        TestUser::where('test', 'test')
            ->delete();

        TestUser::where('test', 'test')
            ->restore();
    }
};
