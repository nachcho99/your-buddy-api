<?php

namespace App\Http\Controllers;

use App\Exceptions\SuggestionServiceException;
use App\Http\Request\StoreSuggestionRequest;
use App\Http\Resources\ConversationResource;
use App\Services\SuggestionService;
use Illuminate\Http\JsonResponse;

class SuggestionController extends Controller
{

    private SuggestionService $suggestionService;

    public function __construct(SuggestionService $suggestionService)
    {
        $this->suggestionService = $suggestionService;
    }

    public function store(StoreSuggestionRequest $request): JsonResponse
    {
        try {
            $conversation = $this->suggestionService->createConversationWithSuggestions(
                $request->validated('topic')
            );

            return response()->json([
                'success' => true,
                'data' => new ConversationResource($conversation),
            ], 201);

        } catch (SuggestionServiceException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }
}
