<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Laravel\Ui\AuthCommand;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/login', [AuthController::class, 'login'])->name('auth.login');
Route::prefix('admin/')->name('admin.')->middleware('auth:sanctum')->group(function () {

    // Moduel Posts
    Route::prefix('posts')->name('posts.')->group(function () {
        Route::get('/', [PostController::class, 'index'])->name('index');

        Route::post('/add', [PostController::class, 'postAdd']);
        Route::get('/add', [PostController::class, 'add'])->name('add');

        Route::get('/edit/{post}', [PostController::class, 'edit'])->name('edit');
        Route::put('/edit/{post}', [PostController::class, 'postEdit']);

        Route::delete('/delete/{post}', [PostController::class, 'delete'])->name('delete');
        Route::get('/show/{post}', [PostController::class, 'show'])->name('show');
    });

    // Moduel Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/show/{user}', [UserController::class, 'show'])->name('show');

        Route::post('/add', [UserController::class, 'postAdd']);
        Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
        Route::put('/edit/{user}', [UserController::class, 'postEdit']);
        Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('delete');
    });

     // Moduel Groups: Permissions ~ Roles
    Route::prefix('groups')->name('groups.')->group(function () {
        Route::get('/', [GroupsController::class, 'index'])->name('index');
        Route::post('/add', [GroupsController::class, 'postAdd']);
        Route::get('/add', [GroupsController::class, 'add'])->name('add');

        Route::put('edit/{group}', [GroupsController::class, 'postPermission']);

        Route::put('/permission/{group}', [GroupsController::class, 'postPermission']);
        Route::get('/permission/{group}', [GroupsController::class, 'permission']);

        Route::put('/permission-advance/{group}', [GroupsController::class, 'permissionAdvance']);
    });

});

