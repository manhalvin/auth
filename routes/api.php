<?php

use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\API\GroupPermissionController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\RoleController;
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
        Route::get('/create', [PostController::class, 'create'])->name('create');
        // Route::post('/', [PostController::class, 'store'])->name('store');
        Route::get('/{post}', [PostController::class, 'show'])->name('show');
        Route::get('/{post}/edit', [PostController::class, 'edit'])->name('edit');
        // Route::put('/{post}', [PostController::class, 'update'])->name('update');
        Route::post('/{post}', [PostController::class, 'update'])->name('update');
        Route::delete('/{post}', [PostController::class, 'delete'])->name('delete');

    });

    // Moduel Users
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{user}', [UserController::class, 'show'])->name('show');
        Route::get('/{user}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{user}', [UserController::class, 'update'])->name('update');
        Route::delete('/{user}', [UserController::class, 'delete'])->name('delete');
    });

     // Moduel Roles
    Route::prefix('roles')->name('role.')->group(function () {
        Route::get('/', [RoleController::class, 'index'])->name('index');
        Route::get('/create', [RoleController::class, 'create'])->name('create');
        Route::post('/', [RoleController::class, 'store'])->name('store');
        Route::get('/{role}', [RoleController::class, 'show'])->name('show');
        Route::get('/{role}/edit', [RoleController::class, 'edit'])->name('edit');
        Route::put('/{role}', [RoleController::class, 'update'])->name('update');
        Route::delete('/{role}', [RoleController::class, 'delete'])->name('delete');

    });

    Route::prefix('permission')->name('group.permission.')->group(function () {
        // Group Permission Controller
        Route::get('/groups', [ GroupPermissionController::class, 'index'])->name('index');
        Route::get('/groups/create', [ GroupPermissionController::class, 'create'])->name('create');
        Route::post('/group', [ GroupPermissionController::class, 'store'])->name('store');
        Route::get('/group/{group}', [ GroupPermissionController::class, 'show'])->name('show');
        Route::get('/group/{group}/edit', [ GroupPermissionController::class, 'edit'])->name('edit');
        Route::put('/group/{group}', [ GroupPermissionController::class, 'update'])->name('update');
        Route::delete('/group/{group}', [ GroupPermissionController::class, 'delete'])->name('delete');

        // Permission Controller
        Route::get('/', [PermissionController::class, 'index'])->name('index');
        Route::get('/create', [PermissionController::class, 'create'])->name('create');
        Route::post('/', [PermissionController::class, 'store'])->name('store');
        Route::get('/{permission}', [PermissionController::class, 'show'])->name('show');
        Route::get('/{permission}/edit', [PermissionController::class, 'edit'])->name('edit');
        Route::put('/{permission}', [PermissionController::class, 'update'])->name('update');
        Route::delete('/{permission}', [PermissionController::class, 'delete'])->name('delete');
    });

});

