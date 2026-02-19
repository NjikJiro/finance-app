<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Finance App</title>

    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css">

    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>

    <style>
        /* === LAYOUT FIX === */
        body {
            font-family: 'Poppins', sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
            width: 100%;
        }

        .sidebar {
            width: 260px;
            background: white;
            border-right: 1px solid #eee;
            transition: transform 0.3s ease;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
        }

        .sidebar .nav-link.active {
            background: var(--primary-gradient);
            color: white !important;
            box-shadow: 0 4px 12px rgba(95, 96, 255, 0.2);
        }

        .main-content {
            margin-left: 260px;
            transition: all 0.3s ease;
            width: calc(100% - 260px);
        }

        .topbar {
            height: 65px;
            background: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 999;
            padding: 0 1.5rem;
        }

        /* Mobile Fixes */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0 !important;
                width: 100%;
            }

            .chart-container-flex {
                flex-direction: column !important;
                align-items: center !important;
            }

            .legend-grid {
                display: grid !important;
                grid-template-columns: 1fr 1fr;
                gap: 10px;
                width: 100%;
                margin-top: 1rem;
            }
        }

        /* Styling Default Nav Link */
        .sidebar .nav-link {
            transition: all 0.3s ease;
            /* Agar transisi warna halus */
            border: 1px solid transparent;
        }

        /* Efek Hover untuk Menu yang TIDAK Aktif */
        .sidebar .nav-link:not(.active):hover {
            background-color: rgba(95, 96, 255, 0.1) !important;
            /* Biru sangat muda transparan */
            color: var(--primary-solid) !important;
            /* Teks berubah jadi biru primary */
            transform: translateX(5px);
            /* Sedikit geser ke kanan agar terasa interaktif */
        }

        /* Sedikit polesan untuk Menu yang Aktif agar lebih menonjol */
        .sidebar .nav-link.active {
            box-shadow: 0 4px 12px rgba(95, 96, 255, 0.3);
        }

        /* Efek Hover Khusus Logout */
        .sidebar .nav-link.text-danger:hover {
            background-color: rgba(239, 68, 68, 0.1) !important;
            /* Merah sangat muda */
            color: #b91c1c !important;
            transform: translateX(5px);
        }
    </style>
</head>

<body>
    <div class="d-flex min-vh-100">