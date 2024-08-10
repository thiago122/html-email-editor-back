<?php

use App\Models\Email;
use App\Http\Middleware\Cors;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\PatternController;

Route::prefix('editor')->group(function () {

    Route::get('/token', function () {
        echo json_encode(['csrf' => csrf_token()]);
    });
 
    Route::get('/edit/{email}', [EditorController::class, 'edit'])->name('email.edit');
    Route::get('/{email}', [EditorController::class, 'show']);
    Route::put('/{email}', [EditorController::class, 'update'])->name('email.update');
    Route::post('/{email}', [EditorController::class, 'update'])->name('email.update');

});

Route::post('/pattern', [PatternController::class, 'store']);
Route::get('/pattern', [PatternController::class, 'index']);
Route::delete('/pattern/{id}', [PatternController::class, 'destroy']);

Route::post('/teste', function () {
    echo auth()->check();
});
