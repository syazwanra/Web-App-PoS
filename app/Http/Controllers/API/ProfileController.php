<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile; 

class ProfileController extends Controller
{
    public function updatecreate(Request $request)
    {
        // Validasi
        $request->validate([
            'fullname' => 'required',
            'gender' => 'required',
            'outlet_id'=>'required|exists:outlets,id',
        ], [
            'required' => 'Data must be filled'
        ]);

        $currentUser = auth()->user();

        $profile = Profile::updateOrCreate(  // Menggunakan Profile (huruf kapital "P")
            ['user_id' => $currentUser->id],
            [
                'fullname' => $request->input('fullname'),
                'gender' => $request->input('gender'),
                'outlet_id'=>$request->input('outlet_id'),
                'user_id' => $currentUser->id
            ]
        );

        return response([
            "message" => "Success Update or Create Profile",
            "data" => $profile
        ], 201);
    }
}
