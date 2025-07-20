<?php

namespace App\Http\Controllers;
use App\Models\Obatalkes;
use App\Models\Signa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\TransaksiNonRacikan;
use App\Models\TransaksiObat;
use App\Models\CheckoutRacikan;

use App\Models\CheckoutNonRacikan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ObatController extends Controller
{

    public function index()
    {
        $data = Obatalkes::all();
        $stokMenipis = [];

        foreach ($data as $obat) {
            if ($obat->isStokMenipis()) {
                Log::info("Obat {$obat->obatalkes_nama} stoknya tinggal dikit!");
                $stokMenipis[] = $obat->obatalkes_nama;
            }
        }

        return view('obat.list_obat', compact('data', 'stokMenipis'));
    }


    public function signa()
    {
        $data = Signa::all();
        return view('obat.signa', compact('data'));
    }

    public function storeSigna(Request $request)
    {
        $request->validate([
            'signa_nama' => 'required|string|max:255',
            'signa_kode' => 'required|string|max:255',
            'additional_data' => 'nullable|string',
        ]);

        $data = Signa::create($request->only('signa_kode','signa_nama', 'additional_data'));
        // dd($data);

        return redirect()->route('signa.index')->with('success', 'Signa berhasil ditambahkan!');
    }

    public function updateSigna(Request $request, $id)
    {
        $request->validate([
            'signa_nama' => 'required|string|max:255',
            'additional_data' => 'nullable|string',
        ]);

        $signa = Signa::findOrFail($id);
        $signa->update($request->only('signa_nama', 'additional_data'));

        return redirect()->route('signa.index')->with('success', 'Signa berhasil diperbarui!');
    }

    public function deleteSigna($id)
    {
        Signa::findOrFail($id)->delete();
        return redirect()->route('signa.index')->with('success', 'Signa berhasil dihapus!');
    }
    
    public function tambahStok($id)
    {
        $obat = Obatalkes::findOrFail($id);
        $obat->stok += 1;
        $obat->save();

        return redirect()->back()->with('success', 'Stok berhasil ditambah!');
    }

    public function kurangStok($id)
    {
        $obat = Obatalkes::findOrFail($id);
        if ($obat->stok > 0) {
            $obat->stok -= 1;
            $obat->save();
        }

        return redirect()->back()->with('success', 'Stok berhasil dikurangi!');
    }
public function updateStok(Request $request, $id)
{
    $request->validate([
        'jumlah' => 'required|integer|min:1',
        'action' => 'required|in:tambah,kurang'
    ]);

    $obat = Obatalkes::findOrFail($id);

    if ($request->action === 'tambah') {
        $obat->stok += $request->jumlah;
    } elseif ($request->action === 'kurang') {
        $obat->stok = max(0, $obat->stok - $request->jumlah);
    }

    $obat->save();

    return redirect()->back()->with('success', 'Stok berhasil diupdate!');
}

public function formPilih()
{
    $obatList = Obatalkes::orderBy('obatalkes_nama')->get();
    $signaList = Signa::orderBy('signa_nama')->get();
    return view('obat.pilih', compact('obatList', 'signaList'));
}

public function prosesPilih(Request $request)
{
    $request->validate([
        'obat_id' => 'required|exists:obatalkes_m,obatalkes_id',
        'qty' => 'required|numeric|min:1',
        'signa_id' => 'required|exists:signa_m,signa_id'
    ]);

    $obat = Obatalkes::findOrFail($request->obat_id);
    $signa = Signa::findOrFail($request->signa_id);
    $qty   = $request->qty;
    $redirect = $request->line ?? 'default';

    return view('obat.detail', [
        'obat' => $obat,
        'signa' => $signa,
        'qty' => $qty,
        'redirect' => $redirect
    ]);

}

public function formNonRacikan()
{
    $obatList  = Obatalkes::where('stok', '>', 0)->get();
    $signaList = Signa::all();

    return view('obat.form-non-racikan', compact('obatList', 'signaList'));
}


public function storeNonRacikan(Request $request)
{
    $request->validate([
        'obat_id' => 'required|exists:obatalkes_m,obatalkes_id',
        'signa_id' => 'required|exists:signa_m,signa_id',
        'qty' => 'required|numeric|min:1',
        'tipe' => 'required|in:non-racikan'
    ]);

    // Simpan ke tabel transaksi atau tampilkan saja dulu
    return back()->with('success', 'Obat berhasil ditambahkan!');
}

public function store(Request $request)
{
    // ✅ Simpan non-racikan
    if ($request->nonracik_obat_id) {
        TransaksiObat::create([
            'obat_id' => $request->nonracik_obat_id,
            'signa_id' => $request->nonracik_signa_id,
            'qty' => $request->nonracik_qty,
            'tipe' => 'non-racikan',
            'racikan_nama' => null,
        ]);
    }

    // ✅ Simpan racikan (loop)
    if ($request->racik_obat_id && $request->racikan_nama) {
        foreach ($request->racik_obat_id as $i => $obatId) {
            TransaksiObat::create([
                'obat_id' => $obatId,
                'signa_id' => $request->racik_signa_id[$i],
                'qty' => $request->racik_qty[$i],
                'tipe' => 'racikan',
                'racikan_nama' => $request->racikan_nama,
            ]);
        }
    }

    return redirect()->back()->with('success', 'Obat berhasil disimpan!');
}

public function storeinsert_obat(Request $request)
{
    $request->validate([
        'obatalkes_kode' => 'required|string|max:100',
        'obatalkes_nama' => 'required|string|max:250',
        'stok' => 'required|numeric|min:0',
        'additional_data' => 'nullable|string'
    ]);

    Obatalkes::create([
        'obatalkes_kode' => $request->obatalkes_kode,
        'obatalkes_nama' => $request->obatalkes_nama,
        'stok' => $request->stok,
        'additional_data' => $request->additional_data,
        'created_by' => '',
        'created_date' => now(),
        'is_deleted' => 0,
        'is_active' => 1
    ]);

    return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan!');
}


public function listTransaksi()
{
    $transaksi = TransaksiObat::with(['obat', 'signa'])->get();

    // Hitung total transaksi (1 racikan = 1 item)
    $racikan = $transaksi->where('tipe', 'racikan')->groupBy('racikan_nama')->count();
    $nonRacikan = $transaksi->where('tipe', 'non-racikan')->count();
    $total = $racikan + $nonRacikan;

    $grouped = $transaksi->groupBy(function ($item) {
        return $item->tipe === 'racikan' ? $item->racikan_nama : "non-{$item->id}";
    });

    return view('obat.transaksi-list', compact('grouped', 'total'));
}

public function createRacikan()
{
    $obatList = \App\Models\Obatalkes::all();
    $signaList = \App\Models\Signa::all();
    return view('obat.form-racikan', compact('obatList', 'signaList'));
}

public function storeRacikan(Request $request)
{
    $request->validate([
        'racikan_nama' => 'required',
        'obat_id' => 'required|array',
        'qty' => 'required|array',
        'signa_id' => 'required|array',
    ]);

    foreach ($request->obat_id as $i => $obatId) {
        TransaksiObat::create([
            'obat_id' => $obatId,
            'qty' => $request->qty[$i],
            'signa_id' => $request->signa_id[$i],
            'tipe' => 'racikan',
            'racikan_nama' => $request->racikan_nama,
        ]);
    }

    return redirect()->route('obat.transaksi')->with('success', 'Racikan berhasil disimpan!');
}


public function listRacikan()
{
    $data = TransaksiObat::with(['obat', 'signa'])
        ->whereNotNull('racikan_nama')
        ->get()
        ->groupBy('racikan_nama');

    $racikan = [];

    foreach ($data as $nama => $items) {
        $status = 'tersedia';
        $keterangan = [];

        foreach ($items as $item) {
            $stok = $item->obat->stok ?? 0;
            if ($stok < $item->qty) {
                $status = 'tidak tersedia';
                $keterangan[] = "{$item->obat->obatalkes_nama} (sisa: $stok)";
            }
        }

        $racikan[$nama] = [
            'items' => $items,
            'status' => $status,
            'keterangan' => $keterangan
        ];
    }

    $signaList = Signa::all();

    return view('obat.list-racikan', compact('racikan', 'signaList'));
}


public function racikanList()
{
    $allRacikan = TransaksiObat::where('tipe', 'racikan')
        ->with(['obat', 'signa'])
        ->get()
        ->groupBy('racikan_nama');

    $racikan = [];

    foreach ($allRacikan as $nama => $items) {
        $status = 'tersedia';
        $keterangan = [];

        foreach ($items as $item) {
            if (!$item->obat || $item->obat->stok < $item->qty) {
                $status = 'tidak tersedia';
                $keterangan[] = $item->obat->obatalkes_nama . ' (sisa: ' . ($item->obat->stok ?? 0) . ')';
            }
        }

        $racikan[$nama] = [
            'items' => $items,
            'status' => $status,
            'keterangan' => $keterangan,
        ];
    }

    $signaList = Signa::all(); // atau dari model lo
    return view('obat.racikan.index', compact('racikan', 'signaList'));
}



public function ajaxSearch(Request $request)
{
    $search = $request->q;

    $data = Obatalkes::where('obatalkes_nama', 'like', '%' . $search . '%')
                ->limit(20)
                ->get();

    return response()->json(
        $data->map(function ($item) {
            return [
                'id' => $item->obatalkes_id,
                'text' => $item->obatalkes_nama,
            ];
        })
    );
}

public function deleteRacikan($nama)
{
    TransaksiObat::where('racikan_nama', $nama)->delete();
    return back()->with('success', 'Racikan berhasil dihapus');
}

public function updateRacikan(Request $request)
{
    $request->validate([
        'racikan_nama' => 'required|string',
        'racikan_nama_lama' => 'required|string',
        'obat_id' => 'required|array',
        'qty' => 'required|array',
        'signa_id' => 'required|array',
    ]);

    // Hapus racikan lama
    TransaksiObat::where('racikan_nama', $request->racikan_nama_lama)->delete();

    // Simpan racikan baru
    foreach ($request->obat_id as $i => $obatId) {
        TransaksiObat::create([
            'obat_id' => $obatId,
            'qty' => $request->qty[$i],
            'signa_id' => $request->signa_id[$i],
            'tipe' => 'racikan',
            'racikan_nama' => $request->racikan_nama
        ]);
    }

    return redirect()->back()->with('success', 'Racikan berhasil diperbarui!');
}

public function checkoutRacikan(Request $request)
{
    $nama = $request->racikan_nama;

    $items = TransaksiObat::with('obat')
        ->where('racikan_nama', $nama)
        ->get();

    foreach ($items as $item) {
        $obat = $item->obat;

        if ($obat->stok < $item->qty) {
            return back()->with('error', "❌ Stok tidak cukup untuk: {$obat->obatalkes_nama}");
        }

        // Kurangi stok
        $obat->stok -= $item->qty;
        $obat->save();
    }

    return back()->with('success', "✅ Racikan \"$nama\" berhasil di-checkout dan stok sudah dikurangi.");
}

public function ajaxRacikanDetails(Request $request)
{
    $names = $request->racikans ?? [];

    $response = [];

    foreach ($names as $nama) {
        $items = TransaksiObat::with('obat')
            ->where('racikan_nama', $nama)
            ->get()
            ->map(function ($item) {
                return [
                    'nama' => $item->obat->obatalkes_nama ?? 'ID: '.$item->obat_id,
                    'qty' => $item->qty,
                ];
            });

        $response[] = [
            'nama' => $nama,
            'items' => $items
        ];
    }

    return response()->json($response);
}

public function checkoutMultiple(Request $request)
{
    $namaList = explode(',', $request->racikan_nama_list);
    foreach ($namaList as $nama) {
        $items = TransaksiObat::where('racikan_nama', $nama)->get();
        foreach ($items as $item) {
            // Kurangi stok
            $obat = Obatalkes::find($item->obat_id);
            if ($obat) {
                $obat->stok = max(0, $obat->stok - $item->qty);
                $obat->save();
            }

            // Simpan ke riwayat
            CheckoutRacikan::create([
                'racikan_nama' => $item->racikan_nama,
                'obat_id' => $item->obat_id,
                'qty' => $item->qty,
                'signa_id' => $item->signa_id,
                'checkout_at' => now()
            ]);
        }
    }

    return redirect()->route('checkout.racikan.print', ['nama' => implode(',', $namaList)]);
}

public function printCheckout($nama)
{
    $namaList = explode(',', $nama);
    $data = CheckoutRacikan::with(['obat', 'signa'])
        ->whereIn('racikan_nama', $namaList)
        ->orderBy('checkout_at', 'desc')
        ->get()
        ->groupBy('racikan_nama');

    return view('obat.print-checkout', compact('data'));
}

public function checkoutHistory()
{
    $riwayat = CheckoutRacikan::with(['obat', 'signa'])
        ->orderBy('checkout_at', 'desc')
        ->get()
        ->groupBy('racikan_nama');

    return view('obat.checkout-history', compact('riwayat'));
}

public function listNonRacikan()
{
    $obatList = Obatalkes::whereNull('is_racikan')->get(); // ambil yang bukan racikan
    return view('obat.non-racikan', compact('obatList'));
}


public function checkoutNonRacikan(Request $request)
{
    $request->validate([
        'obat_id' => 'required|exists:obatalkes_m,obatalkes_id',
        'qty' => 'required|integer|min:1',
        'signa_id' => 'required|exists:signa_m,signa_id',
    ]);

    $obat = Obatalkes::findOrFail($request->obat_id);

    if ($obat->stok < $request->qty) {
        return back()->with('error', 'Stok tidak cukup!');
    }

    // Kurangi stok
    $obat->stok -= $request->qty;
    $obat->save();

    // Simpan ke checkout
    $checkout = CheckoutNonRacikan::create([
        'obat_id' => $obat->obatalkes_id,
        'qty' => $request->qty,
        'signa_id' => $request->signa_id,
        'tanggal' => now()
    ]);

    // Redirect ke halaman detail untuk diprint otomatis
    return redirect()->route('obat.printNonRacikan', $checkout->id)
                     ->with('print', true);
}


public function riwayatNonRacikan()
{
    $riwayat = CheckoutNonRacikan::with(['obat', 'signa'])->latest()->get();
    return view('obat.riwayat-nonracikan', compact('riwayat'));
}

public function riwayatRacikan()
{
    $riwayat = CheckoutRacikan::with(['obat', 'signa'])->latest()->get();
    return view('obat.riwayat-nonracikan', compact('riwayat'));
}



public function printNonRacikan($id)
{
    $checkout = CheckoutNonRacikan::with(['obat', 'signa'])->findOrFail($id);
    return view('obat.print-non-racikan', compact('checkout'));
}



}
