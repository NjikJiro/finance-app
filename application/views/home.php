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

        .btn-outline-primary {
            color: #5f60ff !important;
            border-color: #5f60ff !important;
        }

        .btn-outline-primary:hover {
            background: var(--gradient);
            color: #fff !important;
            border-color: transparent !important;
            box-shadow: 0 4px 15px rgba(95, 96, 255, 0.3);
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

        .pricing-card {
            transition: 0.3s;
        }

        .pricing-card:hover {
            transform: scale(1.05);
        }

        #pricing {
            background-color: #f1f5f9;
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

    <section id="pricing" class="py-5 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Pilih Paket <span style="color: var(--primary)">Main-Mainmu</span></h2>
                <p class="text-muted">Aplikasi ini gratis, tapi kalau mau gaya-gayaan dikit boleh lah pilih paket di bawah.</p>
            </div>
            <div class="row g-4 justify-content-center">
                <div class="col-md-4 col-lg-3">
                    <div class="card pricing-card p-4 border-0 shadow-sm rounded-4 h-100">
                        <div class="text-center mb-4">
                            <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">Gratisan</span>
                            <h3 class="fw-bold mb-0">Rp 0</h3>
                            <small class="text-muted">selamanya (mungkin)</small>
                        </div>
                        <ul class="list-unstyled mb-4 small">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Catat Jajan Batagor</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Pantau Listrik Kos</li>
                            <li class="mb-2 text-muted"><i class="bi bi-x-circle me-2"></i> Gak Bisa Pamer ke Gebetan</li>
                        </ul>
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-outline-primary rounded-pill mt-auto">Pilih Ini Aja</a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="card pricing-card p-4 border-0 shadow-lg rounded-4 h-100 position-relative border-primary" style="border: 2px solid var(--primary) !important;">
                        <span class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-primary">Paling Laku</span>
                        <div class="text-center mb-4">
                            <span class="badge bg-primary bg-opacity-10 text-primary mb-2">Mahasiswa Pro</span>
                            <h3 class="fw-bold mb-0">Rp 2k</h3>
                            <small class="text-muted">per bungkus gorengan</small>
                        </div>
                        <ul class="list-unstyled mb-4 small">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Semua Fitur Gratisan</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Mode Hemat Tanggal Tua</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Support via WhatsApp</li>
                        </ul>
                        <a href="<?= base_url('auth/register') ?>" class="btn btn-primary rounded-pill mt-auto">Sikat Bro!</a>
                    </div>
                </div>

                <div class="col-md-4 col-lg-3">
                    <div class="card pricing-card p-4 border-0 shadow-sm rounded-4 h-100">
                        <div class="text-center mb-4">
                            <span class="badge bg-dark bg-opacity-10 text-dark mb-2">Sultan Telkom</span>
                            <h3 class="fw-bold mb-0">Rp ??</h3>
                            <small class="text-muted">tergantung mood admin</small>
                        </div>
                        <ul class="list-unstyled mb-4 small">
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Fitur Rahasia Sultan</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Dashboard Warna Emas</li>
                            <li class="mb-2"><i class="bi bi-check-circle-fill text-primary me-2"></i> Admin Doakan Cepat Lulus</li>
                        </ul>
                        <a href="https://wa.me/yournumber" class="btn btn-dark rounded-pill mt-auto">Chat Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-white">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h2 class="fw-bold">Kata <span style="color: var(--primary)">Mereka</span> Tentang Kami</h2>
                <p class="text-muted">Hasil review jujur dari orang-orang yang dipaksa mencoba aplikasi ini.</p>
            </div>
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 bg-light p-4 rounded-4 h-100">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="fst-italic text-muted">"Dulu saldo ATM saya misterius banget, tiba-tiba habis. Sejak pakai FinanceApp, saya tahu persis kalau uang saya habis buat beli seblak sama kopi susu."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">A</div>
                            <div>
                                <h6 class="fw-bold mb-0">Agus Pejuang Skripsi</h6>
                                <small class="text-muted">Mahasiswa Telkom</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-light p-4 rounded-4 h-100">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="fst-italic text-muted">"Gila sih! Fitur monitoring listriknya ngebantu banget. Sekarang saya bisa tahu kalau PC gaming saya lebih boros daripada biaya makan saya sebulan."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="bg-success text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">R</div>
                            <div>
                                <h6 class="fw-bold mb-0">Rendi 'Sultan' IT</h6>
                                <small class="text-muted">Anak Kos Pro</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-0 bg-light p-4 rounded-4 h-100">
                        <div class="mb-3 text-warning">
                            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                        </div>
                        <p class="fst-italic text-muted">"Aplikasinya keren banget, dashboard-nya modern. Sayangnya aplikasi ini nggak bisa otomatis nambahin saldo ATM saya yang kosong. Mohon diupdate."</p>
                        <div class="d-flex align-items-center mt-3">
                            <div class="bg-danger text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px;">S</div>
                            <div>
                                <h6 class="fw-bold mb-0">Siska Hemat</h6>
                                <small class="text-muted">Eksekutif Muda (Katanya)</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-5">Pertanyaan yang <span style="color: var(--primary)">Sering Banget</span> Ditanya</h2>
                    <div class="accordion border-0 shadow-sm rounded-4 overflow-hidden" id="faqAccordion">
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
                                    Apakah data keuangan saya aman?
                                </button>
                            </h2>
                            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-start text-muted">
                                    Aman banget! Data cuma disimpan di database yang kamu buat sendiri. Bahkan admin (Renjiro) pun gak berani ngelihat sisa saldo kamu karena takut ikutan sedih.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
                                    Bisa nggak narik uang lewat aplikasi ini?
                                </button>
                            </h2>
                            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-start text-muted">
                                    Gak bisa lah, ini pencatat keuangan bukan mesin ATM keliling. Harap sadar diri ya.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item border-0">
                            <h2 class="accordion-header">
                                <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
                                    Kapan fitur investasi saham rilis?
                                </button>
                            </h2>
                            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
                                <div class="accordion-body text-start text-muted">
                                    Nanti kalau Renjiro sudah lulus kuliah dan punya waktu lebih buat coding. Doakan saja!
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 text-white" style="background: var(--gradient);">
        <div class="container py-5 text-center">
            <h2 class="fw-bold mb-3">Tunggu Apa Lagi?</h2>
            <p class="mb-5 opacity-75">Gabung dengan puluhan (mungkin) user lainnya dan mulai hidup hemat hari ini!</p>
            <a href="<?= base_url('auth/register') ?>" class="btn btn-light btn-lg rounded-pill px-5 fw-bold text-primary shadow-lg">Daftar Sekarang - Gratis!</a>
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