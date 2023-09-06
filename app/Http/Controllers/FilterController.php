<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\City;
use App\Models\Hotel;
use Illuminate\Http\Request;

class FilterController extends Controller
{
    public function getCities (){
        $cities = City::all();
        return response()->json(['cities'=>$cities]);
    }public function getCategories (){
        $categories = Category::all();
        return response()->json(['categories'=>$categories]);
    }
    public function filter(Request $request)
    {
        $query = Hotel::query();
        if ($request->filled('city')) {
            $query->where("city_id", $request->city);
        }
        if ($request->filled('priceMin')) {
            $query->where([["price", '>=', $request->priceMin]]);
        }
        if ($request->filled('priceMax')) {
            $query->where([["price", '<=', $request->priceMax]]);
        }
        if ($request->filled(['priceMin', 'priceMax'])) {
            $query->where([["price", '>=', $request->priceMin], ["price", '<=', $request->priceMax]]);
        }
        if ($request->filled('star')) {
            $query->where("star", $request->star);
        }
        $hotels = $query->orderBy('created_at', 'desc')->with('city')->get();
        $hotelsLenght = count($hotels);

        return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
    }
    public function filterPerPage(Request $request, $page)
    {
        $query = Hotel::query();
        if ($request->filled('city')) {
            $query->where("city_id", $request->city);
        }
        if ($request->filled(['priceMin', 'priceMax'])) {
            $query->where([["price", '>=', $request->priceMin], ["price", '<=', $request->priceMax]]);
        }
        $hotels = $query->orderBy('created_at', 'desc')->with('city')->offset(8 * ($page - 1))->limit(8)->get();
        $hotelsLenght = count($hotels);

        return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
    }
}
