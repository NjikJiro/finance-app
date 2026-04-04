<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Halaman Tidak Ditemukan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; background-color: #f4f6f9; color: #333; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .error-container { text-align: center; padding: 2rem; }
        .error-code { font-size: 10rem; font-weight: 700; color: #5f60ff; line-height: 1; margin-bottom: 1rem; opacity: 0.8; }
        .error-illustration { position: relative; display: inline-block; margin-bottom: 2rem; }
        .error-illustration i { font-size: 5rem; color: #5f60ff; animation: float 3s ease-in-out infinite; }
        @keyframes float { 0%, 100% { transform: translateY(0); } 50% { transform: translateY(-20px); } }
        .btn-home { background: linear-gradient(135deg, #5f60ff 0%, #8b5cf6 100%); border: none; padding: 12px 30px; border-radius: 50px; font-weight: 600; color: white; transition: 0.3s; box-shadow: 0 4px 15px rgba(95, 96, 255, 0.3); }
        .btn-home:hover { transform: translateY(-3px); box-shadow: 0 6px 20px rgba(95, 96, 255, 0.4); color: white; }
    </style>
</head>
<body>
    <div class="container">
        <div class="error-container">
            <div class="error-illustration">
                <i class="bi bi-search"></i>
            </div>
            <h1 class="error-code">404</h1>
            <h3 class="fw-bold mb-3">Wah, Halaman Hilang!</h3>
            <p class="text-muted mb-5">Halaman yang kamu cari tidak ditemukan atau mungkin telah dipindahkan.<br>Ayo kembali ke jalur keuanganmu.</p>
            <a href="<?= base_url('dashboard') ?>" class="btn btn-home text-decoration-none">
                <i class="bi bi-house-door me-2"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>