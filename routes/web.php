<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentsController;
use App\Http\Controllers\UserAuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductionController;
use App\Http\Controllers\DispatchController;





/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('signout', [UserAuthController::class, 'signout'])->name('signout');

Route::group(['middleware' => ['guest']], function () {
    Route::get('/', function () {
        return redirect('login');
    });
    Route::get('/login', [UserAuthController::class, 'index'])->name('login');
    Route::post('login', [UserAuthController::class, 'login'])->name('auth.login');
    Route::get('user', [UserAuthController::class, 'user'])->name('user');
    Route::post('register', [UserAuthController::class, 'register'])->name('register');
});


Route::group(['as' => 'admin.', 'prefix' => 'admin', 'namespace' => 'Admin', 'middleware' => ['auth', 'admin']], function () {
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::group(['as' => 'production.', 'prefix' => 'production', 'namespace' => 'Production', 'middleware' => ['auth', 'production']], function () {
    Route::get('dashboard', [ProductionController::class, 'dashboard'])->name('dashboard');
});
Route::group(['as' => 'dispatch.', 'prefix' => 'dispatch', 'namespace' => 'Dispatch', 'middleware' => ['auth', 'dispatch']], function () {
    Route::get('dashboard', [UserAuthController::class, 'dashboard'])->name('dashboard');
    Route::get('index', [UserAuthController::class, 'home'])->name('home');

    Route::post('save', [StudentsController::class, 'save'])->name('save');
    Route::post('userlist', [StudentsController::class, 'userlist'])->name('userlist');
    Route::post('delete', [StudentsController::class, 'delete'])->name('delete');
    Route::post('edit', [StudentsController::class, 'edit'])->name('edit');
});
