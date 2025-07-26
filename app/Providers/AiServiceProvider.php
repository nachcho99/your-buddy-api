<?php

namespace App\Providers;

use App\Contracts\AiProviderInterface;
use App\Services\Ai\AiProviderManager;
use Illuminate\Support\ServiceProvider;

class AiServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('ai.manager', function ($app) {
            return new AiProviderManager($app);
        });

        $this->app->bind(AiProviderInterface::class, function ($app) {
            return $app['ai.manager']->driver();
        });
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../../config/ai.php' => config_path('ai.php'),
        ], 'ai-config');
    }
}
