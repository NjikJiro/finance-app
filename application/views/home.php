<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'><path fill='%235f60ff' d='M12.136.326A1.5 1.5 0 0 1 14 1.78V3h.5A1.5 1.5 0 0 1 16 4.5v9a1.5 1.5 0 0 1-1.5 1.5h-13A1.5 1.5 0 0 1 0 13.5v-9a1.5 1.5 0 0 1 1.5-1.5H2V1.78a1.5 1.5 0 0 1 1.864-1.454L12.136.326zM14 13.5v-9a.5.5 0 0 0-.5-.5h-13a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h13a.5.5 0 0 0 .5-.5zM2 3h10V1.78a.5.5 0 0 0-.621-.484L2.621 2.484A.5.5 0 0 0 2 2.97V3z'/></svg>">
    <title>FinanceApp - Smart Money Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #5f60ff;
            --primary-dark: #4b4ce6;
            --gradient: linear-gradient(135deg, #5f60ff 0%, #8b5cf6 100%);
        }

        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary) !important;
        }

        .hero-section {
            padding: 100px 0;
            background: radial-gradient(circle at 10% 20%, rgba(95, 96, 255, 0.05) 0%, rgba(255, 255, 255, 0) 100%);
        }

        .btn-primary {
            background: var(--gradient);
            border: none;
            padding: 12px 30px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-primary:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(95, 96, 255, 0.3);
        }

        .feature-card {
            border: none;
            border-radius: 20px;
            transition: 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-transparent py-4">
        <div class="container">
            <a class="navbar-brand fs-3" href="#">FinanceApp</a>
            <div class="ms-auto">
                <a href="<?= base_url('auth/login') ?>" class="btn btn-outline-primary rounded-pill px-4 me-2">Masuk</a>
                <a href="<?= base_url('auth/register') ?>" class="btn btn-primary">Daftar Sekarang</a>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">Kelola Uang & <span style="color: var(--primary)">Energi</span> dengan Cerdas</h1>
                    <p class="lead text-muted mb-5">Satu aplikasi untuk memantau saldo ATM, uang tunai, hingga pemakaian token listrik harianmu. Semua dalam satu dashboard modern.</p>
                    <div class="d-flex gap-3">
                        <a href="<?= base_url('auth/login') ?>" class="btn btn-primary btn-lg">Mulai Sekarang</a>
                        <a href="#features" class="btn btn-light btn-lg rounded-pill px-4 text-muted border">Pelajari Fitur</a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="position-relative">
                        <div class="bg-primary rounded-4 shadow-lg p-3 rotate-3" style="transform: rotate(2deg);">
                            <img src="https://images.unsplash.com/photo-1551288049-bebda4e38f71?auto=format&fit=crop&q=80&w=600" class="img-fluid rounded-3 shadow" alt="Dashboard Preview">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="features" class="py-5">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kenapa Memilih FinanceApp?</h2>
                <p class="text-muted">Fitur lengkap yang dirancang khusus untuk kebutuhan finansial harianmu.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card feature-card p-4 bg-white">
                        <div class="icon-box bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-wallet2 fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Multi-Account Tracking</h5>
                        <p class="text-muted small">Pisahkan catatan antara saldo Bank (ATM) dan Uang Tunai secara presisi.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 bg-white">
                        <div class="icon-box bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-lightning-charge fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Electricity Monitor</h5>
                        <p class="text-muted small">Input sisa kWh dan pantau rata-rata pemakaian listrik harianmu secara otomatis.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card feature-card p-4 bg-white">
                        <div class="icon-box bg-success bg-opacity-10 text-success">
                            <i class="bi bi-graph-up-arrow fs-3"></i>
                        </div>
                        <h5 class="fw-bold">Visual Analysis</h5>
                        <p class="text-muted small">Lihat tren pengeluaran 6 bulan terakhir dengan grafik interaktif yang mudah dibaca.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer class="py-5 bg-white border-top">
        <div class="container text-center">
            <p class="mb-0 text-muted">&copy; 2026 FinanceApp. Dibuat dengan <i class="bi bi-heart-fill text-danger"></i> oleh Renjiro.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>