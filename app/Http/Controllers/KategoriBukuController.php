<?php

namespace App\Http\Controllers;

use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class KategoriBukuController extends Controller
{
    public function index()
    {
        $kategoris = KategoriBuku::all();
        return view('kategori_buku.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori_buku.form', ['kategori' => new KategoriBuku()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode' => 'required|unique:kategori_bukus,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        KategoriBuku::create($request->all());
        return redirect()->route('kategori_buku.index')->with('success', 'Kategori berhasil ditambahkan');
    }

    public function edit(KategoriBuku $kategori_buku)
    {
        return view('kategori_buku.form', compact('kategori_buku'));
    }

    public function update(Request $request, KategoriBuku $kategori_buku)
    {
        $request->validate([
            'kode' => 'required|unique:kategori_bukus,kode,' . $kategori_buku->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
        ]);

        $kategori_buku->update($request->all());
        return redirect()->route('kategori_buku.index')->with('success', 'Kategori berhasil diperbarui');
    }

    public function destroy(KategoriBuku $kategori_buku)
    {
        $kategori_buku->delete();
        return redirect()->route('kategori_buku.index')->with('success', 'Kategori berhasil dihapus');
    }
}
