<?php

namespace App\Http\Controllers;

use App\Mail\ResetPassword;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            if(Auth::user()->status === 'Bloquer'){
                return response()->json(["message" => "Your account is blocked"]);
            }else{
                if(Auth::user()->role === 'Tourist'){
                    $tableName = 'tourists';
                }elseif(Auth::user()->role === 'Hotel'){
                    $tableName = 'hotels';
                }elseif(Auth::user()->role === 'Agence'){
                    $tableName = 'agences';
                }else{
                    $tableName = 'guides';
                }
                $user = DB::table($tableName)
                ->where('user_id', Auth::user()->id)
                ->first();
                return response()->json(["user" => $user], 200);
            }
        }
        return response()->json(["message" => "User Not Found"], 404);



    }

    public function forgotPassword(Request $request)
    {
        $queryResults = User::where("email", $request->email)->getQuery();
        if ($queryResults->exists()) {
            $user = $queryResults->first();
            $token = md5($request->email);
            DB::table('password_reset_tokens')->insert([
                "email" => $request->email,
                "token" => $token,
                "created_at" => Carbon::now()
            ]);
            try {
                Mail::to($user->email)->send(new ResetPassword($user, $token));
                return response()->json(["success" => "Message sent successfully"]);
            } catch (Exception $e) {
                return response()->json(["error" => "An Error Has Occurred " . $e->getMessage()], 500);
            }
        } else {
            return response()->json(["error" => "Email Not Found"], 400);
        }
    }

    public function resetPassword(Request $request, $token)
    {
        $query = DB::table('password_reset_tokens')->where("token", $token);
        if ($query->count() == 1) {
            $passwordResets = $query->first();
            $user = User::where("email", $passwordResets->email)->first();
            try {
                User::where("id", $user->id)->update(["password" => Hash::make($request->password)]);
                $query = DB::table('password_reset_tokens')->where("token", $token)->delete();
                return response()->json(["success" => "Modify successfully"]);
            } catch (Exception $e) {
                return response()->json(["error" => "An Error Has Occurred" . $e->getMessage()], 500);
            }
        }
    }
}
