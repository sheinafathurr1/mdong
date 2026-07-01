<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - Pra-TA Kriya</title>

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
    </style>
</head>
<body>

    <div class="auth-card">
        <div class="mb-4">
            <h3 class="fw-black text-dark mb-1">Buat Password Baru</h3>
            <p class="text-muted fw-medium small">Masukkan password baru Anda untuk akun {{ $role === 'dosen' ? 'Dosen/Prodi' : 'Mahasiswa' }}.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger bg-danger-subtle border-0 rounded-3 fw-bold text-danger mb-4">
                @foreach ($errors->all() as $error)
                    <div><i class="bi bi-exclamation-octagon-fill me-2"></i>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="role" value="{{ $role }}">
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-floating mb-4">
                <input type="email" class="form-control px-4" id="email" name="email" placeholder="Email" value="{{ old('email', $email) }}" required autofocus>
                <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control px-4" id="password" name="password" placeholder="Password Baru" required minlength="8">
                <label for="password"><i class="bi bi-shield-lock me-2"></i>Password Baru</label>
            </div>

            <div class="form-floating mb-4">
                <input type="password" class="form-control px-4" id="password_confirmation" name="password_confirmation" placeholder="Ulangi Password" required minlength="8">
                <label for="password_confirmation"><i class="bi bi-shield-check me-2"></i>Ulangi Password</label>
            </div>

            <div class="d-grid gap-3">
                <button type="submit" class="btn btn-dark btn-submit shadow-sm">
                    Simpan Password Baru <i class="bi bi-check-circle-fill ms-2"></i>
                </button>
            </div>
        </form>
    </div>

</body>
</html>
