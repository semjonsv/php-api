<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    /**
     * User register function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function register(Request $request): JsonResponse
    {
        $data = $this->validate($request, [
            'email' => 'required|unique:users|email',
            'name' => 'required|between:2,17',
            'password' => 'required|confirmed|min:6'
        ]);

        $data['password'] = Hash::make($data['password']);
        $data['api_token'] = Str::random(32);

        $user = User::create($data);

        return response()->json($user);
    }

    /**
     * User login function
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        $data = $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $user = User::where('email', $data['email'])->first();

        if ($user && Hash::check($data['password'], $user->password)) {
            $user->api_token = Str::random(32);
            $user->save();
        } else {
            return response()->json(['message' => 'Incorrect password or email'], 401);
        }

        return response()->json([
            'api_token' => $user->api_token
        ]);
    }
}
