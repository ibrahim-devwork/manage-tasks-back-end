<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DropDownActionsnController;
use App\Http\Controllers\DropDownProjectsController;
use App\Http\Controllers\DropDownRolesController;
use App\Http\Controllers\DropDownUsersController;
use App\Http\Controllers\ProfileController;
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
        Route::post('/logout',              [AuthController::class, 'logout']);

        // Users
        Route::post('/users-filter',        [UserController::class, 'index'])->name('users-index');
        Route::get('/user/{id}',            [UserController::class, 'show'])->name('users-show');
        Route::post('/users',               [UserController::class, 'store'])->name('users-store');
        Route::put('/users/{id}',           [UserController::class, 'update'])->name('users-update');
        Route::delete('/users/{id}',        [UserController::class, 'delete'])->name('users-delete');

        // Projects
        Route::post('/projects-filter',     [ProjectController::class, 'index'])->name('projects-index');
        Route::get('/project/{id}',         [ProjectController::class, 'show'])->name('projects-show');
        Route::post('/projects',            [ProjectController::class, 'store'])->name('projects-store');
        Route::put('/projects/{id}',        [ProjectController::class, 'update'])->name('projects-update');
        Route::delete('/projects/{id}',     [ProjectController::class, 'delete'])->name('projects-delete');

        // Tasks
        Route::post('/tasks-filter',        [TaskController::class, 'index'])->name('tasks-index');
        Route::get('/task/{id}',            [TaskController::class, 'show'])->name('tasks-show');
        Route::post('/tasks',               [TaskController::class, 'store'])->name('tasks-store');
        Route::put('/tasks/{id}',           [TaskController::class, 'update'])->name('tasks-update');
        Route::put('/tasks-statut/{id}',    [TaskController::class, 'changeStatut'])->name('tasks-changeStatut');
        Route::delete('/tasks/{id}',        [TaskController::class, 'delete'])->name('tasks-delete');

        // DropDown routes
        Route::get('/select-roles',         DropDownRolesController::class);
        Route::get('/select-users',         DropDownUsersController::class);
        Route::get('/select-projects',      DropDownProjectsController::class);
        Route::get('/select-actions',       DropDownActionsnController::class);

        // Dashboard
        Route::post('/dashboard-filter',    [DashboardController::class, 'getByFilter'])->name('dashboard-filter');

        // Profile
        Route::get('/profile',              [ProfileController::class, 'getPRofile']);
        Route::post('/change-infos',        [ProfileController::class, 'changeInfos'])->name('change-infos');
        Route::post('/change-email',        [ProfileController::class, 'changeEmail'])->name('change-email');
        Route::post('/change-username',     [ProfileController::class, 'changeUsername'])->name('change-username');
        Route::post('/change-password',     [ProfileController::class, 'changePassword'])->name('change-password');
    });

    // Free routes --------------------------------------------

});

