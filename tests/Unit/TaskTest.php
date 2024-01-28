<?php

namespace Tests\Unit;

use App\Http\Controllers\TaskController;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    /**
     * A basic test example.
     */
    public function testCreateAssignmentMatrix(): void
    {
        $taskController = new TaskController();
        $this->assertRedirectedTo('login');
    }
}
