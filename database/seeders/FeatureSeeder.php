<?php

namespace Database\Seeders;

use App\Models\Feature;
use App\Models\FeatureAnswer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FeatureSeeder extends Seeder
{
    public function run(): void
    {
        // Feature::create(['name' => 'Velocidad de Procesador en (GHz)']);
        // Feature::create(['name' => 'Cantidad de Nucleos']);
        // Feature::create(['name' => 'Modelo de Procesador']);
        // Feature::create(['name' => 'Cantidad de Memoria RAM']);
        // Feature::create(['name' => 'Tipo de Memoria RAM']);
        // Feature::create(['name' => 'Velocidad de Memoria RAM']);
        // Feature::create(['name' => 'Tarjeta Grafica']);
        // Feature::create(['name' => 'Modelo de Tarjeta Grafica']);
        // Feature::create(['name' => 'Capacidad de Tarjeta Grafica en (GB)']);
        // Feature::create(['name' => 'Velocidad de Tarjeta Grafica']);
        // Feature::create(['name' => 'Tamaño de Pantalla']);
        // Feature::create(['name' => 'Tipo de Pantalla']);
        // Feature::create(['name' => 'Tipo de Almacenamiento']);
        // Feature::create(['name' => 'Velocidad de Disco Duro']);
        // Feature::create(['name' => 'Espacio de Almacenamiento en (GB)']);
        // Feature::create(['name' => 'Usa Tarjeta de Wi-Fi']);
        // Feature::create(['name' => 'Usa Tarjeta de Bluetooth']);
        // Feature::create(['name' => 'Usa Tarjeta de Red']);
        // Feature::create(['name' => 'Esta en Red']);
        // Feature::create(['name' => 'Dirección IP']);
        // Feature::create(['name' => 'Es de tinta']);
        // Feature::create(['name' => 'Es de tonner']);
        // Feature::create(['name' => 'Distribución de Linux']);

        $features = [
            [
                'name' => 'Velocidad de Procesador en (GHz)',
                'is_open' => true,
            ],
            [
                'name' => 'Cantidad de Nucleos',
                'is_open' => true,
            ],
            [
                'name' => 'Modelo de Procesador',
                'is_open' => true,
            ],
            [
                'name' => 'Cantidad de Memoria RAM',
                'is_open' => true,
            ],
            [
                'name' => 'Tipo de Memoria RAM',
                'is_open' => false,
                'answers' => [
                    'DDR2',
                    'DDR3',
                    'DDR4',
                    'DDR5',
                ]
            ],
            [
                'name' => 'Velocidad de Memoria RAM',
                'is_open' => true,
            ],
            [
                'name' => 'Tarjeta Grafica',
                'is_open' => true,
            ],
            [
                'name' => 'Modelo de Tarjeta Grafica',
                'is_open' => true,
            ],
            [
                'name' => 'Capacidad de Tarjeta Grafica en (GB)',
                'is_open' => true,
            ],
            [
                'name' => 'Velocidad de Tarjeta Grafica',
                'is_open' => true,
            ],
            [
                'name' => 'Tamaño de Pantalla',
                'is_open' => true,
            ],
            [
                'name' => 'Tipo de Pantalla',
                'is_open' => true,
            ],
            [
                'name' => 'Tipo de Almacenamiento',
                'is_open' => true,
            ],
            [
                'name' => 'Velocidad de Disco Duro',
                'is_open' => true,
            ],
            [
                'name' => 'Espacio de Almacenamiento en (GB)',
                'is_open' => true,
            ],
            [
                'name' => 'Usa Tarjeta de Wi-Fi',
                'is_open' => false,
                'answers' => [
                    'Si',
                    'No',
                ]
            ],
            [
                'name' => 'Usa Tarjeta de Bluetooth',
                'is_open' => false,
                'answers' => [
                    'Si',
                    'No',
                ]
            ],
            [
                'name' => 'Usa Tarjeta de Red',
                'is_open' => false,
                'answers' => [
                    'Si',
                    'No',
                ]
            ],
            [
                'name' => 'Esta en Red',
                'is_open' => false,
                'answers' => [
                    'Si',
                    'No',
                ]
            ],
            [
                'name' => 'Dirección IP',
                'is_open' => true,
            ],
            [
                'name' => 'Tipo de impresora',
                'is_open' => false,
                'answers' => [
                    'Tinta',
                    'Toner',
                ],
            ],

        ];

        foreach ($features as $feature) {
            $featureModel = Feature::create([
                'name' => $feature['name'],
                'is_open' => $feature['is_open']
            ]);
            if ($featureModel->is_open == false) {
                foreach ($feature['answers'] as $answer) {
                    FeatureAnswer::create([
                        'feature_id' => $featureModel->id,
                        'value' => $answer,
                    ]);
                }
            }
        }
    }
}
