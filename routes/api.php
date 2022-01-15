<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {

    Route::apiResource('todo-list', TodoListController::class);
    Route::apiResource('todo-list.task', TaskController::class)
        ->except('show')->shallow();
});


Route::post('/register', RegisterController::class)->name('user.register');
Route::post('/login', LoginController::class)->name('user.login');
 
 //Route::get('task',[TaskController::class,'index'])->name('task.index');
// Route::get('task/{list}',[TaskController::class,'show'])->name('task.show');
 //Route::post('task',[TaskController::class,'store'])->name('task.store');
 //Route::delete('task/{task}',[TaskController::class,'destroy'])->name('task.destroy');
// Route::patch('task/{list}',[TaskController::class,'update'])->name('task.update');