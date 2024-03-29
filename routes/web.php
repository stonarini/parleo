<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
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
    Route::get('/create', 'create')->name('post.create');
    Route::get('/{post}', 'show')->name('post.show');
    Route::post('/{post?}', 'store')->name('post.store');
    Route::put('/{post}', 'create')->name('post.update');
    Route::delete('/{post}', 'destroy')->name('post.destroy');
});

Route::middleware("auth")->post('/tokens/create', function (Request $request) {
    $request->user()->tokens()->delete();
    $token = $request->user()->createToken("api")->plainTextToken;
    return Redirect::route("dashboard")->with("token", $token);
});


require __DIR__ . '/auth.php';
