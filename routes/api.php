<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SuggestionController;
use App\Http\Controllers\ConversationController;

Route::prefix('conversations')->name('api.conversations.')->group(function () {
    Route::get('/', [ConversationController::class, 'index'])->name('index');
    Route::get('{id}', [ConversationController::class, 'show'])->name('show');
});

Route::prefix('suggestions')->name('api.suggestions.')->group(function () {
    Route::post('/', [SuggestionController::class, 'store'])->name('store');
});
