<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Category;
use App\Models\City;
use App\Models\Employee;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Information;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home()
    {
        $guides = Guide::orderBy("created_at", "desc")->with('city')->limit(4)->get();
        $hotels = Hotel::orderBy("created_at", "desc")->with('city')->limit(4)->get();
        $agences = Agence::orderBy("created_at", "desc")->with('city')->limit(4)->get();

        return response()->json(['hotels' => $hotels,'guides' => $guides, 'agences' => $agences]);
    }

    public function stats()
    {
        $guides = count(Guide::all());
        $hotels = count(Hotel::all());
        $agencies = count(Agence::all());
        $cities = count(City::all());
        $users = count(User::all());
        $employees = count(Employee::all());
        $categories = count(Category::all());
        $informations = count(Information::all());

        return response()->json(['hotels' => $hotels, 'informations' => $informations, 'categories' => $categories, 'employees' => $employees, 'users' => $users, 'cities' => $cities,'guides' => $guides, 'agencies' => $agencies]);
    }

}
