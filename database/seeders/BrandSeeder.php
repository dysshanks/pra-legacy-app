<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('brands')->insert([
            ['name' => 'Apple', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Samsung', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sony', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'LG', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Microsoft', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
