<?php

namespace Tests\Unit;

use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TodoList;
use App\Models\User;
use Illuminate\Support\Str;
use Tests\TestCase;

class TodoListTest extends TestCase
{
    private $user;
    private $todoList;

    public function setUp(): void
    {
        parent::setUp();
        $this->user = User::first();
        $this->todoList = $this->fakeList($this->user);
    }

    public function test_get_list_resources()
    {

        $response = $this->actingAs($this->user)->get('/todoList');

        $response->assertStatus(200);
    }

    public function test_create_todo_list()
    {
        $todoList = [
            'title' => 'todo list test',
            'tasks' => [
                ['title' => 'test fake task', 'deadline' => '2050-01-01 00:00:00']
            ]
        ];
        $response = $this->actingAs($this->user)->postJson('/todoList', $todoList);

        $response->assertStatus(201)
            ->assertJsonCount(2)
            ->assertJsonFragment(["message" => "todo list test was successfully created"]);
    }

    public function test_create_request_validation()
    {
        $todoList = [
            'title' => '',
            'tasks' => [
                ['title' => 'test fake task', 'deadline' => '2050-01-01 00:00:00']
            ]
        ];
        $response = $this->actingAs($this->user)->postJson('/todoList', $todoList);

        $response->assertStatus(422);
    }

    public function test_show_list()
    {
        $response = $this->actingAs($this->user)->getJson("todoList/" . $this->todoList->id);
        $response->assertStatus(200)
            ->assertJson(['id' => $this->todoList->id]);

    }

    public function test_update_list()
    {
        $todoList = [
            'title' => 'todo list new title: ' . Str::random(10),
            'tasks' => $this->todoList->tasks
        ];

        $response = $this->actingAs($this->user)->putJson('/todoList/' . $this->todoList->id, $todoList);

        $response->assertStatus(200)
            ->assertJson(['resource' =>['title' => $todoList['title']]]);
    }

    public function test_delete_list(){
        $response = $this->actingAs($this->user)->delete('/todoList/' . $this->todoList->id);

        $response->assertStatus(200);
    }


    /**
     * Creates fake list
     *
     * @param $user
     *
     * @return TodoList
     */
    private function fakeList($user): TodoList
    {
        $todoList = TodoList::factory()->make();
        $todoList->user()->associate($user);
        $todoList->save();
        $task = Task::factory()->make();
        $task->list()->associate($todoList);
        $task->save();
        return $todoList;
    }
}
