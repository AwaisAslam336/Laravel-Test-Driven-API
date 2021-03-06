<?php

namespace App\Http\Controllers;

use App\Http\Requests\TodoListRequest;
use App\Models\TodoList;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TodoListController extends Controller
{
    public function index(){
        $lists = auth()->user()->todo_lists;
        return response($lists);
    }

    public function show(TodoList $todo_list){
        //$lists = TodoList::findOrFail($id);
        return response($todo_list);
    }

    public function store(TodoListRequest $request){
        // $request['user_id'] = auth()->id();
        // $list = TodoList::create($request->all());
        // return $list;
        return auth()->user()->todo_lists()->create($request->validated());
    }

    public function destroy(TodoList $todo_list){
        $todo_list->delete();
        return response('',Response::HTTP_NO_CONTENT);
    }

    public function update(TodoListRequest $request,TodoList $todo_list){
        $todo_list->update($request->all());
        return $todo_list;
    }
}
