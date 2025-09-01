<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class BukuController extends Controller
{
    public function index()
    {
        $bukus = Buku::all();
        $kategoris = KategoriBuku::all();
        return view('buku.index', compact('bukus', 'kategoris'));
    }

    public function create()
    {
        return view('buku.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_buku' => 'required|unique:bukus',
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategori_bukus,id',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|digits:4',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('bukus', 'public');
        }

        Buku::create($data);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku)
    {
        $buku = Buku::findOrFail($buku->id);
        return view('buku.form', compact('buku'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required',
            'kategori_id' => 'required|exists:kategori_bukus,id',
            'penulis' => 'required',
            'penerbit' => 'required',
            'tahun_terbit' => 'required|digits:4',
            'stok' => 'required|integer',
            'gambar' => 'nullable|image|max:2048'
        ]);

        $data = $request->all();
        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('bukus', 'public');
        }

        $buku->update($data);
        return redirect()->route('buku.index')->with('success', 'Buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku)
    {
        $buku->delete();
        return redirect()->route('buku.index')->with('success', 'Buku berhasil dihapus.');
    }
}
