<?php

namespace App\Http\Controllers;
use App\User;
use Illuminate\Auth\Events\Failed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login', 'register']]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login()
    {
        $credentials = request(['email', 'password']);
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        return $this->respondWithToken($token);
    }
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }
    
    public function payload()
    {
        return response()->json(auth()->payload());
    }
    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();
        return response()->json(['message' => 'Successfully logged out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
    /**
     * Get the token array structure.
     *
     * @param string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'data' => [
                'type' => 'login',
                'user' => auth()->user(),
            ],
            'attributes' => [
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
            ]
        ]);
    }

    public function register(Request $request){

        $validation = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        if($validation->fails()){
            return response()->json([
                'error' => [
                    'status' => '400',
                    'code' => $validation->errors(),
                    'detail' => 'Verifica que los campos se llamen correctamente y tengan valor valido'
                ]
            ], 400);
        }

        $data = $request->all();

        $user = new User();
        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->password = Hash::make($data['password']);
        $user->save();

        if(is_numeric($user->id)){
            return response()->json([
                'data' => [
                    'id' => $user->id,
                    'type' => 'user',
                    'attributes' => [
                        'user' => $user
                    ]
                ]
            ], 200);
        }

        return response()->json([
            'error' => [
                'status' => '400',
                'code' => 'No se pudo crear el usuario'
            ]
        ], 400);
    }
}
