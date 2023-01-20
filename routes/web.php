<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/img/{_}/{img}', function () {
    return;
})->middleware("img");


Route::middleware('auth')->group(function () {
    Route::get('/r/{community}/post/new', [PostController::class, 'edit'])->name('post.edit');
    Route::get('/r/{community}/post/{id}', [PostController::class, 'view'])->name('post.view');
    Route::post('/r/{community}/post/new', [PostController::class, 'create'])->name('post.create');
    Route::post('/r/{community}/post/{id}', [PostController::class, 'update'])->name('post.update');
    Route::put('/r/{community}/post/{id}', [PostController::class, 'edit'])->name('post.edit');
    Route::delete('/r/{community}/post/{id}', [PostController::class, 'delete'])->name('post.delete');
});

require __DIR__ . '/auth.php';
