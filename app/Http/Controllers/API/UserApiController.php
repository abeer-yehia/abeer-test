<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserApiController extends   BaseController
{
       public function profile(){
            $success = auth('api')->user();
            return $this->sendResponse($success, 'Profile Fetched successfully.');
    
       }

       public function update_profile(ProfileUpdateRequest $request)
       {
        $user = auth('api')->user();

        $user->name = $request->filled('name') ? $request->input('name') : $user->name;
        $user->email = $request->filled('email') ? $request->input('email') : $user->email;
        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
    
            $path = $request->file('profile_picture')->store('profile_pictures', 'public');
            $user->profile_picture = $path;
        }
    
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        $user->save();
        return response()->json([
            'success' => true,
            'message' => 'Profile updated successfully.',
            'data' => $user,
        ]);
       }
    
}
