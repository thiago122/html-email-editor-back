<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\Cors;
use App\Http\Controllers\EditorController;
use App\Models\Email;

Route::prefix('editor')->group(function () {

    Route::get('/token', function () {
        echo json_encode(['csrf' => csrf_token()]);
    });
 
    Route::get('/edit/{email}', [EditorController::class, 'edit'])->name('email.edit');
    Route::get('/{email}', [EditorController::class, 'show']);
    Route::put('/{email}', [EditorController::class, 'update'])->name('email.update');
});

Route::get('/teste', function () {
    echo auth()->check();
});
