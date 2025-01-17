<?php

use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/complaints', [TicketController::class, 'addTicket']);
Route::get('/AllTickets', [TicketController::class, 'getAllTickets']);
Route::post('/tickets/{tracking_id}', [TicketController::class, 'updateStatus']);
Route::delete('/tickets/{tracking_id}', [TicketController::class, 'deleteTicket']);
Route::get('/tickets/date-range', [TicketController::class, 'getTicketsByDateRange']); // Route baru untuk date range

Route::get('/notifications/{userId}', [NotificationController::class, 'index']);
Route::post('/notifications', [NotificationController::class, 'store']);
Route::patch('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead']);
