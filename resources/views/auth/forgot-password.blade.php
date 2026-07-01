<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - Pra-TA Kriya</title>

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
        }
        .auth-card {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 480px;
            padding: 3.5rem;
            margin: 2rem;
        }
        .form-floating > .form-control {
            border: 2px solid #f1f5f9; border-radius: 14px; background-color: #f8fafc; transition: all 0.3s; font-weight: 500;
        }
        .form-floating > .form-control:focus {
            border-color: #0f172a; background-color: #ffffff; box-shadow: 0 4px 12px rgba(15, 23, 42, 0.05);
        }
        .form-floating > label { color: #94a3b8; font-weight: 600; padding-left: 1.25rem; }
        .btn-submit { padding: 1rem; border-radius: 14px; font-weight: 700; letter-spacing: 0.5px; }
        .btn-back { font-weight: 700; color: #64748b; text-decoration: none; display: inline-flex; align-items: center; gap: 8px; margin-bottom: 2rem; }
        .btn-back:hover { color: #0f172a; }
        .role-toggle .btn { border-radius: 12px; font-weight: 600; }
    </style>
</head>
<body>

    <div class="auth-card">
        <a href="{{ route('login') }}" class="btn-back"><i class="bi bi-arrow-left"></i> Kembali ke Login</a>

        <div class="mb-4">
            <h3 class="fw-black text-dark mb-1">Lupa Password?</h3>
            <p class="text-muted fw-medium small">Masukkan email terdaftar Anda, kami akan kirimkan link untuk membuat password baru.</p>
        </div>

        @if (session('status'))
            <div class="alert alert-success bg-success-subtle border-0 rounded-3 fw-bold text-success mb-4">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('status') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger bg-danger-subtle border-0 rounded-3 fw-bold text-danger mb-4">
                @foreach ($errors->all() as $error)
                    <div><i class="bi bi-exclamation-octagon-fill me-2"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="mb-4">
                <label class="form-label fw-bold small text-uppercase text-muted mb-2">Saya login sebagai</label>
                <div class="btn-group w-100 role-toggle" role="group">
                    <input type="radio" class="btn-check" name="role" id="role_mahasiswa" value="mahasiswa" {{ $role === 'mahasiswa' ? 'checked' : '' }}>
                    <label class="btn btn-outline-dark" for="role_mahasiswa"><i class="bi bi-mortarboard-fill me-1"></i> Mahasiswa</label>

                    <input type="radio" class="btn-check" name="role" id="role_dosen" value="dosen" {{ $role === 'dosen' ? 'checked' : '' }}>
                    <label class="btn btn-outline-dark" for="role_dosen"><i class="bi bi-person-workspace me-1"></i> Dosen</label>
                </div>
            </div>

            <div class="form-floating mb-4">
                <input type="email" class="form-control px-4" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required autofocus>
                <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
            </div>

            <div class="d-grid gap-3">
                <button type="submit" class="btn btn-dark btn-submit shadow-sm">
                    Kirim Link Reset <i class="bi bi-send-fill ms-2"></i>
                </button>
            </div>
        </form>
    </div>

</body>
</html>
