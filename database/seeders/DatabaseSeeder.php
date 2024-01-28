<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Config;
use App\Models\Developer;
use App\Models\TaskUrl;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void   // Create dummy data
    {
        Config::insert([
            'key' => 'active_sprint',
            'value' => 1,
        ]);

        Developer::insert([
            ['name' => 'Dev 1', 'labor_per_hour' => 1],
            ['name' => 'Dev 2', 'labor_per_hour' => 2],
            ['name' => 'Dev 3', 'labor_per_hour' => 3],
            ['name' => 'Dev 4', 'labor_per_hour' => 4],
            ['name' => 'Dev 5', 'labor_per_hour' => 5],
        ]);

        TaskUrl::insert([
            ['sprint' => 1, 'url' => 'https://run.mocky.io/v3/27b47d79-f382-4dee-b4fe-a0976ceda9cd'],
            ['sprint' => 1, 'url' => 'https://run.mocky.io/v3/7b0ff222-7a9c-4c54-9396-0df58e289143'],
        ]);
    }
}
