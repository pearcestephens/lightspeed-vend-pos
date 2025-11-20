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
        Route::apiResource('stores', StoresController::class);
        Route::apiResource('staff', StaffController::class);
        Route::apiResource('products', ProductsController::class);
        Route::apiResource('inventory', InventoryController::class);
        Route::apiResource('sales', SalesController::class);
        Route::apiResource('customers', CustomersController::class);
        Route::apiResource('suppliers', SuppliersController::class);
        Route::apiResource('purchase_orders', Purchase_ordersController::class);
        Route::apiResource('registers', RegistersController::class);
        Route::apiResource('reports', ReportsController::class);
        Route::apiResource('analytics', AnalyticsController::class);
        Route::apiResource('offline_sync', Offline_syncController::class);
        Route::apiResource('hardware', HardwareController::class);
        Route::apiResource('settings', SettingsController::class);
        Route::apiResource('integrations', IntegrationsController::class);

        // Custom endpoints
        Route::post('/bots/{bot}/train', [BotController::class, 'train']);
        Route::post('/conversations/{conversation}/feedback', [ConversationController::class, 'recordFeedback']);
        Route::post('/integrations/{integration}/sync', [IntegrationController::class, 'sync']);
        Route::post('/knowledge/{knowledge}/search', [KnowledgeController::class, 'search']);
        Route::get('/analytics/dashboard', [AnalyticsController::class, 'dashboard']);
    });
});