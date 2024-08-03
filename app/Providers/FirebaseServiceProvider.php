<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Kreait\Firebase\Factory;
use App\Providers\Database;
use Kreait\Firebase\Database as FirebaseDatabase;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(FirebaseDatabase::class, function ($app) {
            $database = (new Factory)->withServiceAccount(config('firebase.credentials'));
            return $database->createDatabase();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
