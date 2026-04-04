<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Sedang Maintenance</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #ffffff; color: #333; height: 100vh; display: flex; align-items: center; justify-content: center; overflow: hidden; }
        .maint-card { max-width: 500px; text-align: center; padding: 2rem; }
        .icon-box { width: 100px; height: 100px; background: rgba(95, 96, 255, 0.1); border-radius: 30px; display: flex; align-items: center; justify-content: center; margin: 0 auto 2rem; color: #5f60ff; position: relative; }
        .icon-box i { font-size: 3rem; }
        .gear-addon { position: absolute; bottom: 0; right: 0; animation: spin 4s linear infinite; color: #8b5cf6; font-size: 1.5rem; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .status-badge { background: #fee2e2; color: #ef4444; padding: 5px 15px; border-radius: 50px; font-size: 12px; font-weight: 700; margin-bottom: 1rem; display: inline-block; }
        .progress { height: 8px; border-radius: 50px; background-color: #f1f5f9; margin-bottom: 1rem; }
        .progress-bar { background: linear-gradient(90deg, #5f60ff 0%, #8b5cf6 100%); }
        
        /* Style Tambahan untuk Tombol Logout */
        .btn-logout {
            border: 2px solid #fee2e2;
            color: #ef4444;
            border-radius: 50px;
            padding: 8px 25px;
            font-weight: 600;
            font-size: 13px;
            transition: 0.3s;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            margin-top: 2rem;
        }
        .btn-logout:hover {
            background-color: #ef4444;
            border-color: #ef4444;
            color: white;
            transform: translateY(-2px);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="maint-card mx-auto">
            <span class="status-badge text-uppercase">Sistem Maintenance</span>
            <div class="icon-box">
                <i class="bi bi-shield-lock-fill"></i>
                <i class="bi bi-gear-fill gear-addon"></i>
            </div>
            <h2 class="fw-bold mb-3">FinanceApp Sedang Diperbarui</h2>
            <p class="text-muted mb-4 small">Kami sedang melakukan pemeliharaan rutin untuk meningkatkan keamanan dan performa aplikasi. Mohon tunggu sebentar ya!</p>
            
            <div class="progress">
                <div class="progress-bar progress-bar-striped progress-bar-animated" style="width: 75%"></div>
            </div>
            <small class="text-muted opacity-75 d-block mb-3">Perkiraan selesai: Segera</small>

            <a href="<?= base_url('auth/logout') ?>" class="btn-logout">
                <i class="bi bi-box-arrow-right me-2"></i> Keluar dari Akun
            </a>
            
            <div class="mt-5 border-top pt-4">
                <p class="small mb-0 text-muted">Butuh bantuan mendesak?</p>
                <a href="mailto:admin@financeapp.com" class="text-primary text-decoration-none small fw-bold">Hubungi Tim Support</a>
            </div>
        </div>
    </div>
</body>
</html>