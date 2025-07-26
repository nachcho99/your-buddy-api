<?php

namespace App\Services\Ai;

use App\Contracts\AiProviderInterface;

class MockAiProvider implements AiProviderInterface
{
    public function generateSuggestions(string $topic, string $language = 'en'): array
    {
        return [
            "Mock suggestion 1 for: {$topic}",
            "Mock suggestion 2 for: {$topic}",
            "Mock suggestion 3 for: {$topic}",
            "Mock suggestion 4 for: {$topic}",
            "Mock suggestion 5 for: {$topic}",
        ];
    }
}
