<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class VehiclesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $response = Http::get('https://swapi.dev/api/vehicles?page=' . $i);
            $vehicles = $response->json('results');

            foreach ($vehicles as $vehicle) {
                // Guarda los datos en la base de datos
                \DB::table('vehicles')->insert([
                    'name' => !empty($vehicle['name']) ? $vehicle['name'] : null,
                    'model' => !empty($vehicle['model']) ? $vehicle['model'] : null,
                    'manufacturer' => !empty($vehicle['manufacturer']) ? $vehicle['manufacturer'] : null,
                    'cost_in_credits' => !empty($vehicle['cost_in_credits']) ? $vehicle['cost_in_credits'] : null,
                    'length' => !empty($vehicle['length']) ? $vehicle['length'] : null,
                    'max_atmosphering_speed' => !empty($vehicle['max_atmosphering_speed']) ? $vehicle['max_atmosphering_speed'] : null,
                    'crew' => !empty($vehicle['crew']) ? $vehicle['crew'] : null,
                    'passengers' => !empty($vehicle['passengers']) ? $vehicle['passengers'] : null,
                    'cargo_capacity' => !empty($vehicle['cargo_capacity']) ? $vehicle['cargo_capacity'] : null,
                    'consumables' => !empty($vehicle['consumables']) ? $vehicle['consumables'] : null,
                    'vehicle_class' => !empty($vehicle['vehicle_class']) ? $vehicle['vehicle_class'] : null,
                    'pilots' => json_encode($vehicle['pilots']),
                    'films' => json_encode($vehicle['films']),
                    'url' => !empty($vehicle['url']) ? $vehicle['url'] : null,
                    'created' => Carbon::parse($vehicle['created']),
                    'edited' => Carbon::parse($vehicle['edited']),
                    'starship_id' => rand(1, 36),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
