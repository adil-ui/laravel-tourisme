<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\Guide;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class GuideController extends Controller
{
    public function addGuide(Request $request)
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
        $guide = new Guide;
        $guide->email = $request->email;
        $guide->name = $request->name;
        $guide->address = $request->address;
        $guide->phone = $request->phone;
        $guide->description = $request->description;
        $guide->longitude = $request->longitude;
        $guide->latitude = $request->latitude;
        $guide->link = $request->link;
        $guide->role = 'Guide';
        $guide->city_id = $city->id;
        $guide->created_at = Carbon::now();
        $guide->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $guide->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $guide->save();
            return response()->json(["message" => 'Guide ajouter avec succès']);
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }

    public function detailsGuide($id)
    {
        $guide = Guide::where('id', $id)->with('city')->get();
        $guideRelated = Guide::where('city_id', $guide[0]->city_id)->with('city')->limit(5)->get();
        return response()->json(['guide' => $guide, 'guideRelated'=>$guideRelated]);
    }

    public function updateGuide(Request $request, $id)
    {
        $guide = Guide::find($id);
        $picture = $guide->picture;
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
        Guide::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "address" => $request->address,
            "phone" => $request->phone,
            "picture" => $picture,
            "description" => $request->description,
            "longitude" => $request->longitude,
            "latitude" => $request->latitude,
            "link" => $request->link,
            "city_id" => $city->id,

        ]);

        return response()->json(['message' => 'Modifier avec succès']);

    }
    public function deleteGuide($id)
    {
        Guide::find($id)->delete();
    }
    public function getGuide()
    {
        $guides = Guide::orderBy('created_at', 'desc')->with('city')->get();
        return response()->json(['guides' => $guides]);
    }
    public function getGuidePerPage($page)
    {
        $guides = Guide::orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
        $guidesLenght = count(Guide::all());
        return response()->json(['guides' => $guides, 'guidesLenght' => $guidesLenght]);
    }
    public function getHomeGuidePerPage($page)
    {
        $guides = Guide::orderBy('created_at', 'desc')->with('city')->offset(8 * ($page - 1))->limit(8)->get();
        $guidesLenght = count(Guide::all());
        return response()->json(['guides' => $guides, 'guidesLenght' => $guidesLenght]);
    }
    public function search(Request $request, $page)
    {
        if ($request->search == "all") {
            $guides = Guide::orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
            $guidesLenght = count(Guide::all());
            return response()->json(['guides' => $guides, 'guidesLenght' => $guidesLenght]);
        }
        if ($request->search == "id") {
            $guides = Guide::where('id', $request->searchValue)->with('city')->get();
            $guidesLenght = count($guides);
            return response()->json(['guides' => $guides, 'guidesLenght' => $guidesLenght]);
        }
        if ($request->search == "name") {
            $guides = Guide::where('name', $request->searchValue)->orderBy('created_at', 'desc')->with('city')->get();
            $guidesLenght = count($guides);
            return response()->json(['guides' => $guides, 'guidesLenght' => $guidesLenght]);
        }
        if ($request->search == "city") {
            try {
                $citySelected = City::where('name', $request->searchValue)->get();
                $guides = Guide::where('city_id', $citySelected[0]->id)->orderBy('created_at', 'desc')->with('city')->offset(7 * ($page - 1))->limit(7)->get();
                $guidesLenght = count(Guide::where('city_id', $citySelected[0]->id)->get());
                return response()->json(['guides' => $guides, 'guidesLenght' => $guidesLenght]);
            } catch (Exception $e) {
                return response()->json(['guides' => [], "guidesLenght" => 0]);
            }
        }

    }

    }













