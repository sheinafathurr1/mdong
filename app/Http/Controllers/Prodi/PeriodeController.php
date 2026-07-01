<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use App\Http\Requests\Prodi\StorePeriodeRequest;
use App\Http\Requests\Prodi\UpdatePeriodeRequest;
use App\Models\Periode;

class PeriodeController extends Controller
{
    public function index()
    {
        // Ambil semua periode, urutkan dari yang terbaru
        $periodes = Periode::orderBy('start_date', 'desc')->paginate(10);
        return view('dosen.prodi.periode.index', compact('periodes'));
    }

    public function store(StorePeriodeRequest $request)
    {
        $validated = $request->validated();

        \App\Models\Periode::query()->update(['is_active' => false]);

        \App\Models\Periode::create($validated + ['is_active' => true]);

        return redirect()->route('dosen.prodi.periode.index')
                         ->with('success', 'Periode akademik baru berhasil ditambahkan dan otomatis menjadi satu-satunya periode aktif.');
    }

    public function toggle($id)
    {
        $periode = \App\Models\Periode::findOrFail($id);
        
        // Jika sakelar ditekan untuk MENGAKTIFKAN periode ini
        if (!$periode->is_active) {
            // Matikan SEMUA periode lain di database terlebih dahulu
            \App\Models\Periode::where('periode_id', '!=', $id)->update(['is_active' => false]);
            
            // Baru aktifkan periode yang dipilih ini
            $periode->is_active = true;
            $statusName = 'diaktifkan secara eksklusif';
        } 
        // Jika sakelar ditekan untuk MEMATIKAN periode ini
        else {
            $periode->is_active = false;
            $statusName = 'dinonaktifkan';
        }
        
        $periode->save();

        return redirect()->route('dosen.prodi.periode.index')
                         ->with('success', "Periode {$periode->nama_kode} berhasil {$statusName}.");
    }

    public function destroy($id)
    {
        $periode = Periode::findOrFail($id);
        $periode->delete();

        return redirect()->route('dosen.prodi.periode.index')->with('success', 'Periode berhasil dihapus.');
    }

    // Method untuk update data (Edit)
    public function update(UpdatePeriodeRequest $request, $id)
    {
        $periode = Periode::findOrFail($id);
        $periode->update($request->validated());

        return redirect()->route('dosen.prodi.periode.index')->with('success', 'Periode akademik berhasil diperbarui.');
    }

}