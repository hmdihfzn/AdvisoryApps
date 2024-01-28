<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Listing;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class ApiController extends Controller
{
    public function register(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);
       
            
        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password),
            'role_type' => 'u'
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $request-> name,
            'token' => $token
        ];

        return response($response, 201);
    }
    
    public function login(Request $request){

       $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        $token_expiration = config('sanctum.expiration');
        $token_expiration_time = Carbon::now('Asia/Kuala_Lumpur')->addMinutes($token_expiration);

        if($user){
            if(Hash::check($request->password, $user->password)){

                $token = $user->createToken("myapptoken")->plainTextToken;

                return response()->json([
                    "status" => 200,
                    "message" => "Logged in",
                    "result" => [
                        "user_id" => $user->id,
                        "access_token" => $token,
                        "token_type" => "Bearer",
                        "role_type" => $user->role_type,
                        "token_expires_in_minutes" => $token_expiration_time->format('Y-m-d H:i:s'),
                    ]
                ]);
            }

            return response()->json([
                "status" => false,
                "message" => "Password did not match"
            ]);
        }

        return response()->json([
            "status" => false,
            "message" => "Invalid login credentials"
        ]);
    }

    public function listing(){

        $listings = Listing::all();

        $list_data = [];

        $earthRadius = 6371;

        foreach($listings as $listing) {

            $latRad = deg2rad($listing->latitude);
            $longRad = deg2rad($listing->longitue);
            $a = sin($latRad / 2) * sin($latRad / 2) +
            cos($latRad) * cos(0) *
            sin($longRad/ 2) * sin($longRad / 2);

            $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
            $distance = $earthRadius * $c;

            $listing_data[] = [
                "name" => $listing->name,
                "latitude" => $listing->latitude,
                "distance" => $distance,
                "created_at" => $listing->created_at,
                "updated_at" => $listing->updated_at
            ];
        }

        foreach($listings as $listing){
            return response()->json([
                "status" => 200,
                "message" => "Success",
                "result" => [
                    "data" => $listing_data
                ]
            ]);
        }
    }
}
