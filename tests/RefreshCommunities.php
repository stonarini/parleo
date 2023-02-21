<?php

namespace Tests;

use Illuminate\Support\Facades\Artisan;

trait RefreshCommunities
{
    protected static $setUpHasRunOnce = false;

    public function setUp(): void
    {
        parent::setUp();
        if (!static::$setUpHasRunOnce) {
            Artisan::call('migrate:reset');
            Artisan::call('migrate:fresh');
            Artisan::call(
                'db:seed',
                ['--class' => 'CommunitySeeder']
            );
            static::$setUpHasRunOnce = true;
        }
    }
}
