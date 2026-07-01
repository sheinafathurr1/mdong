<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Mahasiswa\StoreProjectRequest;
use App\Http\Requests\Mahasiswa\UpdateProjectRequest;
use App\Models\Project;
use App\Models\Application; // Pastikan Model Application di-import

class ProjectController extends Controller
{
    // Fungsi bantuan untuk mengecek apakah portofolio terkunci
    private function isPortfolioLocked()
    {
        return Application::where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                          ->whereIn('status', ['APPLIED', 'APPROVED'])
                          ->exists();
    }

    public function index()
    {
        $projects = Project::where('mahasiswa_id', Auth::guard('mahasiswa')->id())->latest()->paginate(9);
        
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

    public function store(StoreProjectRequest $request)
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Akses ditolak. Portofolio terkunci.');
        }

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

    public function update(UpdateProjectRequest $request, $id)
    {
        if ($this->isPortfolioLocked()) {
            return redirect()->route('mahasiswa.project.index')->with('error', 'Akses ditolak. Portofolio terkunci.');
        }

        $project = Project::where('project_id', $id)
                          ->where('mahasiswa_id', Auth::guard('mahasiswa')->id())
                          ->firstOrFail();

        $project->update($request->validated());

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