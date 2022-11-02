<?php

namespace Spreader\Handler\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Spreader\Handler\Exceptions\Handler;

class FoundationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/spreader.php' => config_path('spreader.php'),
        ]);
    }

    public function register()
    {
        $this->app->bind(ExceptionHandler::class, Handler::class);
        parent::register();
    }
}
