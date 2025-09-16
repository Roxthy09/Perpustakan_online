<?php

namespace App\Http\Controllers;

use App\Models\Rak;
use Illuminate\Http\Request;

class RakController extends Controller
{
    public function index()
    {
        $raks = Rak::paginate(10);
        return view('rak.index', compact('raks'));
    }

    public function create()
    {
        return view('rak.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_rak' => 'required|unique:raks',
            'nama_rak' => 'required',
            'lokasi' => 'required',
        ]);

        Rak::create($request->all());
        return redirect()->route('rak.index')->with('success', 'Rak berhasil ditambahkan.');
    }

    public function show(Rak $rak)
    {
        return view('rak.show', compact('rak'));
    }

    public function edit(Rak $rak)
    {
         $rak = Rak::findOrFail($rak->id);
        return view('rak.form', compact('rak'));
    }

    public function update(Request $request, Rak $rak)
    {
        $request->validate([
            'kode_rak' => 'required|unique:raks,kode_rak,' . $rak->id,
            'nama_rak' => 'required',
            'lokasi' => 'required',
        ]);

        $rak->update($request->all());
        return redirect()->route('rak.index')->with('success', 'Rak berhasil diperbarui.');
    }

    public function destroy(Rak $rak)
    {
        $rak->delete();
        return redirect()->route('rak.index')->with('success', 'Rak berhasil dihapus.');
    }
}
