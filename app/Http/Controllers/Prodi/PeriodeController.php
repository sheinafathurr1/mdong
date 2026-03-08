<?php

namespace App\Http\Controllers\Prodi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Periode;

class PeriodeController extends Controller
{
    public function index()
    {
        // Ambil semua periode, urutkan dari yang terbaru
        $periodes = Periode::orderBy('start_date', 'desc')->get();
        return view('dosen.prodi.periode.index', compact('periodes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kode' => 'required|string|max:255|unique:periode,nama_kode',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        \App\Models\Periode::query()->update(['is_active' => false]);

        \App\Models\Periode::create($request->all());

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
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kode' => 'required|string|max:255|unique:periode,nama_kode,'.$id.',periode_id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        $periode = Periode::findOrFail($id);
        $periode->update($request->only(['nama_kode', 'start_date', 'end_date']));

        return redirect()->route('dosen.prodi.periode.index')->with('success', 'Periode akademik berhasil diperbarui.');
    }

}