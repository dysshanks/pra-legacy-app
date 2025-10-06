<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ManualSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('manuals')->insert([
            [
                'brand_id' => 1,
                'name' => 'iPhone 15 User Guide',
                'filesize' => 2048000,
                'originUrl' => 'https://example.com/manuals/apple/iphone15.pdf',
                'filename' => 'iphone15_user_guide.pdf',
                'downloadedServer' => 'server-1',
                'popularity' => 95,
                'catagory' => 'Smartphone',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 2,
                'name' => 'Galaxy S23 User Manual',
                'filesize' => 3050000,
                'originUrl' => 'https://example.com/manuals/samsung/galaxy_s23.pdf',
                'filename' => 'galaxy_s23_manual.pdf',
                'downloadedServer' => 'server-2',
                'popularity' => 87,
                'catagory' => 'Smartphone',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 3,
                'name' => 'Sony Bravia Setup Guide',
                'filesize' => 1250000,
                'originUrl' => 'https://example.com/manuals/sony/bravia_setup.pdf',
                'filename' => 'bravia_setup.pdf',
                'downloadedServer' => 'server-1',
                'popularity' => 73,
                'catagory' => 'Television',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 4,
                'name' => 'LG Refrigerator Manual',
                'filesize' => 2100000,
                'originUrl' => 'https://example.com/manuals/lg/fridge.pdf',
                'filename' => 'lg_fridge_manual.pdf',
                'downloadedServer' => 'server-3',
                'popularity' => 55,
                'catagory' => 'Appliance',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'brand_id' => 5,
                'name' => 'Surface Pro 9 Guide',
                'filesize' => 1780000,
                'originUrl' => 'https://example.com/manuals/microsoft/surface_pro9.pdf',
                'filename' => 'surface_pro9_guide.pdf',
                'downloadedServer' => 'server-2',
                'popularity' => 62,
                'catagory' => 'Laptop',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
