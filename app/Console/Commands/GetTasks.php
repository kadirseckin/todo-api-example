<?php

namespace App\Console\Commands;

use App\Models\Config;
use App\Models\Task;
use App\Models\TaskUrl;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GetTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch tasks from api and insert them to the tasks table';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->output->writeln("Get tasks command started : " . date('Y-m-d H:i:s'));

        $this->output->writeln("Fetching tasks : " . date('Y-m-d H:i:s'));
        $tasks = $this->getTasks();

        $this->output->writeln("Mapping tasks : " . date('Y-m-d H:i:s'));
        $tasks = $this->mapTasks($tasks);

        $this->output->writeln("Inserting tasks : " . date('Y-m-d H:i:s'));
        $mTask = new Task();
        $mTask->updateOrCreateByName($tasks);

        $this->output->writeln("Get tasks command finished : " . date('Y-m-d H:i:s'));
    }

    public function getTasks()
    {
        $mConfig = new Config();
        $activeSprint = $mConfig->getActiveSprint();

        $mTaskUrl = new TaskUrl();
        $taskUrl = $mTaskUrl->getTaskUrl($activeSprint);

        return Http::get($taskUrl)->json();
    }

    public function mapTasks($tasks): array
    {
        $mConfig = new Config();
        $activeSprint = $mConfig->getActiveSprint();

        $mappedTasks = [];
        foreach ($tasks as $task) {
            $mappedTasks[] = [
                'sprint' => $activeSprint,
                'name' => $task['id'],
                'difficulty' => $task['zorluk'] ?? $task['value'],
                'estimated_time' => $task['sure'] ?? $task['estimated_duration'],
            ];
        }
        return $mappedTasks;
    }
}
