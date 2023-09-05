<?php

namespace App\Http\Controllers;

use App\Models\Information;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;


class InfoController extends Controller
{
    public function addInformation(Request $request)
    {

        $information = new Information;
        $information->title = $request->title;
        $information->description = $request->description;
        $information->category_id = $request->category;
        $information->created_at = Carbon::now();
        $information->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $information->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $information->save();
            return response()->json(["message" => 'Information ajouter avec succès']);
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }

    public function detailsInformation($id)
    {
        $information = Information::where('id', $id)->with('category')->get();
        return response()->json(['information' => $information]);
    }

    public function updateInformation(Request $request, $id)
    {
        $information = Information::find($id);
        $picture = $information->picture;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture = "storage/" . $request->picture->store('user/images');
        }
        Information::where("id", $id)->update([
            "title" => $request->title,
            "picture" => $picture,
            "description" => $request->description,
            "category_id" => $request->category,
        ]);
        return response()->json(['message' => 'Modifier avec succès']);

    }
    public function deleteInformation($id)
    {
        Information::find($id)->delete();
    }
    public function getInformation()
    {
        $informations = Information::orderBy('created_at', 'desc')->with('category')->get();
        return response()->json(['informations' => $informations]);
    }
    public function getInformationPerPage($page)
    {
        $informations = Information::orderBy('created_at', 'desc')->with('category')->offset(7 * ($page - 1))->limit(7)->get();
        $informationsLenght = count(Information::all());
        return response()->json(['informations' => $informations, 'informationsLenght' => $informationsLenght]);
    }
    public function getHomeInformationPerPage($page)
    {
        $informations = Information::orderBy('created_at', 'desc')->with('category')->offset(8 * ($page - 1))->limit(8)->get();
        $informationsLenght = count(Information::all());
        return response()->json(['informations' => $informations, 'informationsLenght' => $informationsLenght]);
    }
    public function search(Request $request, $page)
    {
        if ($request->search == "all") {
            $informations = Information::orderBy('created_at', 'desc')->with('category')->offset(7 * ($page - 1))->limit(7)->get();
            $informationsLenght = count(Information::all());
            return response()->json(['informations' => $informations, 'informationsLenght' => $informationsLenght]);
        }
        if ($request->search == "id") {
            $informations = Information::where('id', $request->searchValue)->with('category')->get();
            $informationsLenght = count($informations);
            return response()->json(['informations' => $informations, 'informationsLenght' => $informationsLenght]);
        }
        if ($request->search == "title") {
            $informations = Information::where('title', $request->searchValue)->orderBy('created_at', 'desc')->with('category')->get();
            $informationsLenght = count($informations);
            return response()->json(['informations' => $informations, 'informationsLenght' => $informationsLenght]);
        }


    }
    }













