<?php

namespace App\Services\Ai;

use App\Contracts\AiProviderInterface;
use Illuminate\Support\Manager;

class AiProviderManager extends Manager
{
    public function getDefaultDriver(): string
    {
        return $this->config->get('ai.default', 'openai');
    }

    protected function createOpenaiDriver(): AiProviderInterface
    {
        return new OpenAiProvider(
            $this->config->get('ai.providers.openai.model', 'gpt-4o-mini'),
            $this->config->get('ai.max_suggestions', 5)
        );
    }

    protected function createMockDriver(): AiProviderInterface
    {
        return new MockAiProvider();
    }
}
