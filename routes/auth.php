<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Dashboard\{
    LoginController
};


Route::prefix('auth')
->as('auth.')
->group(function () {

    Route::post('login', [LoginController::class,'login'])->name('login');
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [LoginController::class,'logout'])->name('logout');
        Route::get('user', [LoginController::class,'user'])->name('user');
    });
});
