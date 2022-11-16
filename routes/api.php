<?php

use App\Http\Controllers\Admin\AdminGroupPermissionController;
use App\Http\Controllers\Admin\AdminPermissionController;
use App\Http\Controllers\API\AdminRoleController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\GroupsController;
use App\Http\Controllers\API\ImageController;
use App\Http\Controllers\API\ImagePostController;
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

        // Add ~ Edit ~ Delete Image Post
        Route::post('/add/image', [ImagePostController::class, 'imageStore'])->name('imageStore');
        Route::post('/edit/image/{post}', [ImagePostController::class, 'imageEdit'])->name('imageEdit');
        Route::delete('/delete/image/{post}', [ImagePostController::class, 'imageDelete'])->name('imageDelete');

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

     // Moduel Roles
    Route::prefix('role')->name('role.')->group(function () {
        Route::get('/', [AdminRoleController::class, 'list'])->name('list');

        Route::post('/add', [AdminRoleController::class, 'postAdd']);
        Route::get('/add', [AdminRoleController::class, 'add'])->name('add');

        Route::get('update/{role}', [AdminRoleController::class, 'getUpdate'])->name('update');
        Route::put('update/{role}', [AdminRoleController::class, 'putUpdate']);

        Route::delete('delete/{role}', [AdminRoleController::class, 'delete'])->name('delete');
    });

    Route::prefix('permission')->name('groupPermission.')->group(function () {
        Route::get('/group', [AdminGroupPermissionController::class, 'list'])->name('list');

        Route::post('/group/add', [AdminGroupPermissionController::class, 'store']);

        Route::get('/group/update/{id}', [AdminGroupPermissionController::class, 'getUpdate'])->name('update');
        Route::put('/group/update/{id}', [AdminGroupPermissionController::class, 'putUpdate']);

        Route::delete('/group/delete/{id}', [AdminGroupPermissionController::class, 'delete'])->name('delete');

        Route::get('/', [AdminPermissionController::class, 'list'])->name('list');

        Route::post('/add', [AdminPermissionController::class, 'store']);

        Route::get('/update/{id}', [AdminPermissionController::class, 'getUpdate'])->name('update');
        Route::put('/update/{id}', [AdminPermissionController::class, 'putUpdate']);

        Route::delete('/delete/{id}', [AdminPermissionController::class, 'delete'])->name('delete');
    });

});

