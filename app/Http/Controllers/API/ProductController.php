<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\outlets;
use App\Models\gender;
use App\Models\product_category;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ProductController extends Controller
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
        // Mendapatkan semua produk
        $products = Product::all();

        return response([
            "message" => "Show all products",
            "data" => $products
        ], 200);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data yang dikirim
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|string|max:255',
            'outlet_id' => 'required|uuid|exists:outlets,id',
            'status' => 'required|string|max:255',
            'product_category_id' => 'required|uuid|exists:product_category,id',
            'gender_id' => 'required|uuid|exists:gender,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'image' => 'file must be ficture',
            'mimes' => 'File form just jpg, jpeg or png',
            'required' => 'This field is required.',
            'string' => 'This field must be a string.',
            'max' => 'This field must not exceed the maximum length.',
            'uuid' => 'Invalid UUID format.',
            'exists' => 'Related resource does not exist.'
        ]);

        if ($request->has('image_url')){
            // Upload with transformation
            $uploadedFileUrl = cloudinary()->upload($request->file('image_url')->getRealPath(), [
                'folder' => 'webpos'
            ])->getSecurePath();
        }

        // Membuat produk baru
        Product::create([
            'name' => $request -> input('name'),
            'description' => $request -> input('description'),
            'price' => $request -> input('price'),
            'outlet_id' => $request -> input('outlet_id'),
            'status' => $request -> input('status'),
            'product_category_id' => $request -> input('product_category_id'),
            'gender_id' => $request -> input('gender_id'),
            'image_url' => $uploadedFileUrl
        ]);

        return response([
            "message" => "Product successfully added"
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Menampilkan produk berdasarkan ID dengan relasi
        $product = Product::with(['outlets', 'product_category', 'gender'])->find($id);
        // // Mencari produk berdasarkan ID
        // $product = Product::where('id', $id)->first();

        if (!$product) {
            return response([
                "message" => "Product with ID $id was not found"
            ], 404);
        }

        return response([
            "message" => "Product with ID $id successfully shown",
            "data" => $product
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Menggunakan Method PUT
        $validatedData = $request->validate([
            'name' => 'string|max:255',
            'description' => 'string',
            'price' => 'string|max:255',
            'outlet_id' => 'uuid|exists:outlets,id',
            'status' => 'string|max:255',
            'product_category_id' => 'uuid|exists:product_category,id',
            'gender_id' => 'uuid|exists:gender,id',
            'image_url' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'image' => 'file must be ficture',
            'mimes' => 'File form just jpg, jpeg or png',
            'required' => 'This field is required.',
            'string' => 'This field must be a string.',
            'max' => 'This field must not exceed the maximum length.',
            'uuid' => 'Invalid UUID format.',
            'exists' => 'Related resource does not exist.'
        ]);

        if ($request->has('image_url')){
            // Upload with transformation
            $uploadedFileUrl = cloudinary()->upload($request->file('image_url')->getRealPath(), [
                'folder' => 'webpos'
            ])->getSecurePath();
        }

        // Mencari produk berdasarkan ID
        $product = Product::where('id', $id)
            ->update([
                'name' => $request -> input('name'),
                'description' => $request -> input('description'),
                'price' => $request -> input('price'),
                'outlet_id' => $request -> input('outlet_id'),
                'status' => $request -> input('status'),
                'product_category_id' => $request -> input('product_category_id'),
                'gender_id' => $request -> input('gender_id'),
                'image_url' => $uploadedFileUrl,
            ]);

        if (!$product) {
            return response([
                "message" => "Product with ID $id was not found"
            ], 404);
        }
        return response([
            "message" => "Product successfully updated"
        ], 201);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Mencari produk berdasarkan ID
        $product = Product::find($id);

        if (!$product) {
            return response([
                "message" => "Product with ID $id was not found"
            ], 404);
        }

        // Menghapus produk
        $product->delete();

        return response([
            "message" => "Product successfully deleted"
        ], 200);
    }
}
