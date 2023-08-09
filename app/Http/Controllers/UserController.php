<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Tourist;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
            if ($request->filled(["name", "email", "address", "phone", "password"])) {
                if($request->type === 'hotel'){
                    $user = new Hotel;
                }elseif($request->type === 'agence'){
                    $user = new Agence;
                }elseif($request->type === 'guide'){
                    $user = new Guide;
                }else{
                    $user = new Tourist;
                }

                $user->email = $request->email;
                $user->password = Hash::make($request->password);
                $user->name = $request->name;
                $user->address = $request->address;
                $user->phone = $request->phone;
                $user->created_at = Carbon::now();
                $user->updated_at = Carbon::now();
                if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
                    $user->picture = 'storage/' . $request->picture->store('user/images');
                }
                try {
                    $user->save();

                    return $user;
                } catch (Exception $e) {
                    return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
                }
            } else {
                return response()->json(["error" => "Fields are required"], 400);
            }
    }
}
