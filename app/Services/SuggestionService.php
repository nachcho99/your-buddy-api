<?php

namespace App\Services;

use App\Contracts\AiProviderInterface;
use App\Exceptions\SuggestionServiceException;
use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SuggestionService
{
    private AiProviderInterface $aiProvider;

    public function __construct(AiProviderInterface $aiProvider)
    {
        $this->aiProvider = $aiProvider;
    }

    public function createConversationWithSuggestions(string $topic): Conversation
    {
        try {
            return DB::transaction(function () use ($topic) {
                $conversation = $this->createConversation($topic);
                $suggestions = $this->generateSuggestions($topic);
                $this->storeSuggestions($conversation, $suggestions);

                return $conversation->load('messages');
            });
        } catch (\Exception $e) {
            Log::error('Failed to create conversation with suggestions', [
                'topic' => $topic,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            throw new SuggestionServiceException(
                'Failed to generate suggestions for the given topic',
                0,
                $e
            );
        }
    }

    private function createConversation(string $topic): Conversation
    {
        return Conversation::create(['topic' => $topic]);
    }

    private function generateSuggestions(string $topic): array
    {
        $suggestions = $this->aiProvider->generateSuggestions($topic);

        if (empty($suggestions)) {
            throw new SuggestionServiceException('No suggestions were generated');
        }

        return $suggestions;
    }

    private function storeSuggestions(Conversation $conversation, array $suggestions): void
    {
        $messages = collect($suggestions)->map(fn($suggestion) => [
            'conversation_id' => $conversation->id,
            'content' => $suggestion,
            'created_at' => now(),
            'updated_at' => now(),
        ])->all();

        Message::insert($messages);
    }
}
