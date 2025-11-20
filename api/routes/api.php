<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\BotController;
use App\Http\Controllers\Api\ConversationController;
use App\Http\Controllers\Api\IntegrationController;
use App\Http\Controllers\Api\KnowledgeController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\AnalyticsController;

Route::middleware('api')->group(function () {

    // Health check
    Route::get('/health', function () {
        return response()->json(['status' => 'healthy']);
    });

    // API v1 routes
    Route::prefix('v1')->group(function () {

        // Custom endpoints
        Route::post('/bots/{bot}/train', [BotController::class, 'train']);
        Route::post('/conversations/{conversation}/feedback', [ConversationController::class, 'recordFeedback']);
        Route::post('/integrations/{integration}/sync', [IntegrationController::class, 'sync']);
        Route::post('/knowledge/{knowledge}/search', [KnowledgeController::class, 'search']);
        Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    });
});