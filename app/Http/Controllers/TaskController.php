<?php

namespace App\Http\Controllers;

use App\Models\Config;
use App\Models\Developer;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private const WORK_HOUR_PER_WEEK = 45;

    public function getTasks()
    {
        $mConfig = new Config();
        $activeSprint = $mConfig->getActiveSprint();

        $mTask = new Task();
        $tasks =  $mTask->getTasksBySprint($activeSprint);

        $mDeveloper = new Developer();
        $developers = $mDeveloper->getDevelopers();

        $totalLabor = array_sum(array_column($developers, 'labor_per_hour'));
        $totalWorkDifficulty = array_sum(array_column($tasks, 'difficulty'));
        $avgLabor = $totalWorkDifficulty / $totalLabor;

        $assignmentMatrix = $this->createAssignmentMatrix($developers, $tasks);
        $assignedTasks = $this->scheduleTasks($assignmentMatrix, $avgLabor);

        return view('tasks', ['assignedTasks' => $assignedTasks]);
    }

    // Create a matrix showing which developer will complete which job and how long it will take to complete.
    private function createAssignmentMatrix($developers, $tasks): array
    {
        $assignmentMatrix = [];

        usort($developers, function ($a, $b) {
            return $a['labor_per_hour'] <=> $b['labor_per_hour'];
        });

        foreach ($tasks as $task) {
            foreach ($developers as $developer) {
                $finishTime = $task['difficulty'] / $developer['labor_per_hour'];
                if ($finishTime <= $task['difficulty']) {
                    $assignmentMatrix[$developer['name']][] = ['taskId' => $task['name'], 'finishTime' => $finishTime];
                }
            }
        }

        foreach ($assignmentMatrix as &$assignment) {
            usort($assignment, function ($a, $b) {
                return $a['finishTime'] <=> $b['finishTime'];
            });
        }

        return $assignmentMatrix;
    }

    // Function that allocates jobs according to assignment matrix
    private function scheduleTasks($assignmentMatrix, $avgLabor): array
    {
        $assignedTasks = [];
        $taskFlags = [];
        foreach ($assignmentMatrix as $developerName => $assignments) {
            $developerHourWork = 0;
            foreach ($assignments as $task) {
                if (
                    empty($taskFlags[$task['taskId']]) &&
                    $developerHourWork + $task['finishTime'] <= $avgLabor &&
                    $developerHourWork + $task['finishTime'] <= self::WORK_HOUR_PER_WEEK
                ) {

                    $developerHourWork =  $developerHourWork + $task['finishTime'];
                    $assignedTasks[$developerName][] = $task['taskId'];
                    $taskFlags[$task['taskId']] = true;
                }
            }
        }

        return $assignedTasks;
    }
}
