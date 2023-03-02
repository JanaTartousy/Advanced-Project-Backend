<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator;


class UserController extends Controller
{

    public function getAllUsers(){
        $users = User::all();
        return response()->json([
            'message' => $users,
        ]);
    }

    public function getUserByID(Request $request, $id){

        $user =  User::find($id);

        return response()->json([
            'message' => $user,
        ]);
    }
    public function editUser(Request $request, $id){
        $user  = User::find($id);
        $inputs = $request->except('password','_method');
        $user->update($inputs);
        if ($request->has('password')) {
            $user->update(['password' => bcrypt($request->password)]);
        }
        return response()->json([
           'message' => 'User Updated Successfully',
           'updates' => $user,
        ]);
    }
    public function deleteUser(Request $request, $id){
        $user =  User::find($id);
        $user->delete();
        return response()->json([
           'message' => 'User Deleted Successfully'
        ]);
    }
    // public function login(Request $request){
    //     if (auth()->attempt(request()->only(['email', 'password']))) {
    //         return response()->json([
    //            'message' => 'Logged In Successfully'
    //         ]);
    //     }
    //     else {
    //         return response()->json([
    //           'message' => 'Invalid Credentials'
    //         ]); 
    //     }
    // }
    // public function logout(){
    //     auth()->logout();
    //     return response()->json([
    //        'message' => 'Logged Out Successfully'
    //     ]);
    // }


    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){
    	$validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        if (! $token = auth()->attempt($validator->validated())) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->createNewToken($token);
    }
    /**
     * Register a user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|between:2,100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:6',
        ]);
        if($validator->fails()){
            return response()->json($validator->errors()->toJson(), 400);
        }
        $user = User::create(array_merge(
                    $validator->validated(),
                    ['password' => bcrypt($request->password)]
                ));
        return response()->json([
            'message' => 'User successfully created',
            'user' => $user
        ], 201);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Get the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user()
        ]);
    }
}
