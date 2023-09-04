<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Hotel;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class HotelController extends Controller
{
    public function addHotel(Request $request)
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
        $hotel = new Hotel;
        $hotel->email = $request->email;
        $hotel->name = $request->name;
        $hotel->address = $request->address;
        $hotel->phone = $request->phone;
        $hotel->description = $request->description;
        $hotel->price = $request->price;
        $hotel->star = $request->star;
        $hotel->longitude = $request->longitude;
        $hotel->latitude = $request->latitude;
        $hotel->link = $request->link;
        $hotel->role = 'Hotel';
        $hotel->city_id = $city->id;
        $hotel->created_at = Carbon::now();
        $hotel->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $hotel->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $hotel->save();
            return response()->json(["message" => 'Hôtel ajouter avec succès']);
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }

    public function detailsHotel($id)
    {
        $hotel = Hotel::where('id', $id)->with('city')->get();
        $hotelRelated = Hotel::where('city_id', $hotel[0]->city_id)->with('city')->limit(5)->get();
        return response()->json(['hotel' => $hotel, 'hotelRelated'=>$hotelRelated]);
    }

    public function updateHotel(Request $request, $id)
    {

        $hotel = Hotel::find($id);
        $picture = $hotel->picture;
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
        Hotel::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "address" => $request->address,
            "phone" => $request->phone,
            "picture" => $picture,
            "description" => $request->description,
            "price" => $request->price,
            "star" => $request->star,
            "longitude" => $request->longitude,
            "latitude" => $request->latitude,
            "link" => $request->link,
            "city_id" => $city->id,

        ]);

        return response()->json(['message' => 'Modifier avec succès']);

    }
    public function deleteHotel($id)
    {
        Hotel::find($id)->delete();
    }
    public function getHotel()
    {
        $hotels = Hotel::orderBy("created_at", "desc")->with('city')->get();
        return response()->json(['hotels' => $hotels]);
    }
    public function getHotelPerPage($page)
    {
        $hotels = Hotel::orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
        $hotelsLenght = count(Hotel::all());
        return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
    }
    public function getHomeHotelPerPage($page)
    {
        $hotels = Hotel::orderBy('created_at', 'desc')->with('city')->offset(8 * ($page - 1))->limit(8)->get();
        $hotelsLenght = count(Hotel::all());
        return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
    }
    public function search(Request $request, $page)
    {
        if ($request->search == "all") {
            $hotels = Hotel::orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
            $hotelsLenght = count(Hotel::all());
            return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
        }
        if ($request->search == "id") {
            $hotels = Hotel::where('id', $request->searchValue)->with('city')->get();
            $hotelsLenght = count($hotels);
            return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
        }
        if ($request->search == "name") {
            $hotels = Hotel::where('name', $request->searchValue)->orderBy('created_at', 'desc')->with('city')->get();
            $hotelsLenght = count($hotels);
            return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
        }
        if ($request->search === "star") {
            $hotels = Hotel::where('star', $request->searchValue)->orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
            $hotelsLenght = count(Hotel::where('star', $request->searchValue)->get());
            return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
        }
        if ($request->search == "city") {
            try {
                $citySelected = City::where('name', $request->searchValue)->get();
                $hotels = Hotel::where('city_id', $citySelected[0]->id)->orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
                $hotelsLenght = count(Hotel::where('city_id', $citySelected[0]->id)->get());
                return response()->json(['hotels' => $hotels, 'hotelsLenght' => $hotelsLenght]);
            } catch (Exception $e) {
                return response()->json(['hotels' => [], "hotelsLenght" => 0]);
            }
        }

    }

    }













