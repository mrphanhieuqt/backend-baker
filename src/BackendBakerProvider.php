<?php

namespace MrPhan\BackendBaker;

use Illuminate\Support\ServiceProvider;
use MrPhan\BackendBaker\Console\Commands\GenerateCommand;

class BackendBakerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                GenerateCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
