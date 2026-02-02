<?php
use App\Http\Controllers\PembayaranController;


// Midtrans Notification Route
Route::post('/midtrans/notification', [PembayaranController::class, 'notification']);