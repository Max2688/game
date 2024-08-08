<?php

namespace App\Providers;

use App\Services\Game\GenerateLink;
use App\Services\Game\GenerateLinkInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            GenerateLinkInterface::class,
            GenerateLink::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
