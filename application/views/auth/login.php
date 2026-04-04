<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><path fill='%235f60ff' d='M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.5-1.5H2V1.78a1.5 1.5 0 0 1 1.864-1.454L12.136.326zM14 13.5v-9a.5.5 0 0 0-.5-.5h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5zM2 3h10V1.78a.5.5 0 0 0-.621-.484L2.621 2.484A.5.5 0 0 0 2 2.97V3z'/></svg>">

    <title>Login | Finance App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-color: #5f60ff;
            --secondary-color: #7b68ee;
            --primary-gradient: linear-gradient(135deg, #5f60ff 0%, #7b68ee 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8faff;
            /* Perbaikan: background-attachment fixed agar tidak patah saat scroll mobile */
            background-attachment: fixed;
            background-image: 
                radial-gradient(at 0% 0%, rgba(95, 96, 255, 0.15) 0px, transparent 50%),
                radial-gradient(at 100% 100%, rgba(123, 104, 238, 0.15) 0px, transparent 50%);
            min-height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
            padding: 20px;
            overflow-x: hidden;
            position: relative;
        }

        /* Dekorasi Lingkaran Latar Belakang - Menggunakan fixed agar tidak terpotong */
        .bg-circle {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            background: var(--primary-gradient);
            filter: blur(80px);
            opacity: 0.35;
            animation: float 10s infinite alternate;
            pointer-events: none;
        }

        @keyframes float {
            from { transform: translate(0, 0) rotate(0deg); }
            to { transform: translate(30px, 50px) rotate(10deg); }
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 30px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.08);
            padding: 2.5rem !important;
            margin: auto;
        }

        .brand-icon {
            width: 65px;
            height: 65px;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 18px;
            margin: 0 auto 1.2rem;
            color: white;
            font-size: 1.8rem;
            box-shadow: 0 10px 20px rgba(95, 96, 255, 0.25);
        }

        .form-label {
            color: #4a5568;
            font-weight: 600;
            font-size: 0.8rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
            display: block;
        }

        .input-group {
            background: #f1f5f9;
            border-radius: 14px;
            padding: 2px;
            transition: all 0.3s ease;
            border: 2px solid transparent;
        }

        .input-group:focus-within {
            background: white;
            border-color: var(--primary-color);
            box-shadow: 0 8px 20px rgba(95, 96, 255, 0.1);
        }

        .input-group-text {
            background: transparent;
            border: none;
            padding-left: 15px;
            color: #94a3b8;
        }

        .form-control {
            background: transparent !important;
            border: none !important;
            padding: 12px 15px;
            font-weight: 400;
            color: #1e293b;
            font-size: 0.95rem;
        }

        .form-control:focus {
            box-shadow: none;
        }

        .btn-toggle-password {
            background: transparent;
            border: none;
            padding-right: 15px;
            color: #94a3b8;
            transition: all 0.2s;
        }

        .btn-toggle-password:hover {
            color: var(--primary-color);
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 14px;
            padding: 14px;
            font-weight: 700;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            color: white;
            margin-top: 1.5rem;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(95, 96, 255, 0.35);
            color: white;
        }

        .btn-login:active {
            transform: scale(0.98);
        }

        .alert {
            border: none;
            border-radius: 14px;
            background: #fff1f2;
            color: #e11d48;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .login-footer {
            font-size: 0.8rem;
            color: #64748b;
            margin-top: 2rem;
        }

        /* Penyesuaian Mobile */
        @media (max-width: 576px) {
            .login-card {
                padding: 1.8rem !important;
                border-radius: 25px;
            }
            .brand-icon {
                width: 55px;
                height: 55px;
                font-size: 1.5rem;
            }
            h3 { font-size: 1.4rem; }
            body { padding: 15px; }
        }

        /* Chrome Autocomplete Fix */
        input:-webkit-autofill {
            -webkit-box-shadow: 0 0 0px 1000px #f1f5f9 inset !important;
            -webkit-text-fill-color: #1e293b !important;
            border-radius: 14px;
        }
    </style>
</head>

<body>
    <div class="bg-circle" style="width: 300px; height: 300px; top: -100px; left: -100px;"></div>
    <div class="bg-circle" style="width: 400px; height: 400px; bottom: -150px; right: -150px; background: #7b68ee;"></div>

    <div class="card login-card shadow-lg">
        <div class="text-center">
            <div class="brand-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <h3 class="fw-bold text-dark mb-1">Selamat Datang</h3>
            <p class="text-muted mb-4 small">Masuk untuk mengelola keuangan Anda</p>
        </div>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i>
                <div><?= $this->session->flashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('auth/process') ?>">
            <div class="mb-3">
                <label class="form-label">Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input autocomplete="off" type="text" name="username" class="form-control" placeholder="Masukkan username" required>
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label">Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" name="password" id="passwordInput" class="form-control" placeholder="Masukkan password" required autocomplete="off">
                    <button type="button" class="btn-toggle-password" id="togglePassword">
                        <i class="bi bi-eye" id="eyeIcon"></i>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center login-footer">
            <div class="mb-1">&copy; 2026 <strong>FinanceApp</strong></div>
            <small>Developed with <i class="bi bi-heart-fill text-danger" style="font-size: 10px;"></i> by NjikJiro</small>
        </div>
    </div>

    <script>
        const togglePassword = document.querySelector('#togglePassword');
        const passwordInput = document.querySelector('#passwordInput');
        const eyeIcon = document.querySelector('#eyeIcon');

        togglePassword.addEventListener('click', function() {
            // Toggle tipe input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle ikon
            eyeIcon.classList.toggle('bi-eye');
            eyeIcon.classList.toggle('bi-eye-slash');

            // Feedback klik
            this.style.transform = "scale(1.2)";
            setTimeout(() => {
                this.style.transform = "scale(1)";
            }, 100);
        });
    </script>
</body>

</html>