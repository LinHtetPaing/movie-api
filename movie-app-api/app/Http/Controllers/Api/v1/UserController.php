<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * @group User Authentication.
 *
 */
class UserController extends Controller
{

    /**
     * User Registrations.
     *
     * To operate CRUD operation, you have to register your identity first.
     * * This endpoint lets you create a user.
     * <aside class="notice">
     *      You have to fill the following parameters:
     *        name,
     *        email,
     *        password,
     * </aside>
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $success['token'] = $user->createToken('MyToken')->accessToken;
        $success['name'] = $user->name;
        return response()->json(['status' => true, 'data' => $success, 'message' => 'User register successfully.'], 200);
    }

    /**
     * User Login.
     *
     *To operate create, update, delete operation for movies. 
     * You have to login first.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        if (!Auth::attempt($credentials)) {
            return response()->json(['status' => false, 'data' => ['error' => 'Unauthorised.']], 404);
        }
        $success['token'] = auth()->user()->createToken('MyToken')->accessToken;
        $success['name'] = $request->email;
        return response()->json(['status' => true, 'data' => $success, 'message' => 'User login successfully.'], 200);
    }
}
