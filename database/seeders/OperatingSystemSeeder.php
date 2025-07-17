<?php

namespace Database\Seeders;

use App\Models\OperationSystem;
use Illuminate\Database\Seeder;

class OperatingSystemSeeder extends Seeder
{
    public function run(): void
    {
        OperationSystem::create(['name' => 'Windows']);
        OperationSystem::create(['name' => 'Linux']);
        OperationSystem::create(['name' => 'MacOS']);
    }
}
