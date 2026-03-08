<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portal Mahasiswa') - Pra-TA Kriya</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-dark: #0f172a;
            --surface-color: #f8fafc;
            --border-color: #e2e8f0;
            --text-muted: #64748b;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--surface-color);
            color: var(--primary-dark);
            overflow-x: hidden;
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }

        /* Sidebar Modern */
        #sidebar {
            min-width: 260px;
            max-width: 260px;
            min-height: 100vh;
            background-color: #ffffff;
            border-right: 1px dashed var(--border-color);
            transition: all 0.3s ease;
            position: fixed;
            z-index: 1040;
        }

        .sidebar-brand {
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 900;
            font-size: 1.25rem;
            color: var(--primary-dark);
            text-decoration: none;
            border-bottom: 1px solid var(--border-color);
        }

        .brand-icon {
            background: var(--primary-dark);
            color: white;
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            font-size: 1.2rem;
        }

        .nav-pills .nav-item { margin-bottom: 4px; }
        
        .nav-pills .nav-link {
            color: var(--text-muted);
            font-weight: 600;
            padding: 0.8rem 1.25rem;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 12px;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .nav-pills .nav-link i { font-size: 1.2rem; transition: transform 0.2s; }
        .nav-pills .nav-link:hover { background-color: #f1f5f9; color: var(--primary-dark); }
        .nav-pills .nav-link:hover i { transform: scale(1.1); }
        
        .nav-pills .nav-link.active {
            background-color: var(--primary-dark);
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(15, 23, 42, 0.15);
        }

        /* Glassmorphism Navbar */
        .navbar-glass {
            background: rgba(248, 250, 252, 0.85) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(226, 232, 240, 0.8);
            position: sticky;
            top: 0;
            z-index: 1030;
        }

        /* Main Content Wrapper */
        #content-wrapper {
            margin-left: 260px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s;
        }

        .main-content {
            padding: 2rem;
            flex-grow: 1;
        }

        /* User Dropdown Profile */
        .user-profile-btn {
            background: #ffffff;
            border: 1px solid var(--border-color);
            padding: 6px 16px 6px 6px;
            border-radius: 50px;
            display: flex;
            align-items: center;
            gap: 10px;
            font-weight: 700;
            color: var(--primary-dark);
            transition: all 0.2s;
        }
        .user-profile-btn:hover { background: #f1f5f9; border-color: #cbd5e1; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; background: var(--primary-dark); color: white; display: flex; align-items: center; justify-content: center; font-size: 0.85rem; font-weight: 800; }

        @media (max-width: 768px) {
            #sidebar { margin-left: -260px; }
            #sidebar.active { margin-left: 0; box-shadow: 10px 0 20px rgba(0,0,0,0.05); }
            #content-wrapper { margin-left: 0; }
            .main-content { padding: 1.5rem 1rem; }
        }
    </style>
</head>
<body>

    <div class="d-flex">
        <nav id="sidebar" class="d-flex flex-column shadow-sm">
            <a href="{{ route('mahasiswa.dashboard') }}" class="sidebar-brand">
                <div class="brand-icon"><i class="bi bi-palette-fill"></i></div>
                <span>Pra-TA Kriya</span>
            </a>
            
            <div class="p-3 overflow-y-auto">
                <div class="small text-muted fw-bold text-uppercase tracking-wide mb-2 px-3" style="font-size: 0.7rem; letter-spacing: 1px;">Menu Utama</div>
                <ul class="nav nav-pills flex-column mb-auto">
                    <li class="nav-item">
                        <a href="{{ route('mahasiswa.dashboard') }}" class="nav-link {{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                            <i class="bi bi-grid-fill"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <div class="small text-muted fw-bold text-uppercase tracking-wide mb-2 px-3" style="font-size: 0.7rem; letter-spacing: 1px;">Persiapan</div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('mahasiswa.project.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.project.*') ? 'active' : '' }}">
                            <i class="bi bi-collection-fill"></i> Portofolio Karya
                        </a>
                    </li>
                    <li class="nav-item mt-3">
                        <div class="small text-muted fw-bold text-uppercase tracking-wide mb-2 px-3" style="font-size: 0.7rem; letter-spacing: 1px;">Pendaftaran</div>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('mahasiswa.topik.index') }}" class="nav-link {{ request()->routeIs('mahasiswa.topik.*') ? 'active' : '' }}">
                            <i class="bi bi-search"></i> Eksplorasi Topik
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('mahasiswa.application.status') }}" class="nav-link {{ request()->routeIs('mahasiswa.application.*') ? 'active' : '' }}">
                            <i class="bi bi-file-earmark-check-fill"></i> Status Pengajuan
                        </a>
                    </li>
                </ul>
            </div>
            
            <div class="mt-auto p-3 border-top">
                <div class="bg-light rounded-4 p-3 text-center border border-dashed">
                    <i class="bi bi-headset fs-4 text-muted mb-2 d-block"></i>
                    <h6 class="fw-bold mb-1" style="font-size: 0.85rem;">Butuh Bantuan?</h6>
                    <p class="text-muted small mb-0" style="font-size: 0.75rem;">Hubungi Admin Prodi Kriya.</p>
                </div>
            </div>
        </nav>

        <div id="content-wrapper" class="w-100">
            
            <nav class="navbar navbar-expand-lg navbar-glass py-3 px-4">
                <div class="container-fluid p-0 d-flex justify-content-between align-items-center">
                    
                    <button class="btn btn-light d-md-none border shadow-sm rounded-3" type="button" id="sidebarToggle">
                        <i class="bi bi-list fs-5"></i>
                    </button>

                    <div class="d-none d-md-block">
                        <h5 class="fw-bold mb-0 text-dark">@yield('title')</h5>
                    </div>

                    <div class="dropdown ms-auto">
                        @php $user = Auth::guard('mahasiswa')->user(); @endphp
                        <button class="btn user-profile-btn dropdown-toggle border-0" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @if($user->visual_path)
                                <img src="{{ asset('storage/' . $user->visual_path) }}" alt="Avatar" class="user-avatar object-fit-cover">
                            @else
                                <div class="user-avatar">{{ substr($user->nama, 0, 1) }}</div>
                            @endif
                            <span class="d-none d-sm-inline">{{ explode(' ', $user->nama)[0] }}</span>
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-4 mt-2 p-2" style="min-width: 220px;">
                            <li class="px-3 py-2">
                                <span class="d-block fw-bold text-dark">{{ $user->nama }}</span>
                                <span class="d-block small text-muted">NIM: {{ $user->nim }}</span>
                            </li>
                            <li><hr class="dropdown-divider my-2"></li>
                            <li><a class="dropdown-item rounded-3 py-2 fw-medium text-secondary" href="{{ route('mahasiswa.profile.index') }}"><i class="bi bi-person-gear me-2"></i> Pengaturan Akun</a></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="m-0 p-0">
                                    @csrf
                                    <button type="submit" class="dropdown-item rounded-3 py-2 fw-bold text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>

                </div>
            </nav>

            <main class="main-content">
                @yield('content')
            </main>
            
            <footer class="mt-auto py-4 px-4 border-top bg-white">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-center small text-muted fw-medium">
                    <div>&copy; {{ date('Y') }} CoE CAATIS Telkom University. All rights reserved.</div>
                    <div class="mt-2 mt-md-0">Pra-Tugas Akhir S1 Kriya</div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
        });
    </script>
    
    @stack('scripts')
</body>
</html>