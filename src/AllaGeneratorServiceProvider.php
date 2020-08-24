<?php

namespace Alla\Generator;

use Illuminate\Support\ServiceProvider;
use Alla\Generator\Commands\GeneratorBuilderCommand;

class AllaGeneratorServiceProvider extends ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                [
                    GeneratorBuilderCommand::class,
                ]
            );
        }
    }
    public function register()
    {
      //
    }
}
