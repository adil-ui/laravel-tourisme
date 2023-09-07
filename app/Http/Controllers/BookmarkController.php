<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use App\Models\City;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;


class BookmarkController extends Controller
{
    public function addBookmark(Request $request, $id)
    {
        if ($request->city != '') {
            $query = City::where('name', $request->city)->getQuery();
            $city = $query->first();
        }
        $bookmark = new bookmark;
        $bookmark->email = $request->email;
        $bookmark->name = $request->name;
        $bookmark->address = $request->address;
        $bookmark->phone = $request->phone;
        $bookmark->description = $request->description;
        $bookmark->price = $request->price;
        $bookmark->star = $request->star;
        $bookmark->longitude = $request->longitude;
        $bookmark->latitude = $request->latitude;
        $bookmark->link = $request->link;
        $bookmark->picture = $request->picture;
        $bookmark->city_id = $city->id;
        $bookmark->user_id = $id;
        $bookmark->created_at = Carbon::now();
        $bookmark->updated_at = Carbon::now();
        // if ($request->filled('picture')) {
        //     $bookmark->picture = 'storage/' . $request->picture->store('images/bookmark');
        // }
        try {
            $bookmark->save();
            return response()->json(["message" => 'Hôtel ajouter avec succès']);
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }
    public function getBookmark($id)
    {
        $bookmarks = Bookmark::where('user_id', $id)->with('city')->get();
        return response()->json(['bookmarks' => $bookmarks]);
    }

    public function getBookmarkPerPage($page, $id)
    {
        $bookmarks = Bookmark::where('user_id', $id)->with('city')->offset(8 * ($page - 1))->limit(8)->get();
        $bookmarksLenght = count(Bookmark::all());
        return response()->json(['bookmarks' => $bookmarks, 'bookmarksLenght' => $bookmarksLenght]);
    }
    public function deleteBookmark($id)
    {
        Bookmark::where('name', $id)->delete();
    }
    public function testBookmark($name)
    {
        $query = Bookmark::where('name', $name)->getQuery();
        if ($query->exists()) {
            return response()->json(['message'=>'true']);

        } else {
            return response()->json(['message'=>'false']);

        }

    }
}
