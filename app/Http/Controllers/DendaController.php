<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index()
    {
        $dendas = Denda::with('pengembalian')->get();
        return view('denda.index', compact('dendas'));
    }

    public function create()
    {
        $pengembalians = Pengembalian::all();
        return view('denda.create', compact('pengembalians'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_pengembalian' => 'required|exists:pengembalians,id',
            'jumlah' => 'required|numeric|min:0',
            'status' => 'required|in:belum_dibayar,selesai',
        ]);

        Denda::create($request->all());
        return redirect()->route('denda.index')->with('success', 'Denda berhasil ditambahkan.');
    }

    public function show(Denda $denda)
    {
        return view('denda.show', compact('denda'));
    }

    public function edit(Denda $denda)
    {
        $pengembalians = Pengembalian::all();
        return view('denda.edit', compact('denda', 'pengembalians'));
    }

    public function update(Request $request, Denda $denda)
    {
        $request->validate([
            'id_pengembalian' => 'required|exists:pengembalians,id',
            'jumlah' => 'required|numeric|min:0',
            'status' => 'required|in:belum_dibayar,selesai',
        ]);

        $denda->update($request->all());
        return redirect()->route('denda.index')->with('success', 'Denda berhasil diperbarui.');
    }

    public function destroy(Denda $denda)
    {
        $denda->delete();
        return redirect()->route('denda.index')->with('success', 'Denda berhasil dihapus.');
    }
}
