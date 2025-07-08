<?php

namespace Database\Seeders;

use App\Models\PeripheralType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeripheralSeeder extends Seeder
{
    public function run(): void
    {
        PeripheralType::create(['name' => 'Monitor']);
        PeripheralType::create(['name' => 'Teclado']);
        PeripheralType::create(['name' => 'Mouse']);
        PeripheralType::create(['name' => 'Mouse Pad']);
        PeripheralType::create(['name' => 'Parlante']);
        PeripheralType::create(['name' => 'Webcam']);
        PeripheralType::create(['name' => 'Audífonos']);
    }
}
