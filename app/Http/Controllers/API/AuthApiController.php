<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthApiController extends BaseController
{
    public function register(ProfileStoreRequest $request) {

        $validatedData = $request->validated();

        if ($request->hasFile('profile_picture')) {
            $validatedData['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $validatedData['password'] = bcrypt($validatedData['password']);
    
        $user = User::create($validatedData);
    
        $success['user'] = $user;
    
        return $this->sendResponse($success, 'User registered successfully.');
    
    }

    public function login(Request $request)
    {
        $credentials = request(['email', 'password']);
  
        if (! $token = auth('api')->attempt($credentials)) {
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        }
  
        $success = $this->respondWithToken($token);
   
        return $this->sendResponse($success, 'User login successfully.');
    }

    public function logout()
    {
        auth('api')->logout();
        
        return $this->sendResponse([], 'Successfully logged out.');
    }

    protected function respondWithToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 60
        ];
    }
}
