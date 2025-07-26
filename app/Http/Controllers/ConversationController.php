<?php

namespace App\Http\Controllers;

use App\Http\Request\ListConversationRequest;
use App\Models\Conversation;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function index(ListConversationRequest $request): JsonResponse
    {
        $page = $request->input('page', 1);
        $size = $request->input('size', 10);

        $conversations = Conversation::orderBy('created_at', 'desc')
            ->paginate($size, ['*'], 'page', $page);

        return response()->json([
            'data' => $conversations
        ]);
    }

    public function show($id): JsonResponse
    {
        $conversation = Conversation::with('messages')
            ->findOrFail($id);
        return response()->json([
            'data' => $conversation
        ]);
    }
}

