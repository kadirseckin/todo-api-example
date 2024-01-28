<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class TaskUrl extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'task_urls';

    public function getTaskUrl($sprint)
    {
        $taskUrl = Cache::driver('apc')->get('task_url');
        if (empty($taskUrl)) {
            $taskUrl = TaskUrl::where('sprint', $sprint)->value('url');
            Cache::driver('apc')->set('task_url', $taskUrl);
        }
        return $taskUrl;
    }
}
