<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Todo;

class CreateTaskTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_tasks_list()
    {
        $task = Todo::factory()->create();
        $this->withoutMiddleware();

        $response = $this->get('/api/all-tasks');

        $response->assertStatus(200);
    }
}
