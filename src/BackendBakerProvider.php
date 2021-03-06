<?php

namespace BackendBaker;

use Illuminate\Support\ServiceProvider;
use BackendBaker\Console\Commands\GenerateCommand;

class BackendBakerProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'admin');

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
