<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Manual;

class BrandController extends Controller
{
    public function show($brand_id, $brand_slug)
    {


        $brand = Brand::findOrFail($brand_id);
        $manuals = Manual::where('brand_id', $brand_id)->get();
        $popularManuals = Manual::where('brand_id', $brand_id)->orderByDesc('popularity')->take(5)->get();

        return view('pages/manual_list', [
            "brand" => $brand,
            "manuals" => $manuals,
            "popularManuals" => $popularManuals
        ]);

    }
    public function byLetter($letter)
    {
        $brands = \App\Models\Brand::where('name', 'LIKE', $letter . '%')
            ->orderBy('name')
            ->get();

        return view('pages.byLetter', compact('brands', 'letter'));
    }

}
