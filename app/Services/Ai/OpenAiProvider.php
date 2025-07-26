<?php

namespace App\Services\Ai;

use App\Contracts\AiProviderInterface;
use App\Exceptions\AiProviderException;
use OpenAI\Laravel\Facades\OpenAI;

class OpenAiProvider implements AiProviderInterface
{

    private string $model;
    private int $maxSuggestions;

    public function __construct(string $model = 'gpt-4o-mini', int $maxSuggestions = 5)
    {
        $this->model = $model;
        $this->maxSuggestions = $maxSuggestions;
    }

    public function generateSuggestions(string $topic, string $language = 'en'): array
    {
        try {
            $prompt = $this->buildPrompt($topic);

            $response = OpenAI::chat()->create([
                'model' => $this->model,
                'messages' => [
                    ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                    ['role' => 'user', 'content' => $prompt],
                ],
                'max_tokens' => 1000,
                'temperature' => 0.7,
            ]);

            $content = $response->choices[0]->message->content ?? '';

            return $this->parseSuggestions($content);

        } catch (\Exception $e) {
            throw new AiProviderException("OpenAI error: " . $e->getMessage(), 0, $e);
        }
    }

    private function buildPrompt(string $topic): string
    {
        return <<<PROMPT
Act as a prototype tool that helps users (e.g., journalists) generate creative and valuable content ideas based on a given topic.

Your task is:

1. If the topic "{$topic}" is suitable for content ideation, return exactly {$this->maxSuggestions} creative and useful suggestions in a numbered list. The ideas should be varied, original, and relevant for someone looking to create articles, videos, reports, etc.
2. If the topic is unclear, irrelevant, or not suitable for generating valuable content, respond with a message saying that meaningful content ideas cannot be generated from this topic.
3. Your response must be in the same language as the given topic.

Do not include any extra explanations or introductions—just the list or the message.
PROMPT;
    }

    private function parseSuggestions(string $content): array
    {
        return collect(preg_split('/\n/', $content))
            ->map(fn($line) => preg_replace('/^\d+\.\s*/', '', trim($line)))
            ->filter(fn($line) => !empty($line))
            ->take($this->maxSuggestions)
            ->values()
            ->all();
    }
}
