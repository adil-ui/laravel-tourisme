<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class CategoryController extends Controller
{
    public function addCategory(Request $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->created_at = Carbon::now();
        $category->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $category->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $category->save();
            return response()->json(["message" => 'Category ajouter avec succès']);
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }

    public function detailsCategory($id)
    {
        $category = Category::where('id', $id)->get();
        return response()->json(['category' => $category]);
    }

    public function updateCategory(Request $request, $id)
    {
        $category = Category::find($id);
        $picture = $category->picture;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture = "storage/" . $request->picture->store('user/images');
        }

        Category::where("id", $id)->update([
            "name" => $request->name,
            "picture" => $picture,
        ]);

        return response()->json(['message' => 'Modifier avec succès']);

    }
    public function deleteCategory($id)
    {
        Category::find($id)->delete();
    }
    public function getCategory()
    {
        $categories = Category::orderBy('created_at', 'desc')->get();
        return response()->json(['categories' => $categories]);
    }
    public function getCategoryPerPage($page)
    {
        $categories = Category::orderBy('created_at', 'desc')->offset(7 * ($page - 1))->limit(7)->get();
        $categoriesLenght = count(Category::all());
        return response()->json(['categories' => $categories, 'categoriesLenght' => $categoriesLenght]);
    }
    public function getHomeCategoryPerPage($page)
    {
        $categories = Category::orderBy('created_at', 'desc')->offset(8 * ($page - 1))->limit(8)->get();
        $categoriesLenght = count(Category::all());
        return response()->json(['categories' => $categories, 'categoriesLenght' => $categoriesLenght]);
    }
    public function search(Request $request, $page)
    {
        if ($request->search == "all") {
            $categories = Category::orderBy('created_at', 'desc')->offset(7 * ($page - 1))->limit(7)->get();
            $categoriesLenght = count(Category::all());
            return response()->json(['categories' => $categories, 'categoriesLenght' => $categoriesLenght]);
        }
        if ($request->search == "id") {
            $categories = Category::where('id', $request->searchValue)->get();
            $categoriesLenght = count($categories);
            return response()->json(['categories' => $categories, 'categoriesLenght' => $categoriesLenght]);
        }
        if ($request->search == "name") {
            $categories = Category::where('name', $request->searchValue)->orderBy('created_at', 'desc')->get();
            $categoriesLenght = count($categories);
            return response()->json(['categories' => $categories, 'categoriesLenght' => $categoriesLenght]);
        }


    }

    }













