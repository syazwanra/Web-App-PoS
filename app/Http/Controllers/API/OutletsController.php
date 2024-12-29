<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\outlets;

class OutletsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:api', 'isOwnerOrAdmin'])->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //Menampilkan data
        $outlets = outlets::all();

        return response([
            "message"=>"All Outlets successfully shown",
            "data"=>$outlets
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //Validation
        $validatedata = $request->validate([
            'name' => 'required',
            'phone_number'=> 'required',
            'Branch_Manager'=> 'required',
            'address'=> 'required',
        ], [
            'required' => 'Data must be filled'
        ]);

        
        outlets::create([
            'name' => $request->input('name'),
            'phone_number'=> $request->input('phone_number'),
            'Branch_Manager'=> $request->input('Branch_Manager'),
            'address'=> $request->input('address'),
        ]);

        return response([
            "message"=>"Successfully add outlet"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Menampilkan Detail : find untuk mencari
        $outlets = outlets::find($id);

        if(!$outlets){
            return response([
                "message"=>" Database with $id not found"
            ], 404);
        }

        return response([
            "message"=>" Detail outlet successfully shown",
            "data"=>$outlets
        ], 200);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //Validation
        $validatedata = $request->validate([
            'name' => 'required',
            'phone_number'=> 'required',
            'Branch_Manager'=> 'required',
            'address'=> 'required',
        ], [
            'required' => 'Data must be filled'
        ]);

        outlets::where('id', $id)
            ->update([
                'name' => $request->input('name'),
                'phone_number'=> $request->input('phone_number'),
                'Branch_Manager'=> $request->input('Branch_Manager'),
                'address'=> $request->input('address'),
            ]);

        return response([
            "message"=>"Successfully update outlet"
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $outlets = outlets::find($id);

        if(!$outlets){
            return response([
                "message"=>" Database with $id not found"
            ], 404);
        }
        $outlets->delete();
        return response([
            "message"=>" Successfully delete outlet",
            
        ], 200);
    }
}
