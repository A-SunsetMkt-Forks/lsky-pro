<?php

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

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\ImageController;
use App\Http\Controllers\User\AlbumController;
use App\Http\Controllers\Common\GalleryController;

use App\Http\Controllers\Admin\ConsoleController as AdminConsoleController;
use App\Http\Controllers\Admin\GroupController as AdminGroupController;
use App\Http\Controllers\Admin\StrategyController as AdminStrategyController;
use App\Http\Controllers\Admin\UserController as AdminUserController;

Route::get('/', fn () => view('welcome'))->name('/');
Route::post('upload', [Controller::class, 'upload']);
Route::group(['middleware' => ['auth']], function () {
    Route::get('dashboard', [UserController::class, 'dashboard'])->name('dashboard');
    Route::get('gallery', [GalleryController::class, 'index'])->name('gallery');
    Route::get('settings', [UserController::class, 'settings'])->name('settings');
    Route::put('settings', [UserController::class, 'update'])->name('settings.update');

    Route::get('upload', fn () => view('user.upload'))->name('upload');
    Route::get('images', [ImageController::class, 'index'])->name('images');
    Route::group(['prefix' => 'user'], function () {
        Route::get('images', [ImageController::class, 'images'])->name('user.images');
        Route::get('images/{id}', [ImageController::class, 'image'])->name('user.image');
        Route::delete('images', [ImageController::class, 'delete'])->name('user.images.delete');
        Route::put('images/permission', [ImageController::class, 'permission'])->name('user.images.permission');
        Route::put('images/rename', [ImageController::class, 'rename'])->name('user.images.rename');
        Route::put('images/movement', [ImageController::class, 'movement'])->name('user.images.movement');
        Route::get('albums', [AlbumController::class, 'albums'])->name('user.albums');
        Route::post('albums', [AlbumController::class, 'create'])->name('user.album.create');
        Route::put('albums/{id}', [AlbumController::class, 'update'])->name('user.album.update');
        Route::delete('albums/{id}', [AlbumController::class, 'delete'])->name('user.album.delete');
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth.admin']], function () {
    Route::get('console', [AdminConsoleController::class, 'index'])->name('admin.console');

    Route::group(['prefix' => 'users'], function () {
        Route::get('', [AdminUserController::class, 'index'])->name('admin.users');
        Route::get('{id}', [AdminUserController::class, 'edit'])->name('admin.user.edit');
        Route::put('{id}', [AdminUserController::class, 'update'])->name('admin.user.update');
        Route::delete('{id}', [AdminUserController::class, 'delete'])->name('admin.user.delete');
    });

    Route::group(['prefix' => 'groups'], function () {
        Route::get('', [AdminGroupController::class, 'index'])->name('admin.groups');
        Route::get('create', [AdminGroupController::class, 'add'])->name('admin.group.add');
        Route::post('create', [AdminGroupController::class, 'create'])->name('admin.group.create');
        Route::get('{id}', [AdminGroupController::class, 'edit'])->name('admin.group.edit');
        Route::put('{id}', [AdminGroupController::class, 'update'])->name('admin.group.update');
        Route::delete('{id}', [AdminGroupController::class, 'delete'])->name('admin.group.delete');
    });

    Route::group(['prefix' => 'strategies'], function () {
        Route::get('', [AdminStrategyController::class, 'index'])->name('admin.strategies');
        Route::get('create', [AdminStrategyController::class, 'add'])->name('admin.strategy.add');
        Route::post('create', [AdminStrategyController::class, 'create'])->name('admin.strategy.create');
        Route::get('{id}', [AdminStrategyController::class, 'edit'])->name('admin.strategy.edit');
        Route::put('{id}', [AdminStrategyController::class, 'update'])->name('admin.strategy.update');
        Route::delete('{id}', [AdminStrategyController::class, 'delete'])->name('admin.strategy.delete');
    });
});

require __DIR__.'/image.php';
require __DIR__.'/auth.php';
