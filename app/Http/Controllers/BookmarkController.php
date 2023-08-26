<?php

namespace App\Http\Controllers;

use App\Models\Bookmark;
use Exception;
use Illuminate\Http\Request;

class BookmarkController extends Controller
{
    public function addBookmark(Request $request)
    {
            $bookmark = new Bookmark();
            $bookmark->type = $request->type;
            $bookmark->offer_id = $request->offer_id;
            $bookmark->tourist_id = $request->tourist_id;
            try {
                $bookmark->save();
                return $bookmark;
            } catch (Exception $e) {
                return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
            }
    }
    public function getBookmark()
    {
        $bookmarks = Bookmark::all();
        return response()->json(['bookmarks' => $bookmarks]);
    }
    public function deleteBookmark($id)
    {
        Bookmark::find($id)->delete();
        return response()->json(['success' => 'Delete successfully']);
    }
}
