<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Application; // Pastikan Model Application di-import

class ProjectController extends Controller
{
    // Fungsi bantuan untuk mengecek apakah portofolio terkunci
    private function isPortfolioLocked()
    {
        return Application::where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                          ->whereIn('status', ['APPLIED', 'APPROVED-PBB1', 'APPROVED-FULL'])
                          ->exists();
    }

    public function index()
    {
        $projects = Project::where('mahasiswa_id', Auth::guard('mahasiswa')->id())->latest()->get();
        
        // Cek status kunci untuk dikirim ke View
        $isLocked = $this->isPortfolioLocked();

        return view('mahasiswa.project.index', compact('projects', 'isLocked'));
    }

    public function create()
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Portofolio terkunci! Anda sedang dalam proses pengajuan topik.');
        }

        return view('mahasiswa.project.create');
    }

    public function store(Request $request)
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Akses ditolak. Portofolio terkunci.');
        }

        $request->validate([
            'nama_proyek'   => 'required|array',
            'nama_proyek.*' => 'required|string|max:255',
            'tipe_proyek'   => 'required|array',
            'tipe_proyek.*' => 'required|in:Perancangan,Analisa',
            'teknik'        => 'nullable|array',
            'teknik.*'      => 'nullable|string|max:255',
            'metode'        => 'nullable|array',
            'metode.*'      => 'nullable|string|max:255',
            'material'      => 'nullable|array',
            'material.*'    => 'nullable|string|max:255',
            'narasi'        => 'required|array',
            'narasi.*'      => 'required|string',
        ]);

        $mahasiswaId = Auth::guard('mahasiswa')->id();

        foreach ($request->nama_proyek as $key => $nama) {
            Project::create([
                'mahasiswa_id' => $mahasiswaId,
                'nama_proyek'  => $nama,
                'tipe_proyek'  => $request->tipe_proyek[$key],
                'teknik'       => $request->teknik[$key] ?? null,
                'metode'       => $request->metode[$key] ?? null,
                'material'     => $request->material[$key] ?? null,
                'narasi'       => $request->narasi[$key],
            ]);
        }

        return redirect()->route('mahasiswa.project.index')->with('success', 'Portofolio berhasil disimpan!');
    }

    public function edit($id)
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Portofolio terkunci! Anda sedang dalam proses pengajuan topik.');
        }

        $project = Project::where('project_id', $id)
                          ->where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                          ->firstOrFail();

        return view('mahasiswa.project.edit', compact('project'));
    }

    public function update(Request $request, $id)
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Akses ditolak. Portofolio terkunci.');
        }

        $project = Project::where('project_id', $id)
                          ->where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                          ->firstOrFail();

        $request->validate([
            'nama_proyek' => 'required|string|max:255',
            'tipe_proyek' => 'required|in:Perancangan,Analisa',
            'teknik'      => 'nullable|string|max:255',
            'metode'      => 'nullable|string|max:255',
            'material'    => 'nullable|string|max:255',
            'narasi'      => 'required|string',
        ]);

        $project->update($request->all());

        return redirect()->route('mahasiswa.project.index')->with('success', 'Proyek berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Akses ditolak. Portofolio terkunci.');
        }

        $project = Project::where('project_id', $id)
                          ->where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                          ->firstOrFail();
                          
        $project->delete();

        return redirect()->route('mahasiswa.project.index')->with('success', 'Proyek berhasil dihapus dari portofolio.');
    }
}