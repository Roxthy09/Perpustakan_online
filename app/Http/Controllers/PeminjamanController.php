<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\User;
use App\Models\Buku;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PeminjamanController extends Controller
{
    public function index()
    {
        $peminjamans = Peminjaman::with(['user', 'buku'])->paginate(10);
        return view('peminjaman.index', compact('peminjamans'));
    }

    public function create()
    {
        $users = User::all();
        $bukus = Buku::all();
        return view('peminjaman.form', compact('users', 'bukus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'buku_id'   => 'required|exists:bukus,id',
            'tgl_pinjam'=> 'required|date',
        ]);

        $peminjaman = new Peminjaman();
        $peminjaman->user_id = $request->user_id;
        $peminjaman->buku_id = $request->buku_id;
        $peminjaman->tgl_pinjam = $request->tgl_pinjam;

        // otomatis set jatuh tempo 7 hari setelah tanggal pinjam
        $peminjaman->tgl_jatuh_tempo = Carbon::parse($request->tgl_pinjam)->addDays(7);

        $peminjaman->status = 'pending';
        $peminjaman->persetujuan = false;
        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil ditambahkan.');
    }

    public function edit(Peminjaman $peminjaman)
    {
        $users = User::all();
        $bukus = Buku::all();
        return view('peminjaman.form', compact('peminjaman', 'users', 'bukus'));
    }

    public function update(Request $request, Peminjaman $peminjaman)
    {
        $request->validate([
            'user_id'   => 'required|exists:users,id',
            'buku_id'   => 'required|exists:bukus,id',
            'tgl_pinjam'=> 'required|date',
            'status'    => 'nullable|in:pending,Disetujui,Ditolak,dipinjam,dikembalikan',
        ]);

        $peminjaman->user_id = $request->user_id;
        $peminjaman->buku_id = $request->buku_id;
        $peminjaman->tgl_pinjam = $request->tgl_pinjam;

        // tetap hitung ulang jatuh tempo 7 hari setelah tanggal pinjam
        $peminjaman->tgl_jatuh_tempo = Carbon::parse($request->tgl_pinjam)->addDays(7);

        if ($request->filled('status')) {
            $peminjaman->status = $request->status;
        }

        $peminjaman->save();

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil diperbarui.');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $peminjaman->delete();
        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dihapus.');
    }

    // Tandai buku sudah diambil → dipinjam
    public function ambil($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'disetujui') {
            return redirect()->route('user.peminjaman.index')->with('error', 'Buku belum disetujui petugas.');
        }

        $buku = Buku::findOrFail($peminjaman->buku_id);

        if ($buku->stok < 1) {
            return redirect()->route('user.peminjaman.index')->with('error', 'Stok buku habis, tidak bisa dipinjam.');
        }

        // Kurangi stok buku
        $buku->decrement('stok', 1);

        $peminjaman->update([
            'status' => 'dipinjam',
        ]);

        return redirect()->route('user.peminjaman.index')->with('success', 'Status peminjaman diubah menjadi dipinjam dan stok berkurang.');
    }

    // Konfirmasi peminjaman (petugas)
    public function konfirmasi(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::findOrFail($id);

        if ($request->status == 'disetujui') {
            $peminjaman->update([
                'status' => 'disetujui',
                'persetujuan' => true,
                'catatan' => $request->catatan,
            ]);
        } else {
            $peminjaman->update([
                'status' => 'ditolak',
                'persetujuan' => false,
                'catatan' => $request->catatan,
            ]);
        }

        return redirect()->route('peminjaman.index')->with('success', 'Peminjaman berhasil dikonfirmasi.');
    }

    // Kembalikan buku
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);

        if ($peminjaman->status != 'dipinjam') {
            return redirect()->route('user.peminjaman.index')->with('error', 'Buku belum dipinjam.');
        }

        // Tambahkan stok buku kembali
        $buku = Buku::findOrFail($peminjaman->buku_id);
        $buku->increment('stok', 1);

        $peminjaman->update([
            'status' => 'dikembalikan',
        ]);

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'user_id' => $peminjaman->user_id,
            'tgl_kembali' => now(),
        ]);

        return redirect()->route('user.peminjaman.index')->with('success', 'Buku berhasil dikembalikan, stok bertambah, dan tercatat di pengembalian.');
    }
}
