<?php

namespace App\Http\Controllers;

use App\Models\Agence;
use App\Models\City;
use App\Models\Guide;
use App\Models\Hotel;
use App\Models\Tourist;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request)
    {
        $flight = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->type,
            'status' => 'Débloquer',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ]);
        error_log($flight->id);
        if ($request->type === 'Hotel') {
            $user = new Hotel;
        } elseif ($request->type === 'Agence') {
            $user = new Agence;
        } elseif ($request->type === 'Guide') {
            $user = new Guide;
        } else {
            $user = new Tourist;
        }
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->name = $request->name;
        $user->address = $request->address;
        $user->phone = $request->phone;
        $user->role = $request->type;
        $user->user_id = $flight->id;
        $user->created_at = Carbon::now();
        $user->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $user->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $user->save();
            return $user;
        } catch (Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }


    }
    public function updateUser(Request $request, $id)
    {

            $userFind = User::find($id);
            $userRole = $userFind->role;
            error_log($userRole);
            if($userRole === 'Tourist'){
                $tableName = 'tourists';
            }elseif($userRole === 'Hotel'){
                $tableName = 'hotels';
            }elseif($userRole === 'Guide'){
                $tableName = 'guides';
            }elseif($userRole === 'Agence'){
                $tableName = 'agences';
            }else{
                $tableName = 'employees';
            }
            error_log($tableName);

            $user = DB::table($tableName)
            ->where('user_id', $id)
            ->first();
            $picture = $user->picture;
            if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
                $picture = "storage/" . $request->picture->store('user/images');
            }
            if($request->email != '' || $request->password != ''){
                User::where('id', $id)->update([
                    "email" => $user->email != $request->email ? $request->email : $user->email,
                    "password" => $user->password != $request->password ? Hash::make($request->password) : $user->password,
                ]);
            }
            if($request ->city != ''){
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
            if($tableName === 'hotels'){
                $user = DB::table($tableName)->where("user_id", $id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "address" => $request->address,
                    "phone" => $request->phone,
                    "password" => $user->password != $request->password ? Hash::make($request->password) : $user->password,
                    "picture" => $picture,
                    "description" => $request->description,
                    "price" => $request->price,
                    "star" => $request->star,
                    "longitude" => $request->longitude,
                    "latitude" => $request->latitude,
                    "link" => $request->link,
                    "city_id" => $city->id,

                ]);
            }elseif($tableName === 'agences'){
                $user = DB::table($tableName)->where("user_id", $id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "address" => $request->address,
                    "phone" => $request->phone,
                    "password" => $user->password != $request->password ? Hash::make($request->password) : $user->password,
                    "picture" => $picture,
                    "description" => $request->description,
                    "price" => $request->price,
                    "longitude" => $request->longitude,
                    "latitude" => $request->latitude,
                    "link" => $request->link,
                    "city_id" => $city->id,

                ]);
            }elseif($tableName === 'guides'){
                $user = DB::table($tableName)->where("user_id", $id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "address" => $request->address,
                    "phone" => $request->phone,
                    "password" => $user->password != $request->password ? Hash::make($request->password) : $user->password,
                    "picture" => $picture,
                    "description" => $request->description,
                    "longitude" => $request->longitude,
                    "latitude" => $request->latitude,
                    "link" => $request->link,
                    "city_id" => $city->id,

                ]);
            }else{
                $user = DB::table($tableName)->where("user_id", $id)->update([
                    "name" => $request->name,
                    "email" => $request->email,
                    "address" => $request->address,
                    "phone" => $request->phone,
                    "password" => $user->password != $request->password ? Hash::make($request->password) : $user->password,
                    "picture" => $picture,

                ]);
            }

            $user = DB::table($tableName)
            ->where('user_id', $id)
            ->first();
            return response()->json(['success' => 'Modify successfully', "user" => $user]);

    }
}
