<?php

use App\Http\Controllers\TodoListController;
use Illuminate\Support\Facades\Route;

Route::get('todo-list',[TodoListController::class,'Index'])->name('todo-list.index');
Route::get('todo-list/{list}',[TodoListController::class,'Show'])->name('todo-list.show');