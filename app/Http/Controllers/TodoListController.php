<?php

namespace App\Http\Controllers;

use App\Models\TodoList;
use Illuminate\Http\Request;

class TodoListController extends Controller
{
    public function Index(){
        $lists = TodoList::all();
        return response($lists);
    }
    public function Show(TodoList $list){
        //$lists = TodoList::findOrFail($id);
        return response($list);
    }
}
