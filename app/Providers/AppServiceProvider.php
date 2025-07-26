<?php

namespace App\Providers;

use App\Contracts\AiProviderInterface;
use App\Services\Ai\MockAiProvider;
use App\Services\Ai\OpenAiProvider;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        config([
            'ai' => [
                'default' => env('AI_PROVIDER', 'openai'),
                'max_suggestions' => (int) env('AI_MAX_SUGGESTIONS', 5),
                'providers' => [
                    'openai' => [
                        'model' => env('OPENAI_MODEL', 'gpt-4o-mini'),
                    ],
                    'mock' => [],
                ],
            ]
        ]);

        $this->app->bind(AiProviderInterface::class, function ($app) {
            $provider = config('ai.default', 'openai');

            switch ($provider) {
                case 'mock':
                    return new MockAiProvider();

                default:
                    return new OpenAiProvider(
                        config('ai.providers.openai.model', 'gpt-4o-mini'),
                        config('ai.max_suggestions', 5)
                    );
            }
        });
    }

    public function boot(): void
    {
        //
    }
}
