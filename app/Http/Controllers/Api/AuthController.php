<?php


namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\HttpResponses;
use App\Models\User;



class AuthController extends Controller
{
    use HttpResponses;

    public function register(Request $request)
    {
        $this->validate($request, [
            'name' =>'required|max:255',
            'email' =>'required|email|max:255|unique:users',
            'password' =>'required|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return $this->success([
            'user' => $user,
            'token' => $user->createToken('API Token')->plainTextToken
        ]);
    }

    public function login(Request $request)
    {
        // Validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Check User
        if (!auth()->attempt($credentials)) {
            return $this->error('', 'Your credential does not match!', 401);
        }
        $user = auth()->user();

        return $this->success([
            'user' => $user,
            'token' => $request->user()->createToken('API Token')->plainTextToken
            ]);
    }

    public function logout()
    {
        auth()->request->user()->currentAccessToken()->delete();

        return $this->success([
            'message' => 'User logged out Successfully!',
        ]);
    }
}
