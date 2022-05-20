<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;

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

 // Login
 Route::post('/login', [AuthController::class, 'login']);
 
//  Return JSON Messages : Add application/json to api
Route::group(['middleware'=> ['force_json_sanctum']], function () {

    //  Locked routes  ---------------------------------------
    Route::group(['middleware'=> ['auth:sanctum']], function () {
        
        // Logout
        Route::post('/logout', [AuthController::class, 'logout']);

        // Users
        Route::get('/users',                [UserController::class, 'index'])->name('users-index');
        Route::get('/user/{id}',            [UserController::class, 'show'])->name('users-show');
        Route::post('/users',               [UserController::class, 'store'])->name('users-store');
        Route::post('/users-filter',        [UserController::class, 'getByFilter'])->name('users-filter');
        Route::put('/users/{id}',           [UserController::class, 'update'])->name('users-update');
        Route::delete('/users/{id}',        [UserController::class, 'delete'])->name('users-delete');

        // Projects
        Route::get('/projects',             [ProjectController::class, 'index'])->name('projects-index');
        Route::get('/project/{id}',         [ProjectController::class, 'show'])->name('projects-show');
        Route::post('/projects',            [ProjectController::class, 'store'])->name('projects-store');
        Route::post('/projects-filter',     [ProjectController::class, 'getByFilter'])->name('projects-filter');
        Route::put('/projects/{id}',        [ProjectController::class, 'update'])->name('projects-update');
        Route::delete('/projects/{id}',     [ProjectController::class, 'delete'])->name('projects-delete');

        // Tasks
        Route::get('/tasks',                [TaskController::class, 'index'])->name('tasks-index');
        Route::get('/task/{id}',            [TaskController::class, 'show'])->name('tasks-show');
        Route::post('/tasks',               [TaskController::class, 'store'])->name('tasks-store');
        Route::post('/tasks-filter',        [TaskController::class, 'getByFilter'])->name('tasks-filter');
        Route::put('/tasks/{id}',           [TaskController::class, 'update'])->name('tasks-update');
        Route::put('/tasks-statut/{id}',    [TaskController::class, 'changeStatut'])->name('tasks-changeStatut');
        Route::delete('/tasks/{id}',        [TaskController::class, 'delete'])->name('tasks-delete');

    });

    // Free routes --------------------------------------------

});
