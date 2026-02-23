<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><path fill='%235f60ff' d='M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.5-1.5H2V1.78a1.5 1.5 0 0 1 1.864-1.454L12.136.326zM14 13.5v-9a.5.5 0 0 0-.5-.5h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5zM2 3h10V1.78a.5.5 0 0 0-.621-.484L2.621 2.484A.5.5 0 0 0 2 2.97V3z'/></svg>">

    <title>Login | Finance App</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

    <style>
        :root {
            --primary-gradient: linear-gradient(120deg, #5f60ff, #7b68ee);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--primary-gradient);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .login-card {
            width: 100%;
            max-width: 400px;
            border: none;
            border-radius: 25px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .brand-icon {
            font-size: 3rem;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 1rem;
        }

        .form-control {
            border-radius: 12px;
            padding: 12px 15px;
            border: 1px solid #e0e0e0;
            background: #f9f9f9;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(95, 96, 255, 0.2);
            border-color: #5f60ff;
            background: #fff;
        }

        .btn-login {
            background: var(--primary-gradient);
            border: none;
            border-radius: 12px;
            padding: 12px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            color: white;
        }

        .btn-login:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(95, 96, 255, 0.4);
            color: white;
        }

        .alert {
            border-radius: 12px;
            font-size: 0.9rem;
        }

        .login-footer {
            font-size: 0.85rem;
            color: #888;
            margin-top: 1.5rem;
        }
    </style>
</head>

<body>

    <div class="card login-card shadow-lg p-4 p-md-5 mx-3">
        <div class="text-center">
            <div class="brand-icon">
                <i class="bi bi-wallet2"></i>
            </div>
            <h3 class="fw-bold mb-1">Selamat Datang</h3>
            <p class="text-muted mb-4 small">Silakan login ke akun Finance Anda</p>
        </div>

        <?php if ($this->session->flashdata('error')) : ?>
            <div class="alert alert-danger d-flex align-items-center mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <div><?= $this->session->flashdata('error') ?></div>
            </div>
        <?php endif; ?>

        <form method="post" action="<?= base_url('auth/process') ?>">
            <div class="mb-3">
                <label class="form-label small fw-semibold text-muted">Username</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">
                        <i class="bi bi-person text-muted"></i>
                    </span>
                    <input autocomplete="off" type="text" name="username" class="form-control border-start-0" placeholder="Masukkan username" required style="border-radius: 0 12px 12px 0;">
                </div>
            </div>

            <div class="mb-4">
                <label class="form-label small fw-semibold text-muted">Password</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0" style="border-radius: 12px 0 0 12px;">
                        <i class="bi bi-lock text-muted"></i>
                    </span>
                    <input type="password" name="password" class="form-control border-start-0" placeholder="Masukkan password" required style="border-radius: 0 12px 12px 0;" autocomplete="off">
                </div>
            </div>

            <button type="submit" class="btn btn-login w-100 mb-3">
                Masuk Sekarang
            </button>
        </form>

        <div class="text-center login-footer">
            &copy; 2026 FinanceApp. <br>
            Managed by <strong>NjikJiro</strong>
        </div>
    </div>

</body>

</html>