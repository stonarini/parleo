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


Route::middleware('auth')->prefix('/r/{community:name}/post')->controller(PostController::class)->group(function () {
    Route::get('/new', 'edit')->name('post.edit');
    Route::get('/{post}', 'view')->name('post.view');
    Route::post('/{post?}', 'save')->name('post.save');
    Route::put('/{post}', 'edit')->name('post.update');
    Route::delete('/{post}', 'delete')->name('post.delete');
});

require __DIR__ . '/auth.php';
