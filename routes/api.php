<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowController;
use App\Http\Controllers\CategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route publik: tidak butuh token
Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);

// Route terproteksi: wajib kirim token (Bearer) via Sanctum
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('logout', [AuthController::class, 'logout']);

    // Hapus data hanya boleh oleh admin (role:admin)
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->middleware('role:admin');
    Route::delete('books/{book}', [BookController::class, 'destroy'])->middleware('role:admin');
    Route::delete('borrows/{borrow}', [BorrowController::class, 'destroy'])->middleware('role:admin');

    // Sisanya (index, store, show, update) boleh semua user terautentikasi
    Route::apiResource('categories', CategoryController::class)->except(['destroy']);
    Route::apiResource('books', BookController::class)->except(['destroy']);
    Route::apiResource('borrows', BorrowController::class)->except(['destroy']);
});
