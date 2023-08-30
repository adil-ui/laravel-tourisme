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
        $hotel->password = $request->password ? Hash::make($request->password) : null;
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

    public function getHotel()
    {
        $hotels = Hotel::orderBy("created_at", "desc")->with('city')->get();
        return response()->json(['hotels' => $hotels]);
    }
    public function detailsHotel($id)
    {
        $hotel = Hotel::where('id', $id)->with('city')->get();
        return response()->json(['hotel' => $hotel]);
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
            "password" => $hotel->password != $request->password ? Hash::make($request->password) : $hotel->password,
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














}
