<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(){

        $categories = Category::where('name', 'like', '%' . request('name') . '%')
        ->orderBy('id', 'desc')
        ->paginate(5);
        return view('pages.category.index', compact('categories'));
    }

    public function create(){
        return view('pages.category.create');
    }

    public function store(Request $request)
    {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/category', $filename);

        $category = new Category;
        $category->name = $request->name;
        $category->description = $request->description;
        $category->image = $filename;
        $category->save();

        return redirect()->route('category.index');
    }

    public function show($id){
        return view('pages.dashboard');
    }

    public function edit(Category $category){
        return view('pages.category.edit', compact('category'));
    }

    public function update(Request $request, $id)
{
    // Cek apakah kategori dengan ID tersebut ada di database
    $category = Category::find($id);
    if (!$category) {
        return redirect()->route('category.index')->with('error', 'Kategori tidak ditemukan');
    }

    // Jika ada file gambar yang diupload
    if ($request->hasFile('image')) {
        $filename = time() . '.' . $request->image->extension();
        $request->image->storeAs('public/category', $filename);
        // Hapus gambar lama jika ada
        if ($category->image && Storage::exists('public/category/' . $category->image)) {
            Storage::delete('public/category/' . $category->image);
        }
        $category->image = $filename;
    }
    $category->name = $request->name;
    $category->description = $request->description;
    $category->save();

    return redirect()->route('category.index')->with('success', 'Kategori berhasil diupdate');
}

    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('category.index')->with('success', 'Category Delete Successfully!');
    }
}
