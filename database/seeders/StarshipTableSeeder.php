<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class StarshipTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 4; $i++) {
            $response = Http::get('https://swapi.dev/api/starships?page=' . $i);
            $starships = $response->json('results');

            foreach ($starships as $starship) {
                // Guarda los datos en la base de datos
                \DB::table('starships')->insert([
                    'name' => !empty($starship['name']) ? $starship['name'] : null,
                    'model' => !empty($starship['model']) ? $starship['model'] : null,
                    'manufacturer' => !empty($starship['manufacturer']) ? $starship['manufacturer'] : null,
                    'cost_in_credits' => !empty($starship['cost_in_credits']) ? $starship['cost_in_credits'] : null,
                    'length' => !empty($starship['length']) ? $starship['length'] : null,
                    'max_atmosphering_speed' => !empty($starship['max_atmosphering_speed']) ? $starship['max_atmosphering_speed'] : null,
                    'crew' => !empty($starship['crew']) ? $starship['crew'] : null,
                    'passengers' => !empty($starship['passengers']) ? $starship['passengers'] : null,
                    'cargo_capacity' => !empty($starship['cargo_capacity']) ? $starship['cargo_capacity'] : null,
                    'consumables' => !empty($starship['consumables']) ? $starship['consumables'] : null,
                    'hyperdrive_rating' => !empty($starship['hyperdrive_rating']) ? $starship['hyperdrive_rating'] : null,
                    'mglt' => !empty($starship['MGLT']) ? $starship['MGLT'] : null,
                    'starship_class' => !empty($starship['cargo_capacity']) ? $starship['cargo_capacity'] : null,
                    'pilots' => json_encode($starship['pilots']),
                    'films' => json_encode($starship['films']),
                    'url' => !empty($starship['url']) ? $starship['url'] : null,
                    'created' => Carbon::parse($starship['created']),
                    'edited' => Carbon::parse($starship['edited']),
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
