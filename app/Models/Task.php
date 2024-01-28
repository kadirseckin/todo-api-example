<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Task extends Model
{
    use HasFactory;

    protected $table = 'tasks';

    public function updateOrCreateByName($tasks)
    {
        Task::upsert($tasks, ['name'], ['difficulty', 'estimated_time', 'sprint']);
    }

    public function getTasksBySprint($sprint)
    {
        return Task::where('sprint', $sprint)->get()->toArray();
    }
}
