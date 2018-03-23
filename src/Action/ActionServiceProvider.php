<?php

namespace Action;

use Illuminate\Support\ServiceProvider;
use Action\Console\Commands\ActionMakeCommand;

class ActionServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {
            $this->commands([
                ActionMakeCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     */
    public function register()
    {

        $this->publishes([
            __DIR__ . '/../config/action.php' => $this->app['path.config']
            . DIRECTORY_SEPARATOR . 'action.php',
        ]);
    }
}
