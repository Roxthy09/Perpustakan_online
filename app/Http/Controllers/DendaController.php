<?php

namespace App\Http\Controllers;

use App\Models\Denda;
use App\Models\Pengembalian;
use App\Models\Buku;
use PDF;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DendaController extends Controller
{
    public function index(Request $request)
    {
        $query = Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.buku']);

        // Jika user biasa, hanya bisa lihat dendanya sendiri
        if (auth()->user()->role === 'user') {
            $query->whereHas('pengembalian.peminjaman', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        // Filter Search (nama peminjam / judul buku)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('pengembalian.peminjaman.user', function ($q2) use ($search) {
                    $q2->where('name', 'like', '%' . $search . '%');
                })
                    ->orWhereHas('pengembalian.peminjaman.buku', function ($q2) use ($search) {
                        $q2->where('judul', 'like', '%' . $search . '%');
                    });
            });
        }

        // Filter Status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter Tanggal (berdasarkan created_at)
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        $dendas = $query->orderBy('created_at', 'desc')->paginate(10);

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

    public function konfirmasi($id)
    {
        $denda = Denda::findOrFail($id);

        if ($denda->status === 'sudah_bayar') {
            return back()->with('info', 'Denda ini sudah dikonfirmasi sebelumnya.');
        }

        $denda->status = 'sudah_bayar';
        $denda->save();

        return back()->with('success', 'Denda berhasil dikonfirmasi sebagai sudah dibayar.');
    }

    public function exportPdf()
    {
        // filter data 7 hari terakhir
        $startDate = Carbon::now()->subDays(7);
        $endDate = Carbon::now();

        $dendas = Denda::with('pengembalian.user')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $pdf = PDF::loadView('denda.laporan_pdf', compact('dendas', 'startDate', 'endDate'))
            ->setPaper('a4', 'landscape');

        return $pdf->download('laporan_denda_mingguan.pdf');
    }
}
