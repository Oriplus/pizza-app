<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $now = Carbon::now();

        DB::table('ingredients')->insert([
            ['name' => 'Tomato', 'cost_price' => 0.50, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Cheese', 'cost_price' => 0.75, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sliced onion', 'cost_price' => 0.45, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Oregano', 'cost_price' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sliced mushrooms', 'cost_price' => 0.50, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Feta cheese', 'cost_price' => 0.55, 'created_at' => $now, 'updated_at' => $now],
            ['name' => 'Sausages', 'cost_price' => 0.15, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
