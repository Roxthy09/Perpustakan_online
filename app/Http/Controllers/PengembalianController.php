<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    public function index()
    {
        $user = User::all();
        $pengembalians = Pengembalian::with('peminjaman')->get();
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::all();
        return view('pengembalian.create', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjamans,id',
            'tanggal_pengembalian' => 'required|date',
        ]);

        Pengembalian::create($request->all());
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil ditambahkan.');
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        $peminjamans = Peminjaman::all();
        return view('pengembalian.edit', compact('pengembalian', 'peminjamans'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'id_peminjaman' => 'required|exists:peminjamans,id',
            'tanggal_pengembalian' => 'required|date',
        ]);

        $pengembalian->update($request->all());
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dihapus.');
    }
}
