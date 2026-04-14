<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function landingPage()
    {
        return view('home');
    }

    public function kategori()
    {
        $products = Product::where('stok', '>', 0)->get();
        return view('kategori', compact('products'));
    }

    public function show(Product $product)
    {
        return view('pelanggan.product_detail', compact('product'));
    }

    public function index()
    {
        $products = Product::latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->only('nama_produk', 'stok', 'harga', 'deskripsi');

        if($request->hasFile('gambar')){
            $data['gambar'] = $request->file('gambar')->store('motor', 'public');
        }

        Product::create($data);
        return redirect()->route('products.index')->with('success', 'Motor berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|numeric|min:0',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->only('nama_produk', 'stok', 'harga', 'deskripsi');

        if($request->hasFile('gambar')){
            if($product->gambar) {
                Storage::disk('public')->delete($product->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('motor', 'public');
        }

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Data motor berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        if($product->gambar) {
            Storage::disk('public')->delete($product->gambar);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Motor berhasil dihapus!');
    }
}
