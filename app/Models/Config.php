<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Config extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'configs';

    public function getActiveSprint()
    {
        $activeSprint = Cache::driver('apc')->get('active_sprint');
        if (empty($activeSprint)) {
            $activeSprint = Config::where('key', 'active_sprint')->value('value');
            Cache::driver('apc')->set('active_sprint', $activeSprint, 30);
        }
        return $activeSprint;
    }
}
