<?php

namespace Tests\Feature;

use App\Models\TodoList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    use RefreshDatabase;

    private $list;
    public function setUp(): void
    {
        parent::setUp();
        $user = $this->authUser();
        $this->list = $this->createTodoList([
            'name' => 'my list',
            'user_id' => $user->id
        ]);
    }

    public function test_fetch_all_todo_list()
    {
        $li =$this->createTodoList();

        $response = $this->getJson(route('todo-list.index'))->json();
        
        $this->assertEquals(1, count($response));
        $this->assertEquals('my list', $response[0]['name']);
    }

    public function test_fetch_single_todo_list()
    {

        // action
        $response = $this->getJson(route('todo-list.show', $this->list->id))
            ->assertOk()
            ->json();

        //assertion 
        $this->assertEquals($response['name'], $this->list->name);
    }

    public function test_store_new_todo_list()
    {

        $list = TodoList::factory()->make();
        $response = $this->postJson(route('todo-list.store', ['name' => $list->name]))
            ->assertCreated()
            ->json();
        $this->assertDatabaseHas('todo_lists', ['name' => $list->name]);
    }

    public function test_store_todo_list_name_required()
    {
        $this->withExceptionHandling();
        $this->postJson(route('todo-list.store'))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }

    public function test_delete_todo_list()
    {
        $this->deleteJson(route('todo-list.destroy', $this->list->id))
            ->assertNoContent();
        $this->assertDatabaseMissing('todo_lists', ['name' => $this->list->name]);
    }

    public function test_update_todo_list()
    {
        $this->patchJson(route('todo-list.update', $this->list->id), ['name' => 'updated name'])
            ->assertOk();
        $this->assertDatabaseHas(
            'todo_lists',
            [
                'id' => $this->list->id,
                'name' => 'updated name'
            ]
        );
    }

    public function test_update_todo_list_name_required()
    {
        $this->withExceptionHandling();
        $this->patchJson(route('todo-list.update', $this->list->id))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['name']);
    }
}
