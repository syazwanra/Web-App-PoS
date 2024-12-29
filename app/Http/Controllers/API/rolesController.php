<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Roles;

class rolesController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware(['auth:api', 'isAdmin']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $roles = roles::all();

        return response([
            "message"=>"Show all roles",
            "data"=>$roles
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedata = $request->validate([
            'name' => 'required',
        ], [
            'required' => 'Data need to added'
        ]);
        roles::create($validatedata);

        return response([
            "message"=>"Role successfully added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $roles = roles::with('listUsers')->find($id);

        // $roles = roles::find($id);

        if(!$roles){
            return response([
                "message"=>" Database $id was not found"
            ], 404);
        }

        return response([
            "message"=>" Detail role with $id successfully shown",
            "data"=>$roles
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $validatedata = $request->validate([
            'name' => 'required',
        ], [
            'required' => 'name must be filled.'
        ]);

        $roles = roles::where('id', $id)
            ->update($validatedata);

        if(!$roles){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }
        
        return response([
            "message"=>" Role successfully update",
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $roles = roles::find($id);

        if(!$roles){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }
        $roles->delete();
        return response([
            "message"=>" Role successfully delete",
            
        ], 200);
    }
}
