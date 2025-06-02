<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GoGoWallet</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                @if(file_exists(public_path('images/logo.png')))
                    <img src="{{ asset('images/logo.png') }}" alt="GoWallet" class="auth-logo">
                @endif
            </div>

            @if ($errors->any())
                <div class="alert alert-error">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('register') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label class="form-label" for="name">Nama Lengkap</label>
                    <input type="text" name="name" id="name" class="form-input" value="{{ old('name') }}" placeholder="Masukkan nama lengkap" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="phone_number">Nomor Telepon</label>
                    <input type="text" name="phone_number" id="phone_number" class="form-input" value="{{ old('phone_number') }}" placeholder="Contoh: 08123456789" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-input" value="{{ old('email') }}" placeholder="contoh@email.com" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="date_of_birth">Tanggal Lahir</label>
                    <input type="date" name="date_of_birth" id="date_of_birth" class="form-input" value="{{ old('date_of_birth') }}" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-input" placeholder="Minimal 8 karakter" required>
                </div>

                <div class="form-group">
                    <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-input" placeholder="Ulangi password" required>
                </div>

                <div class="file-input-wrapper">
                    <label class="file-input-label" id="fileInputLabel">
                        <i class="fas fa-user-circle"></i>
                        <span class="default-text">Masukkan Foto Profil</span>
                        <input 
                            type="file" 
                            name="profile_photo" 
                            class="file-input" 
                            accept="image/*"
                            onchange="this.nextElementSibling.textContent = this.files[0] ? this.files[0].name : 'Masukkan Foto Profil'"
                        >
                        <span class="file-name"></span>
                    </label>
                </div>

                <button type="submit" class="submit-button">
                    Daftar Sekarang
                </button>
            </form>

            <div class="auth-footer">
                Sudah punya akun? <a href="{{ route('login') }}" class="auth-link">Masuk</a>
            </div>
        </div>
    </div>
</body>
</html>