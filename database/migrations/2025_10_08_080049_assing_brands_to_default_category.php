<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class AssignBrandsToDefaultCategory extends Migration
{
    public function up()
    {
        $categoryId = DB::table('categories')->where('name', 'Default')->value('id');
        if (!$categoryId) {
            $categoryId = DB::table('categories')->insertGetId([
                'name' => 'Default',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }

        DB::table('brands')->update(['category_id' => $categoryId]);
    }

    public function down()
    {
        DB::table('brands')->update(['category_id' => null]);
        DB::table('categories')->where('name', 'Default')->delete();
    }
}
