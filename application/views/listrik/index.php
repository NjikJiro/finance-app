<div class="container-fluid p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pemakaian Listrik</h4>
            <p class="text-muted small mb-0">Monitor sisa token dan tren penggunaan harianmu.</p>
        </div>
        <button class="btn btn-outline-primary shadow-sm rounded-pill px-3 py-2" id="btn-hide-balance">
            <i class="bi bi-eye-slash me-1"></i> <span id="text-hide">Sembunyikan Saldo</span>
        </button>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class=" bg-opacity-20 p-2 rounded-3">
                            <i class="bi bi-lightning-charge-fill fs-4"></i>
                        </div>
                        <span class="badge  bg-opacity-20 rounded-pill">Status: Aktif</span>
                    </div>
                    <small class="opacity-75 d-block mb-1 text-uppercase fw-bold" style="letter-spacing: 1px;">Sisa Listrik</small>
                    <h1 class="fw-bold mb-0">
                        <span class="amount" data-original="<?= number_format($latest->kwh_sisa ?? 0, 2) ?> kWh">
                            <?= number_format($latest->kwh_sisa ?? 0, 2) ?> <small style="font-size: 1.2rem;">kWh</small>
                        </span>
                    </h1>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-warning text-white border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class=" bg-opacity-20 p-2 rounded-3">
                            <i class="bi bi-speedometer2 fs-4"></i>
                        </div>
                    </div>
                    <small class="opacity-75 d-block mb-1 text-uppercase fw-bold" style="letter-spacing: 1px;">Rata-rata Harian</small>
                    <h2 class="fw-bold mb-0">
                        <span class="amount" data-original="<?= number_format($avg_per_hari, 2) ?> kWh">
                            <?= number_format($avg_per_hari, 2) ?> <small style="font-size: 1rem;">kWh/hari</small>
                        </span>
                    </h2>
                    <div class="mt-2 small opacity-75">
                        <i class="bi bi-info-circle me-1"></i> Berdasarkan <?= $hari_tercatat ?> hari tercatat
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card bg-success text-white border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class=" bg-opacity-20 p-2 rounded-3">
                            <i class="bi bi-hourglass-split fs-4"></i>
                        </div>
                    </div>
                    <small class="opacity-75 d-block mb-1 text-uppercase fw-bold" style="letter-spacing: 1px;">Estimasi Bertahan</small>
                    <h2 class="fw-bold mb-0">± <?= $estimasi_sisa_hari ?> <small style="font-size: 1rem;">Hari lagi</small></h2>
                    <div class="mt-2 small opacity-75">
                        <i class="bi bi-info-circle me-1"></i> Berdasarkan tren pemakaian
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3"><i class="bi bi-pencil-square me-2 text-primary"></i>Catat Sisa kWh</h6>
                    <form action="<?= base_url('listrik/simpan') ?>" method="POST">
                        <div class="mb-3">
                            <label class="small fw-bold text-muted mt-3 mb-1">Jumlah Sisa kWh Saat Ini</label>
                            <div class="input-group">
                                <input type="number" step="0.01" name="kwh_sisa" class="form-control form-control-lg" placeholder="0.00" required>
                                <span class="input-group-text bg-light fw-bold">kWh</span>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-7">
                                <label class="small fw-bold text-muted mb-1">Tanggal</label>
                                <input type="date" name="tanggal_input" class="form-control" value="<?= date('Y-m-d') ?>" required>
                            </div>
                            <div class="col-5">
                                <label class="small fw-bold text-muted mb-1">Jam</label>
                                <input type="time" name="jam_input" class="form-control" value="<?= date('H:i') ?>" required>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2 fw-bold shadow-sm">
                            Update Data Listrik
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card border-0 shadow-sm rounded-4 p-4 h-100">
                <h6 class="fw-bold mb-1">Tren Penurunan Sisa Listrik</h6>
                <p class="text-muted small mb-4">Memantau sisa energi harian</p>
                <div style="height: 280px;"><canvas id="chartSisaListrik"></canvas></div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-5">
        <div class="card-header  border-0 p-4 pb-0">
            <h6 class="fw-bold mb-0">Log Histori kWh</h6>
        </div>
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableListrik">
                    <thead class="bg-light">
                        <tr>
                            <th class="small fw-bold">Waktu Input</th>
                            <th class="small fw-bold">Sisa kWh</th>
                            <th class="small fw-bold">Pemakaian</th>
                            <th class="small fw-bold text-center">Status</th>
                            <th class="small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($histori as $h) : ?>
                            <tr>
                                <td class="small" data-order="<?= $h->tanggal ?>">
                                    <span class="d-block fw-bold"><?= date('d M Y', strtotime($h->tanggal)) ?></span>
                                    <span class="text-muted" style="font-size: 11px;"><?= date('H:i', strtotime($h->tanggal)) ?> WIB</span>
                                </td>
                                <td class="small fw-bold text-primary">
                                    <span class="amount" data-original="<?= $h->kwh_sisa ?> kWh"><?= $h->kwh_sisa ?> kWh</span>
                                </td>
                                <td class="small text-danger fw-bold">
                                    <span class="amount" data-original="<?= ($h->kwh_terpakai > 0) ? '- ' . $h->kwh_terpakai . ' kWh' : '-' ?>">
                                        <?= ($h->kwh_terpakai > 0) ? '- ' . $h->kwh_terpakai . ' kWh' : '-' ?>
                                    </span>
                                </td>
                                <td class="text-center">
                                    <?php if ($h->kwh_terpakai > 5) : ?>
                                        <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3">Boros</span>
                                    <?php elseif ($h->kwh_terpakai > 0) : ?>
                                        <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3">Hemat</span>
                                    <?php else : ?>
                                        <span class="badge bg-info bg-opacity-10 text-info rounded-pill px-3">Isi Token</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-center">
                                    <a href="<?= base_url('listrik/hapus/' . $h->id) ?>" class="btn btn-sm btn-light text-danger rounded-circle" onclick="return confirm('Hapus catatan ini?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // --- 1. DATATABLES (Fixed Sorting) ---
        $('#tableListrik').DataTable({
            "order": [[ 0, "desc" ]], // Kolom 0 (Tanggal) Urut Terbaru
            "pageLength": 10,
            "lengthMenu": [10, 25, 50],
            "language": {
                "search": "Cari data:",
                "lengthMenu": "Tampilkan _MENU_ data",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ entri",
                "paginate": { "previous": "<", "next": ">" }
            }
        });

        // --- 2. HIDE BALANCE FUNCTION (Sync dengan Dashboard) ---
        let isHidden = localStorage.getItem('balanceHidden') === 'true';
        function applyBalanceStatus() {
            if (isHidden) {
                $('.amount').each(function() {
                    $(this).text($(this).text().includes('kWh') ? '•••• kWh' : '••••••••');
                });
                $('#btn-hide-balance').html('<i class="bi bi-eye me-1"></i> Tampilkan Saldo');
                $('#btn-hide-balance').removeClass('btn-outline-primary').addClass('btn-primary text-white');
            } else {
                $('.amount').each(function() { $(this).text($(this).data('original')); });
                $('#btn-hide-balance').html('<i class="bi bi-eye-slash me-1"></i> Sembunyikan Saldo');
                $('#btn-hide-balance').removeClass('btn-primary text-white').addClass('btn-outline-primary');
            }
        }
        applyBalanceStatus();
        $('#btn-hide-balance').on('click', function() {
            isHidden = !isHidden;
            localStorage.setItem('balanceHidden', isHidden);
            applyBalanceStatus();
        });

        // --- 3. LINE CHART ---
        const ctx = document.getElementById('chartSisaListrik').getContext('2d');
        const labels = [<?php foreach ($chart_data as $c) { echo "'" . date('d/m (H:i)', strtotime($c->tanggal)) . "',"; } ?>];
        const dataSisa = [<?php foreach ($chart_data as $c) { echo $c->kwh_sisa . ","; } ?>];

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Sisa kWh',
                    data: dataSisa,
                    borderColor: '#5f60ff',
                    backgroundColor: 'rgba(95, 96, 255, 0.1)',
                    fill: true,
                    tension: 0.3,
                    pointBackgroundColor: '#5f60ff',
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: false, grid: { color: 'rgba(0,0,0,0.05)', borderDash: [5, 5] } },
                    x: { grid: { display: false } }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: { label: (context) => ` Sisa: ${context.parsed.y} kWh` }
                    }
                }
            }
        });
    });
</script>

<style>
    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #5f60ff !important;
        color: white !important;
        border: none !important;
        border-radius: 8px !important;
    }
    .dataTables_filter input {
        border-radius: 20px !important;
        padding: 5px 15px !important;
        border: 1px solid #dee2e6 !important;
        outline: none !important;
        font-size: 13px;
    }
    table.dataTable thead th { border-bottom: 1px solid #f0f0f0 !important; }
    .amount { transition: all 0.2s ease; }
    .btn-outline-primary { border-width: 1.5px !important; font-weight: 600; transition: 0.3s; }
    .btn-outline-primary:hover {
        background-color: #5f60ff !important;
        color: #fff !important;
        box-shadow: 0 4px 15px rgba(95, 96, 255, 0.3);
    }
</style>