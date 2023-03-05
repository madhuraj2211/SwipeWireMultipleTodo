<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\loginController;
use App\Http\Controllers\registerController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoListController;
use Illuminate\Auth\Events\Logout;

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

Route::get('/', function () {
    return view('master');
});

Route::group(['middleware' => 'isLoggedin'], function(){
    Route::get('/login', loginController::class);
    Route::get('/register', registerController::class);

    Route::post('/register',[AuthController::class, 'signup'])->name('register');
    Route::post('/login', [AuthController::class, 'login']) ->name('login');
});

Route::group(['middleware' => 'checkAuth'], function (){
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
    
    Route::get('/todolist', [TodoListController::class, 'index'])->name('todolist.index'); 
    Route::post('/todolist/update/{id}', [TodoListController::class, 'update'])->name('todolist.update'); 
    Route::delete('/todolist/delete/{id}', [TodoListController::class, 'destroy'])->name('todolist.delete'); 
    Route::post('/todolist/store', [TodoListController::class, 'store'])->name('todolist.store');
    Route::get('/todolist/fetchlist', [TodoListController::class, 'fetchlist'])->name('todolist.fetchlist');
    
    Route::post('/task/store/{todoId}', [TaskController::class, 'store'])->name('task.store');
    Route::post('/task/{taskId}/toggle', [TaskController::class, 'toggle'])->name('task.toggle');
    Route::post('/task/update/{todoId}/{taskid}', [TaskController::class, 'update'])->name('task.update');
    Route::delete('/task/delete/{taskid}/{todoId}', [TaskController::class, 'destroy'])->name('task.delete');
});