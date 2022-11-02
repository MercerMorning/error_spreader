<?php

namespace Spreader\Handler\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Spreader\Handler\Exceptions\Handler;

class FoundationServiceProvider extends ServiceProvider
{
    public function boot()
    {
        dd(12);
        $this->app->bind(ExceptionHandler::class, Handler::class);
    }
}
