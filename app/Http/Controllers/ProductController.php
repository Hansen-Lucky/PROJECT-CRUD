<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    public function index() 
    {
        $products = Product::paginate(3);

        return view('products.index',compact('products'));
    }



    public function create() 
    {
        return view('products.create');
    }



    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required',
            'harga' => 'required|numeric',
            'foto' => 'required|image|mimes:jpeg,png,jpg'
        ], [
            'nama.required' => 'Nama Harus Diisi',
            'harga.required' => 'Harga Harus Diisi',
            'harga.numeric' => 'Harga Harus Diisi Dengan Angka',
            'foto.required' => 'Foto Harus Diisi',
            'foto.image' => 'Foto Harus Diisi Dengan Gambar'     
        ]);

        // Cek apakah file foto ada
        if ($request->hasFile('foto')) {
        // Ambil file foto
        $foto = $request->file('foto');
        // Simpan file ke direktori 'storage/app/public' dan ambil nama file yang disimpan
        $fotoPath = $foto->store('images', 'public');
        }

        // Simpan data produk ke database, termasuk path foto yang disimpan
        Product::create([
            'nama' => $request->nama,
            'harga' => (str_replace(".", "", $request->harga)),
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath  // Path file gambar disimpan
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Add Product Success');
        }
    
        

        public function edit(Product $product)
        {
            return view('products.edit', compact('product'));
        }

        

        public function update(Request $request, Product $product)
        {
            // Validasi input
            $request->validate([
                'nama' => 'required',
                'harga' => 'required|numeric',
            ], [
                'nama.required' => 'Nama Harus Diisi',
                'harga.required' => 'Harga Harus Diisi',
                'harga.numeric' => 'Harga Harus Diisi Dengan Angka',
            ]);


            // Update data produk
            $product->nama = $request->nama;
            $product->harga = (str_replace(".", "", $request->harga));
            $product->deskripsi = $request->deskripsi;

            // Cek apakah ada file foto baru yang diupload
            if ($request->hasFile('foto')) {
            // Hapus file foto lama
            if ($product->foto && Storage::disk('public')->exists($product->foto)) 
            // Simpan file foto baru
            $foto = $request->file('foto');
            $fotoPath = $foto->store('images', 'public');
            $product->foto = $fotoPath;  // Simpan path baru
        }

            // Update data produk ke database
            $product->save();

            // Redirect dengan pesan sukses
            return redirect()->route('products.index')->with('success', 'Update Product Success');
        }



        public function destroy(Product $product)
        {
            if ($product->foto !== "noimage.png") {
                Storage::disk('public')->delete($product->foto);
            }

            $product->delete();

            return redirect()->route('products.index')->with('success', 'Delete Product Success');
        }
}

