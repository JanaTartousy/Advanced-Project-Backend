<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Admin;


class AdminController extends Controller
{
    // Add a new Admin in database.

    public function addAdmin(Request $request){

        // validator(request()->all(), [
        //     'email' => ['required' , 'email'],
        //     'password' => ['required']
        // ])->validate();

        $admin = new Admin;
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $password = hash::make($request->input('password'));
        $admin->first_name = $first_name;
        $admin->last_name = $last_name;
        $admin->email = $email;
        $admin->password = $password;
        $admin->save();

        return response()->json([
            'message' => 'Admin Created Successfully'
        ]);
    }

    // Display a list of the Admins in the database.

    public function getAllAdmins(Request $request){
        $admins = Admin::all();
        return response()->json([
            'message' => $admins,
        ]);
    }

    // Display a specific Admin.

    public function getAdminByID(Request $request, $id){

        $admin =  Admin::find($id);

        return response()->json([
            'message' => $admin,
        ]);
    }
    // Update the specified Admin in database.

    public function editAdmin(Request $request, $id){
        $admin  = Admin::find($id);
        $inputs = $request->except('password','_method');
        $admin->update($inputs);
        if ($request->has('password')) {
            $password = Hash::make($request->input('password'));
            $admin->update(['password' => $password]);
        }
        return response()->json([
           'message' => 'Admin Updated Successfully',
           'updates' => $admin,
        ]);
    }
    //  Remove the specified Admin from database.

    public function deleteAdmin(Request $request, $id){
        $admin =  Admin::find($id);
        $admin->delete();
        return response()->json([
           'message' => 'Admin Deleted Successfully'
        ]);
    }
    // Login Admin (authentication).

    public function login(Request $request){
        if (auth()->attempt(request()->only(['email', 'password']))) {
            return response()->json([
               'message' => 'Logged In Successfully'
            ]);
        }
        else {
            return response()->json([
              'message' => 'Invalid Credentials'
            ],401); 
        }
    }
    // Logout from Admin (authentication).

    public function logout(){
        auth()->logout();
        return response()->json([
           'message' => 'Logged Out Successfully'
        ]);
    }
}
