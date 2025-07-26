<?php
namespace App\Contracts;

interface AiProviderInterface
{
    public function generateSuggestions(string $topic, string $language = 'en'): array;
}
