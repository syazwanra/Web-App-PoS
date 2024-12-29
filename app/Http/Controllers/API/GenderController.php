<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\gender;

class GenderController extends Controller
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
        $gender = gender::all();

        return response([
            "message"=>"All Gender successfully shown",
            "data"=>$gender
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
        ], [
            'required' => 'name must be filled'
        ]);
        gender::create($validatedata);

        return response([
            "message"=>"Gender successfully added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Menampilkan detail
        $gender = gender::with('products')->find($id);

        // $gender = gender::find($id);

        if(!$gender){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }

        return response([
            "message"=>" Detail Job_type with $id successfully shown",
            "data"=>$gender
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //Menggunakan method PUT
        $validatedata = $request->validate([
            'name' => 'required',
        ], [
            'required' => 'name must be filled'
        ]);

        $gender = gender ::where('id', $id)
            ->update($validatedata);

        if(!$gender){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }
        return response([
            "message"=>" Gender successfully Update",
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Cari berdasarkan id
        $gender = gender::find($id);

        if(!$gender){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }
        $gender->delete();
        return response([
            "message"=>" Data successfully delete",
            
        ], 200);
    }
}
