<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk - Pra-TA Kriya</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-x: hidden;
        }

        .login-wrapper {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            width: 100%;
            max-width: 1100px;
            min-height: 650px;
            display: flex;
            margin: 2rem;
        }

        /* Sisi Kiri: Branding Panel */
        .brand-panel {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            width: 45%;
            padding: 4rem;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
        }
        .brand-panel::after {
            content: ''; position: absolute; right: -20%; bottom: -10%; width: 400px; height: 400px;
            background: radial-gradient(circle, rgba(255,255,255,0.05) 0%, transparent 70%); border-radius: 50%;
        }
        .brand-logo {
            width: 48px; height: 48px; background: white; color: #0f172a; border-radius: 14px;
            display: flex; align-items: center; justify-content: center; font-size: 1.5rem; margin-bottom: 1rem;
        }

        /* Sisi Kanan: Form Panel */
        .form-panel {
            width: 55%;
            padding: 4rem 5rem;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        /* Role Buttons */
        .role-btn {
            background: #ffffff;
            border: 2px solid #e2e8f0;
            border-radius: 20px;
            padding: 1.5rem;
            text-align: left;
            transition: all 0.3s ease;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 1.5rem;
            width: 100%;
        }
        .role-btn:hover {
            border-color: #0f172a;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.1);
            transform: translateY(-3px);
        }
        .role-icon-box {
            width: 60px; height: 60px;
            border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.8rem;
            flex-shrink: 0;
            transition: all 0.3s;
        }
        .role-btn.mahasiswa .role-icon-box { background: #f1f5f9; color: #0f172a; }
        .role-btn.dosen .role-icon-box { background: #0f172a; color: #ffffff; }
        
        .role-btn:hover.mahasiswa .role-icon-box { background: #0f172a; color: #ffffff; }
        .role-btn:hover.dosen .role-icon-box { background: #334155; }

        .chevron-icon { margin-left: auto; color: #cbd5e1; font-size: 1.5rem; transition: transform 0.3s; }
        .role-btn:hover .chevron-icon { transform: translateX(5px); color: #0f172a; }

        /* Form Controls */
        .form-floating > .form-control {
            border: 2px solid #f1f5f9; border-radius: 14px; background-color: #f8fafc; transition: all 0.3s; font-weight: 500;
        }
        .form-floating > .form-control:focus {
            border-color: #0f172a; background-color: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }
        .form-floating > label { color: #94a3b8; font-weight: 600; padding-left: 1.25rem; }
        .form-floating > .form-control:focus ~ label, .form-floating > .form-control:not(:placeholder-shown) ~ label {
            transform: scale(0.85) translateY(-0.75rem) translateX(0.15rem); color: #0f172a;
        }

        .btn-login { padding: 1rem; border-radius: 14px; font-weight: 700; letter-spacing: 0.5px; transition: all 0.3s; }
        .btn-login:hover { transform: translateY(-2px); box-shadow: 0 10px 20px -5px rgba(15, 23, 42, 0.3); }
        
        .btn-back { font-weight: 700; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; transition: color 0.2s; margin-bottom: 2rem; cursor: pointer; border: none; background: none; padding: 0;}
        .btn-back:hover { color: #0f172a; }

        /* Hide forms initially */
        #form-mahasiswa, #form-dosen { display: none; animation: fadeIn 0.4s ease forwards; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }

        /* Mobile Responsiveness */
        @media (max-width: 991px) {
            .login-wrapper { flex-direction: column; min-height: auto; }
            .brand-panel { width: 100%; padding: 3rem 2rem; border-radius: 24px 24px 0 0; }
            .form-panel { width: 100%; padding: 3rem 2rem; }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        
        <div class="brand-panel">
            <div style="z-index: 2;">
                <div class="brand-logo shadow-sm"><i class="bi bi-palette-fill"></i></div>
                <h3 class="fw-black mb-1">Pra-TA Kriya</h3>
                <p class="text-white-50 fw-medium small tracking-wide text-uppercase">Telkom University</p>
            </div>
            
            <div style="z-index: 2;" class="mt-5 mt-md-0">
                <h1 class="fw-black mb-3" style="font-size: 2.5rem; line-height: 1.2;">Mulai Riset<br>Karya Terbaikmu.</h1>
                <p class="text-white-50 fw-medium" style="font-size: 1.1rem; max-width: 350px;">
                    Portal terpadu pengajuan, review portofolio, dan plotting Dosen Pembimbing Tugas Akhir.
                </p>
            </div>
        </div>

        <div class="form-panel">

            @if ($errors->any())
                <div class="alert alert-danger bg-danger-subtle border-0 rounded-3 fw-bold mb-4 text-danger">
                    <i class="bi bi-exclamation-octagon-fill me-2"></i> Username atau password tidak valid.
                </div>
            @endif

            <div id="role-selection">
                <div class="mb-5">
                    <h2 class="fw-black text-dark mb-1">Selamat Datang 👋</h2>
                    <p class="text-muted fw-medium">Silakan pilih jalur masuk Anda ke dalam sistem.</p>
                </div>

                <div class="d-grid gap-4">
                    <button class="role-btn mahasiswa" onclick="showForm('mahasiswa')">
                        <div class="role-icon-box"><i class="bi bi-mortarboard-fill"></i></div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">Mahasiswa</h4>
                            <p class="text-muted mb-0 small fw-medium">Masuk untuk portofolio & pilih topik</p>
                        </div>
                        <i class="bi bi-chevron-right chevron-icon"></i>
                    </button>

                    <button class="role-btn dosen" onclick="showForm('dosen')">
                        <div class="role-icon-box"><i class="bi bi-person-workspace"></i></div>
                        <div>
                            <h4 class="fw-bold mb-1 text-dark">Dosen & Prodi</h4>
                            <p class="text-muted mb-0 small fw-medium">Masuk untuk review & manajemen TA</p>
                        </div>
                        <i class="bi bi-chevron-right chevron-icon"></i>
                    </button>
                </div>
                
                <div class="text-center mt-5 pt-3 border-top">
                    <p class="text-muted small fw-medium mb-0">
                        <i class="bi bi-info-circle me-1"></i> Jika Anda mengalami kendala login, silakan hubungi Admin Prodi Kriya.
                    </p>
                </div>
            </div>


            <div id="form-mahasiswa">
                <button class="btn-back" onclick="showRoles()">
                    <i class="bi bi-arrow-left"></i> Kembali pilih peran
                </button>
                
                <div class="mb-4">
                    <h3 class="fw-black text-dark mb-1">Login Mahasiswa</h3>
                    <p class="text-muted fw-medium small">Gunakan akun yang telah didaftarkan.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role_type" value="mahasiswa">
                    
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control px-4" id="username_mhs" name="username" placeholder="Username" required autofocus>
                        <label for="username_mhs"><i class="bi bi-person-vcard me-2"></i>Username</label>
                    </div>

                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control px-4 password-field" id="password_mhs" name="password" placeholder="Password" required>
                        <label for="password_mhs"><i class="bi bi-shield-lock me-2"></i>Kata Sandi</label>
                        <button type="button" class="btn btn-link text-muted position-absolute end-0 top-50 translate-middle-y text-decoration-none toggle-password" style="margin-right: 10px;">
                            <i class="bi bi-eye-slash-fill fs-5"></i>
                        </button>
                    </div>

                    <div class="d-grid gap-3 mt-5">
                        <button type="submit" class="btn btn-dark btn-login shadow-sm">
                            Masuk ke Portal <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>


            <div id="form-dosen">
                <button class="btn-back" onclick="showRoles()">
                    <i class="bi bi-arrow-left"></i> Kembali pilih peran
                </button>
                
                <div class="mb-4">
                    <h3 class="fw-black text-dark mb-1">Login Dosen / Prodi</h3>
                    <p class="text-muted fw-medium small">Gunakan akun yang telah didaftarkan Prodi.</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <input type="hidden" name="role_type" value="dosen">
                    
                    <div class="form-floating mb-4">
                        <input type="text" class="form-control px-4" id="username_dosen" name="username" placeholder="Username" required>
                        <label for="username_dosen"><i class="bi bi-person-badge me-2"></i>Username</label>
                    </div>

                    <div class="form-floating mb-4 position-relative">
                        <input type="password" class="form-control px-4 password-field" id="password_dosen" name="password" placeholder="Password" required>
                        <label for="password_dosen"><i class="bi bi-shield-lock me-2"></i>Kata Sandi</label>
                        <button type="button" class="btn btn-link text-muted position-absolute end-0 top-50 translate-middle-y text-decoration-none toggle-password" style="margin-right: 10px;">
                            <i class="bi bi-eye-slash-fill fs-5"></i>
                        </button>
                    </div>

                    <div class="d-grid gap-3 mt-5">
                        <button type="submit" class="btn btn-dark btn-login shadow-sm" style="background-color: #1e293b;">
                            Masuk Ruang Dosen <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>

    <script>
        const roleSelection = document.getElementById('role-selection');
        const formMahasiswa = document.getElementById('form-mahasiswa');
        const formDosen = document.getElementById('form-dosen');

        function showForm(role) {
            roleSelection.style.display = 'none';
            if(role === 'mahasiswa') {
                formMahasiswa.style.display = 'block';
                formDosen.style.display = 'none';
            } else if(role === 'dosen') {
                formDosen.style.display = 'block';
                formMahasiswa.style.display = 'none';
            }
        }

        function showRoles() {
            formMahasiswa.style.display = 'none';
            formDosen.style.display = 'none';
            roleSelection.style.display = 'block';
            
            roleSelection.style.animation = 'none';
            roleSelection.offsetHeight; 
            roleSelection.style.animation = 'fadeIn 0.4s ease forwards';
        }

        document.querySelectorAll('.toggle-password').forEach(button => {
            button.addEventListener('click', function () {
                const passwordInput = this.parentElement.querySelector('.password-field');
                const icon = this.querySelector('i');
                
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.remove('bi-eye-slash-fill');
                    icon.classList.add('bi-eye-fill');
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove('bi-eye-fill');
                    icon.classList.add('bi-eye-slash-fill');
                }
            });
        });
    </script>
    
</body>
</html>