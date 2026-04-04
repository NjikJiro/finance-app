<!DOCTYPE html>
<html>
<head>
    <title>Laporan_<?= $periode_text ?>_<?= $user->nama ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Pengaturan Dasar */
        body { 
            font-family: 'Arial', sans-serif; 
            font-size: 11px; 
            color: #333; 
            background-color: white;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .print-container {
            width: 100%;
            max-width: 1000px;
            margin: 0 auto;
            padding: 20px;
        }

        .card { 
            border: 1px solid #eee; 
            border-radius: 12px; 
            box-shadow: none !important; 
        }

        .table th { 
            background-color: #f8f9fa !important; 
            font-size: 9px; 
            text-transform: uppercase; 
        }

        /* Chart Heights */
        .line-chart-box { height: 280px; width: 100%; position: relative; }
        .donut-chart-box { height: 160px; width: 160px; position: relative; margin: 0 auto; }

        /* Legend Style (Persis Dashboard) */
        .legend-container {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            width: 100%;
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid rgba(0,0,0,0.05);
        }
        .legend-item { display: flex; align-items: flex-start; text-align: left; }
        .legend-dot { width: 7px; height: 7px; border-radius: 50%; margin-top: 4px; margin-right: 7px; flex-shrink: 0; }
        .legend-label { font-size: 10px; font-weight: 700; color: #1e293b; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .legend-value { font-size: 9px; color: #64748b; display: block; }

        @media print {
            @page { size: A4; margin: 1.2cm; }
            body { margin: 0; padding: 0; }
            .print-container { width: 100% !important; max-width: none !important; padding: 0 !important; }
            .card { border: 1px solid #ddd !important; }
        }
    </style>
</head>
<body>
    <div class="print-container">
        
        <div class="d-flex justify-content-between align-items-end border-bottom pb-3 mb-4">
            <div>
                <h4 class="fw-bold mb-0" style="color: #5f60ff;">FINANCE APP REPORT</h4>
                <p class="text-muted mb-0 small">Berdasarkan Siklus Gajian (Dynamic Cycle)</p>
            </div>
            <div class="text-end">
                <h6 class="fw-bold mb-0"><?= strtoupper($user->nama) ?></h6>
                <p class="text-muted mb-0 small"><?= $periode_text ?></p>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-4">
                <div class="card p-2 text-center">
                    <small class="text-muted d-block mb-1">Pemasukan</small>
                    <span class="fw-bold text-success">IDR <?= number_format($ringkasan->total_masuk, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="col-4">
                <div class="card p-2 text-center">
                    <small class="text-muted d-block mb-1">Pengeluaran</small>
                    <span class="fw-bold text-danger">IDR <?= number_format($ringkasan->total_keluar, 0, ',', '.') ?></span>
                </div>
            </div>
            <div class="col-4">
                <div class="card p-2 text-center">
                    <small class="text-muted d-block mb-1">Saldo Akhir</small>
                    <span class="fw-bold text-primary">IDR <?= number_format($saldo_awal + ($ringkasan->total_masuk - $ringkasan->total_keluar), 0, ',', '.') ?></span>
                </div>
            </div>
        </div>

        <div class="card p-4 mb-4 text-center">
            <h6 class="fw-bold small mb-3 text-muted text-start">Tren Perkembangan Saldo</h6>
            <div class="line-chart-box">
                <canvas id="lineChart"></canvas>
            </div>
        </div>

        <div class="row g-4 mb-4">
            <div class="col-6">
                <div class="card p-4 h-100 text-center">
                    <h6 class="fw-bold small mb-4 text-muted text-start">Distribusi Pemasukan</h6>
                    <div class="donut-chart-box">
                        <canvas id="donutMasuk"></canvas>
                    </div>
                    <div id="legendMasuk" class="legend-container"></div>
                </div>
            </div>
            <div class="col-6">
                <div class="card p-4 h-100 text-center">
                    <h6 class="fw-bold small mb-4 text-muted text-start">Distribusi Pengeluaran</h6>
                    <div class="donut-chart-box">
                        <canvas id="donutKeluar"></canvas>
                    </div>
                    <div id="legendKeluar" class="legend-container"></div>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered align-middle w-100">
                <thead>
                    <tr>
                        <th width="15%">Tanggal</th>
                        <th width="55%">Keterangan / Kategori</th>
                        <th width="30%" class="text-end">Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($transaksi as $t): ?>
                    <tr>
                        <td class="text-nowrap"><?= date('d M Y', strtotime($t->tanggal)) ?></td>
                        <td>
                            <div class="fw-bold"><?= $t->keterangan ?: 'Tanpa keterangan' ?></div>
                            <small class="text-muted text-capitalize"><?= $t->tipe ?></small>
                        </td>
                        <td class="text-end fw-bold <?= $t->tipe == 'pendapatan' ? 'text-success' : 'text-danger' ?>">
                            <?= $t->tipe == 'pengeluaran' ? '-' : '+' ?> IDR <?= number_format($t->jumlah, 0, ',', '.') ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="mt-4 d-flex justify-content-between text-muted small border-top pt-3">
            <span>Dicetak pada: <?= date('d/m/Y H:i') ?></span>
            <span>Halaman 1 dari 1</span>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const colors = ['#5f60ff', '#10b981', '#f59e0b', '#ef4444', '#06b6d4', '#8b5cf6', '#ec4899', '#f97316'];

            // 1. Logika Line Chart
            const lineCtx = document.getElementById('lineChart').getContext('2d');
            const dailyData = <?= json_encode($daily_trend) ?>;
            let cumulative = <?= $saldo_awal ?>;
            
            new Chart(lineCtx, {
                type: 'line',
                data: {
                    labels: dailyData.map(i => {
                        const d = new Date(i.tanggal);
                        return d.getDate() + ' ' + d.toLocaleString('id-ID', {month:'short'});
                    }),
                    datasets: [{
                        data: dailyData.map(i => { cumulative += parseFloat(i.selisih); return cumulative; }),
                        borderColor: '#5f60ff', backgroundColor: 'rgba(95, 96, 255, 0.05)', fill: true, tension: 0.3, pointRadius: 3, borderWidth: 2
                    }]
                },
                options: { responsive: true, maintainAspectRatio: false, animation: false, plugins: { legend: { display: false } } }
            });

            // 2. Fungsi Render Donut
            function renderDonut(canvasId, legendId, dataArray) {
                const canvas = document.getElementById(canvasId);
                const legend = document.getElementById(legendId);
                if (!dataArray || dataArray.length === 0) {
                    legend.innerHTML = `<div class="text-center w-100 small text-muted">Tidak ada data kategori</div>`;
                    return;
                }

                new Chart(canvas.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: dataArray.map(i => i.nama_kategori),
                        datasets: [{
                            data: dataArray.map(i => parseFloat(i.total)),
                            backgroundColor: colors, borderWidth: 0, borderRadius: 8, spacing: 4, cutout: '72%'
                        }]
                    },
                    options: { responsive: true, maintainAspectRatio: false, animation: false, plugins: { legend: { display: false } } }
                });

                legend.innerHTML = dataArray.map((item, i) => `
                    <div class="legend-item">
                        <div class="legend-dot" style="background:${colors[i % colors.length]};"></div>
                        <div class="legend-info">
                            <span class="legend-label">${item.nama_kategori}</span>
                            <span class="legend-value">IDR ${parseFloat(item.total).toLocaleString('id-ID')}</span>
                        </div>
                    </div>
                `).join('');
            }

            // 3. Panggil Render Donut
            renderDonut('donutMasuk', 'legendMasuk', <?= json_encode($pemasukan_kategori ?? []) ?>);
            renderDonut('donutKeluar', 'legendKeluar', <?= json_encode($pengeluaran_kategori ?? []) ?>);

            // Dialog Print
            setTimeout(() => { window.print(); }, 1500);
        });
    </script>
</body>
</html>