<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class AddCategoriesToBrandsTable extends Migration
{
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->timestamps();
        });

        DB::table('categories')->insert([
            ['name' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Audio/Video', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Machinery/Tools', 'created_at' => now(), 'updated_at' => now()],
        ]);

        Schema::table('brands', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->after('name')->constrained('categories')->nullOnDelete();
        });

        $categories = DB::table('categories')->pluck('id', 'name');


        $electronicsBrands = [
            'BenQ', 'Garmin', 'IOGear', 'AOC', 'ALCATEL Mobile Phones', 'Huawei', 'ZTE', 'Motorola',
            'Palm', 'LG Electronics', 'Samsung', 'Sony', 'Pantech', 'Citizen', 'Aastra Telecom', 'RCA',
            'VTech', 'Uniden', 'AT&T', 'GE', 'Toshiba', 'Dell', 'Fujitsu', 'Lenovo', 'Apple'
        ];

        DB::table('brands')->whereIn('name', $electronicsBrands)->update(['category_id' => $categories['Electronics']]);
        $audioVideoBrands = [
            'Humminbird', 'Furuno', 'DigiTech', 'Yamaha', 'Samson', 'JBL', 'Crown Audio', 'MTX Audio', 'Musica', 'DCM Speakers'
        ];

        DB::table('brands')->whereIn('name', $audioVideoBrands)->update(['category_id' => $categories['Audio/Video']]);
        $machineryBrands = [
            'TPI Corporation', 'Land Pride', 'Kohler', 'ProForm', 'Grizzly', 'Carl Zeiss', 'Kowa', 'Pioneer'
        ];

        DB::table('brands')->whereIn('name', $machineryBrands)->update(['category_id' => $categories['Machinery/Tools']]);
    }

    public function down()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });

        Schema::dropIfExists('categories');
    }
}
