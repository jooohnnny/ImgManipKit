<?php

declare(strict_types=1);

namespace Johnny\ImageToolKit;

use Illuminate\Support\ServiceProvider;

class ImageToolKitProvider extends ServiceProvider
{
    public const VERSION = '1.0.0';

    public function register()
    {
        $this->app->singleton('imagetoolkit', function ($app) {
            return new ImageToolKit($app['config']->get('imagetoolkit'));
        });

        $this->app->singleton('itk.preprocess', function ($app) {
            return $app->make('imagetoolkit')->driver('preprocess');
        });

        $this->app->singleton('itk.parse', function ($app) {
            return $app->make('imagetoolkit')->driver('parse');
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/imagetoolkit.php' => config_path('imagetoolkit.php'),
        ]);
    }

    public function provides()
    {
        return [
            'imagetoolkit', 'itk.preprocess', 'itk.parse',
        ];
    }
}
