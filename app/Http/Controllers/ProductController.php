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
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'warna' => 'required|string|max:255',
            'stok_varian' => 'required|integer|min:0',
            'gambar_varian' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only('nama_produk', 'harga', 'deskripsi');
        $data['stok'] = 0;

        $product = Product::create($data);
        
        $variantData = [
            'product_id' => $product->id,
            'warna' => $request->warna,
            'stok' => $request->stok_varian,
            'gambar' => $request->file('gambar_varian')->store('motor/variants', 'public')
        ];
        \App\Models\ProductVariant::create($variantData);

        return redirect()->route('products.index')->with('success', 'Motor dan varian pertamanya berhasil ditambahkan!');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
        ]);

        $data = $request->only('nama_produk', 'harga', 'deskripsi');

        $product->update($data);
        return redirect()->route('products.index')->with('success', 'Data motor berhasil diperbarui!');
    }

    public function storeVariant(Request $request, Product $product)
    {
        $request->validate([
            'warna' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = $request->only('warna', 'stok');
        $data['product_id'] = $product->id;

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('motor/variants', 'public');
        }

        \App\Models\ProductVariant::create($data);
        return back()->with('success', 'Varian warna berhasil ditambahkan!');
    }

    public function destroyVariant(\App\Models\ProductVariant $variant)
    {
        if ($variant->gambar) {
            Storage::disk('public')->delete($variant->gambar);
        }
        $variant->delete();
        return back()->with('success', 'Varian warna berhasil dihapus!');
    }

    public function updateVariant(Request $request, \App\Models\ProductVariant $variant)
    {
        $request->validate([
            'warna' => 'required|string|max:255',
            'stok' => 'required|integer|min:0',
        ]);
        
        $variant->update($request->only('warna', 'stok'));
        return back()->with('success', 'Data varian berhasil diperbarui!');
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
