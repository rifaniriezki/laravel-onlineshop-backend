<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function index(){

        $products = Product::where('name', 'like', '%' . request('name') . '%')
        ->orderBy('id', 'desc')
        ->paginate(5);
        return view('pages.product.index', compact('products'));
    }

    public function create(){
        $categories = Category::all();
        return view('pages.product.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/products', $filename);

        $product = new Product;
        $product->name = $request->name;
        $product->price = (int) $request->price;
        $product->stock = (int) $request->stock;
        $product->category_id = $request->category_id;
        $product->image = $filename;
        $product->save();

        return redirect()->route('product.index');
    }

    public function show($id){
        return view('pages.dashboard');
    }

    public function edit(Product $product){
        $categories = Category::all();
        return view('pages.product.edit', compact('product','categories'));
    }

    public function update(Request $request, $id)
    {
    // Cek apakah kategori dengan ID tersebut ada di database
    $product = Product::find($id);
    if (!$product) {
        return redirect()->route('product.index')->with('error', 'Product tidak ditemukan');
    }
    // Jika ada file gambar yang diupload
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/product', $filename);
        // Hapus gambar lama jika ada
        if ($product->image && Storage::exists('public/product/' . $product->image)) {
            Storage::delete('public/product/' . $product->image);
        }
        $product->image = $filename;
    }
    $product->name = $request->name;
    $product->price = (int) $request->price;
    $product->stock = (int) $request->stock;
    $product->category_id = $request->category_id;
    $product->save();

    return redirect()->route('product.index')->with('success', 'Product berhasil diupdate');
    }

    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Product Delete Successfully!');
    }
}

