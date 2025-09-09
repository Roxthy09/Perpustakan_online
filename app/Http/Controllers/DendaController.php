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
    public function index()
    {
        $dendas = Denda::with('pengembalian')->paginate(10);
        $pengembalians = Pengembalian::all();
        $buku = Buku::all();
        return view('denda.index', compact('dendas', 'buku', 'pengembalians'));
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
