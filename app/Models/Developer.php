<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Developer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'developers';

    public function getDevelopers()
    {
        $developers = Cache::driver('apc')->get('developers');
        if (empty($developers)) {
            $developers = Developer::all()->toArray();
            Cache::driver('apc')->set('developers', $developers);
        }
        return $developers;
    }
}
