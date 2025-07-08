<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        Feature::create(['name' => 'Velocidad de Procesador en (GHz)']);
        Feature::create(['name' => 'Cantidad de Nucleos']);
        Feature::create(['name' => 'Modelo de Procesador']);
        Feature::create(['name' => 'Cantidad de Memoria RAM']);
        Feature::create(['name' => 'Tipo de Memoria RAM']);
        Feature::create(['name' => 'Velocidad de Memoria RAM']);
        Feature::create(['name' => 'Tarjeta Grafica']);
        Feature::create(['name' => 'Modelo de Tarjeta Grafica']);
        Feature::create(['name' => 'Capacidad de Tarjeta Grafica en (GB)']);
        Feature::create(['name' => 'Velocidad de Tarjeta Grafica']);
        Feature::create(['name' => 'Tamaño de Pantalla']);
        Feature::create(['name' => 'Tipo de Pantalla']);
        Feature::create(['name' => 'Tipo de Almacenamiento']);
        Feature::create(['name' => 'Velocidad de Disco Duro']);
        Feature::create(['name' => 'Espacio de Almacenamiento en (GB)']);
        Feature::create(['name' => 'Usa Tarjeta de Wi-Fi']);
        Feature::create(['name' => 'Usa Tarjeta de Bluetooth']);
        Feature::create(['name' => 'Usa Tarjeta de Red']);
        Feature::create(['name' => 'Esta en Red']);
        Feature::create(['name' => 'Dirección IP']);
        Feature::create(['name' => 'Es de tinta']);
        Feature::create(['name' => 'Es de tonner']);
    }
}
