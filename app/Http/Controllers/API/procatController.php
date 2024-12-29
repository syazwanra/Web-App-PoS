<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\product_category;

class procatController extends Controller
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
        $procat = product_category::all();

        return response([
            "message"=>"All Categories successfully shown",
            "data"=>$procat
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
        product_category::create($validatedata);

        return response([
            "message"=>"Product Categories successfully added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //Menampilkan detail
        $procat = product_category::with('products')->find($id);

        // $procat = product_category::find($id);

        if(!$procat){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }

        return response([
            "message"=>" Detail Category with $id successfully shown",
            "data"=>$procat
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

        $procat = product_category ::where('id', $id)
            ->update($validatedata);

        if(!$procat){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }
        return response([
            "message"=>" Product Category successfully Update",
        ], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //Cari berdasarkan id
        $procat = product_category::find($id);

        if(!$procat){
            return response([
                "message"=>" Database with $id was not found"
            ], 404);
        }
        $procat->delete();
        return response([
            "message"=>" Data successfully delete",
            
        ], 200);
    }
}