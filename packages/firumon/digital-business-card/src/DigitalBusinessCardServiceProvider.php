<?php

namespace Firumon\DigitalBusinessCard;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class DigitalBusinessCardServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom($this->path('config','session.php'),'session');
        $this->mergeConfigFrom($this->path('config','cache.php'),'cache');
        $this->mergeConfigFrom($this->path('config','database.php'),'database');
        $this->mergeConfigFrom($this->path('config','dbc.php'),'dbc');
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if($this->app->runningInConsole()){
            $this->loadMigrationsFrom($this->path('database/migrations'));
            Schema::defaultStringLength(191);
        } else {
            $this->loadRoutesFrom($this->path('routes','web.php'));
            $this->loadViewsFrom($this->path('resources/views'),'dbc');
        }
    }

    private function path($folder,$file = null): string {
        return implode("/",array_filter([__DIR__,'..',$folder,$file]));
    }
}
