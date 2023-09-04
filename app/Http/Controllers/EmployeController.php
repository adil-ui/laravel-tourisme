<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;


class EmployeController extends Controller
{
    public function addEmploye(Request $request)
    {
        $user = User::create([
            "email" => $request->email,
            'password' => Hash::make('1234'),
            'role' => 'Admin',
        ]);

        $employe = new Employee;
        $employe->cin = strtoupper($request->cin);
        $employe->name = $request->name;
        $employe->email = $request->email;
        $employe->address = $request->address;
        $employe->phone = $request->phone;
        $employe->password = $user->password;
        $employe->role = 'Admin';
        $employe->user_id = $user->id;
        $employe->created_at = Carbon::now();
        $employe->updated_at = Carbon::now();
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $employe->picture = 'storage/' . $request->picture->store('images');
        }
        try {
            $employe->save();
            $employes = Employee::orderBy("created_at", "desc")->get();
            return response()->json(["message" => 'Employer ajouter avec succès', 'employes' =>$employes]);
        } catch (\Exception $e) {
            return response()->json(["error" => "An error occurred " . $e->getMessage()], 404);
        }
    }

    public function detailsEmploye($id)
    {
        $employe = Employee::where('id', $id)->get();
        return response()->json(['employe' => $employe]);
    }

    public function updateEmploye(Request $request, $id)
    {

        $employe = Employee::find($id);
        $picture = $employe->picture;
        if ($request->hasFile('picture') && $request->file('picture')->isValid()) {
            $picture = "storage/" . $request->picture->store('user/images');
        }

        Employee::where("id", $id)->update([
            "name" => $request->name,
            "email" => $request->email,
            "address" => $request->address,
            "phone" => $request->phone,
            "picture" => $picture,
        ]);
        return response()->json(['message' => 'Modifier avec succès']);
    }

    public function getEmploye()
    {
        $employes = Employee::orderBy("created_at", "desc")->get();
        return response()->json(['employes' => $employes]);
    }

    public function getEmployePerPage($page)
    {
        $employes = Employee::orderBy('created_at', 'desc')->offset(7 * ($page - 1))->limit(7)->get();
        $employesLenght = count(Employee::all());
        return response()->json(['employes' => $employes, 'employesLenght' => $employesLenght]);
    }

    public function search(Request $request, $page)
    {
        if ($request->search == "all") {
            $employes = Employee::orderBy('created_at', 'desc')->offset(7 * ($page - 1))->limit(7)->get();
            $employesLenght = count(Employee::all());
            return response()->json(['employes' => $employes, 'employesLenght' => $employesLenght]);
        }
        if ($request->search == "id") {
            $employes = Employee::where('id', $request->searchValue)->get();
            $employesLenght = count($employes);
            return response()->json(['employes' => $employes, 'employesLenght' => $employesLenght]);
        }
        if ($request->search == "cin") {
            $employes = Employee::where('cin', $request->searchValue)->get();
            $employesLenght = count($employes);
            return response()->json(['employes' => $employes, 'employesLenght' => $employesLenght]);
        }
        if ($request->search == "name") {
            $employes = Employee::where('name', $request->searchValue)->orderBy('created_at', 'desc')->get();
            $employesLenght = count($employes);
            return response()->json(['employes' => $employes, 'employesLenght' => $employesLenght]);
        }

    }

}
