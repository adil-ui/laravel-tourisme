<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\City;
use App\Models\Hotel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class AgencyController extends Controller
{
    public function addAgency(Request $request)
    {
        if ($request->city != '') {
            $query = City::where('name', $request->city)->getQuery();
            if (!$query->exists()) {
                $city = City::create([
                    "name" => $request->city
                ]);
            } else {
                $city = $query->first();
            }
        }
        $agency = new Agence;
        $agency->email = $request->email;
        $agency->name = $request->name;
        $agency->address = $request->address;
        $agency->phone = $request->phone;
        $agency->description = $request->description;
        $agency->price = $request->price;
        $agency->longitude = $request->longitude;
        $agency->latitude = $request->latitude;
        $agency->link = $request->link;
        $agency->role = 'Agence';
        $agency->city_id = $city->id;
        $agency->created_at = Carbon::now();
        $agency->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $agency->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $agency->save();
            return response()->json(["message" => 'Agence ajouter avec succès']);
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }

    public function detailsAgency($id)
    {
        $agency = Agence::where('id', $id)->with('city')->get();
        $agencyRelated = Agence::where('city_id', $agency[0]->city_id)->with('city')->limit(5)->get();
        return response()->json(['agency' => $agency, 'hotelRelated'=>$agencyRelated]);
    }

    public function updateAgency(Request $request, $id)
    {
        $agency = Agence::find($id);
        $picture = $agency->picture;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture = "storage/" . $request->picture->store('user/images');
        }

        if ($request->city != '') {
            $query = City::where('name', $request->city)->getQuery();
            error_log($request->city);
            if (!$query->exists()) {
                $city = City::create([
                    "name" => $request->city
                ]);
            } else {
                $city = $query->first();
            }
        }
        Agence::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "address" => $request->address,
            "phone" => $request->phone,
            "picture" => $picture,
            "description" => $request->description,
            "price" => $request->price,
            "longitude" => $request->longitude,
            "latitude" => $request->latitude,
            "link" => $request->link,
            "city_id" => $city->id,

        ]);

        return response()->json(['message' => 'Modifier avec succès']);

    }
    public function deleteAgency($id)
    {
        Agence::find($id)->delete();
    }
    public function getAgency()
    {
        $agencies = Agence::orderBy("created_at", "desc")->with('city')->get();
        return response()->json(['agencies' => $agencies]);
    }
    public function getAgencyPerPage($page)
    {
        $agencies = Agence::orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
        $agenciesLenght = count(Agence::all());
        return response()->json(['agencies' => $agencies, 'agenciesLenght' => $agenciesLenght]);
    }
    public function getHomeAgencyPerPage($page)
    {
        $agencies = Agence::orderBy('created_at', 'desc')->with('city')->offset(8 * ($page - 1))->limit(8)->get();
        $agenciesLenght = count(Agence::all());
        return response()->json(['agencies' => $agencies, 'agenciesLenght' => $agenciesLenght]);
    }
    public function search(Request $request, $page)
    {
        if ($request->search == "all") {
            $agencies = Agence::orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
            $agenciesLenght = count(Agence::all());
            return response()->json(['agencies' => $agencies, 'agenciesLenght' => $agenciesLenght]);
        }
        if ($request->search == "id") {
            $agencies = Agence::where('id', $request->searchValue)->with('city')->get();
            $agenciesLenght = count($agencies);
            return response()->json(['agencies' => $agencies, 'agenciesLenght' => $agenciesLenght]);
        }
        if ($request->search == "name") {
            $agencies = Agence::where('name', $request->searchValue)->orderBy('created_at', 'desc')->with('city')->get();
            $agenciesLenght = count($agencies);
            return response()->json(['agencies' => $agencies, 'agenciesLenght' => $agenciesLenght]);
        }
        if ($request->search == "city") {
            try {
                $citySelected = City::where('name', $request->searchValue)->get();
                $agencies = Agence::where('city_id', $citySelected[0]->id)->orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
                $agenciesLenght = count(Agence::where('city_id', $citySelected[0]->id)->get());
                return response()->json(['agencies' => $agencies, 'agenciesLenght' => $agenciesLenght]);
            } catch (Exception $e) {
                return response()->json(['agencies' => [], "agenciesLenght" => 0]);
            }
        }

    }

    }













