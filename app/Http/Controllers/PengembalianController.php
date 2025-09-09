<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Buku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index()
    {
        $pengembalians = Pengembalian::with(['peminjaman.user', 'peminjaman.buku'])->paginate(10);
        return view('pengembalian.index', compact('pengembalians'));
    }

    public function create()
    {
        $peminjamans = Peminjaman::where('status', 'dipinjam')->get();
        return view('pengembalian.form', compact('peminjamans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tgl_kembali'   => 'required|date',
            'kondisi'       => 'required|in:baik,rusak,hilang',
        ]);

        $peminjaman = Peminjaman::findOrFail($request->peminjaman_id);
        $buku = Buku::findOrFail($peminjaman->buku_id);

        // Tambahkan stok buku kembali
        $buku->increment('stok', 1);

        // Update status peminjaman
        $peminjaman->update([
            'status' => 'dikembalikan',
        ]);

        // Catat pengembalian
        $pengembalian = Pengembalian::create([
            'peminjaman_id'       => $peminjaman->id,
            'tgl_kembali'         => $request->tgl_kembali,
            'kondisi'             => $request->kondisi,
            'user_id'             => Auth::id(),
        ]);

        return redirect()->route('pengembalian.show', $pengembalian->id)
                         ->with('success', 'Pengembalian dicatat, silakan konfirmasi denda jika ada.');
    }

    public function show(Pengembalian $pengembalian)
    {
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        return view('pengembalian.form', compact('pengembalian'));
    }

    public function update(Request $request, Pengembalian $pengembalian)
    {
        $request->validate([
            'kondisi' => 'required|in:baik,rusak,hilang',
        ]);

        $pengembalian->update([
            'kondisi' => $request->kondisi,
        ]);

        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $pengembalian->delete();
        return redirect()->route('pengembalian.index')->with('success', 'Pengembalian berhasil dihapus.');
    }

    public function konfirmasiDenda(Request $request, $id)
    {
        $pengembalian = Pengembalian::findOrFail($id);

        $request->validate([
            'kondisi'    => 'required|in:baik,telat,rusak,hilang',
            'hari_telat' => 'nullable|integer|min:0',
        ]);

        // Update kondisi dan status
        $pengembalian->kondisi = $request->kondisi;
        $pengembalian->hari_telat = $request->kondisi === 'telat' ? $request->hari_telat : null;
        $pengembalian->status = 'selesai';
        $pengembalian->save();

        // Hitung denda
        if ($request->kondisi === 'telat' && $request->hari_telat > 0) {
            $tarifPerHari = 5000;
            $pengembalian->denda()->create([
                'jumlah' => $request->hari_telat * $tarifPerHari,
                'status' => 'belum_bayar',
            ]);
        }

        if ($request->kondisi === 'rusak') {
            $pengembalian->denda()->create([
                'jumlah' => 50000,
                'status' => 'belum_bayar',
            ]);
        }

        if ($request->kondisi === 'hilang') {
            $pengembalian->denda()->create([
                'jumlah' => 100000,
                'status' => 'belum_bayar',
            ]);
        }

        return redirect()->back()->with('success', 'Pengembalian berhasil dikonfirmasi.');
    }
}
