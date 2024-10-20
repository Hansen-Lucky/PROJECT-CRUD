<?php

namespace App\Http\Controllers;

use App\Models\Packaging;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class PackagingController extends Controller
{

    public function index() 
    {
        $packagings = Packaging::paginate(3);

        return view('packagings.index',compact('packagings'));
    }



    public function create() 
    {
        return view('packagings.create');
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
        Packaging::create([
            'nama' => $request->nama,
            'harga' => (str_replace(".", "", $request->harga)),
            'deskripsi' => $request->deskripsi,
            'foto' => $fotoPath  // Path file gambar disimpan
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route('packagings.index')->with('success', 'Add Packaging Success');
        }
    
        

        public function edit(Packaging $packaging)
        {
            return view('packagings.edit', compact('packaging'));
        }

        

        public function update(Request $request, Packaging $packaging)
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
            $packaging->nama = $request->nama;
            $packaging->harga = (str_replace(".", "", $request->harga));
            $packaging->deskripsi = $request->deskripsi;

            // Cek apakah ada file foto baru yang diupload
            if ($request->hasFile('foto')) {
            // Hapus file foto lama
            if ($packaging->foto && Storage::disk('public')->exists($packaging->foto)) 
            // Simpan file foto baru
            $foto = $request->file('foto');
            $fotoPath = $foto->store('images', 'public');
            $packaging->foto = $fotoPath;  // Simpan path baru
        }

            // Update data produk ke database
            $packaging->save();

            // Redirect dengan pesan sukses
            return redirect()->route('packagings.index')->with('success', 'Update Packaging Success');
        }



        public function destroy(Packaging $packaging)
        {
            if ($packaging->foto !== "noimage.png") {
                Storage::disk('public')->delete($packaging->foto);
            }

            $packaging->delete();

            return redirect()->route('packagings.index')->with('success', 'Delete Packaging Success');
        }
}

