<div class="container-fluid p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Halo, Renjiro!</h4>
            <p class="text-muted small mb-0">Berikut adalah status keuanganmu dari semua sumber dana.</p>
        </div>
        <button class="btn btn-outline-primary shadow-sm rounded-pill px-3 py-2 " id="btn-hide-balance">
            <i class="bi bi-eye-slash me-1"></i> <span id="text-hide">Sembunyikan Saldo</span>
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="card bg-white border-0 shadow-sm h-100 rounded-4">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-credit-card-2-front text-white fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Saldo ATM / Bank</small>
                        <h5 class="fw-bold mb-0 text-dark">
                            <span class="amount" data-original="Rp <?= number_format($saldo_atm, 0, ',', '.') ?>">
                                Rp <?= number_format($saldo_atm, 0, ',', '.') ?>
                            </span>
                        </h5>
                    </div>
                </div>
                <hr class="my-0 mx-3" style="opacity: 0.05;">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3 me-3">
                        <i class="bi bi-cash-stack text-white fs-3"></i>
                    </div>
                    <div>
                        <small class="text-muted d-block">Saldo Tunai (Cash)</small>
                        <h5 class="fw-bold mb-0 text-dark">
                            <span class="amount" data-original="Rp <?= number_format($saldo_tunai, 0, ',', '.') ?>">
                                Rp <?= number_format($saldo_tunai, 0, ',', '.') ?>
                            </span>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7">
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 position-relative overflow-hidden h-100">
                <div class="card-body p-4 position-relative" style="z-index: 2;">
                    <small class="opacity-75 d-block mb-1 text-uppercase fw-bold" style="letter-spacing: 1px;">Kekayaan Bersih</small>
                    <h1 class="fw-bold mb-0">
                        <span class="amount" data-original="Rp <?= number_format($saldo, 0, ',', '.') ?>">
                            Rp <?= number_format($saldo, 0, ',', '.') ?>
                        </span>
                    </h1>

                    <div class="mt-3 d-flex gap-3">
                        <div class="d-flex align-items-center small">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px;">
                                <i class="bi bi-arrow-up text-success fw-bold" style="font-size: 14px;"></i>
                            </div>
                            <span class="amount" data-original="+Rp <?= number_format($pendapatan_bulan, 0, ',', '.') ?>">
                                +Rp <?= number_format($pendapatan_bulan, 0, ',', '.') ?>
                            </span>
                        </div>

                        <div class="d-flex align-items-center small">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px;">
                                <i class="bi bi-arrow-down text-danger fw-bold" style="font-size: 14px;"></i>
                            </div>
                            <span class="amount" data-original="-Rp <?= number_format($pengeluaran_bulan, 0, ',', '.') ?>">
                                -Rp <?= number_format($pengeluaran_bulan, 0, ',', '.') ?>
                            </span>
                        </div>
                    </div>
                </div>
                <i class="bi bi-shield-lock position-absolute end-0 bottom-0 opacity-25 m-n3" style="font-size: 120px; z-index: 1;"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 <?= $surplus >= 0 ? 'bg-success' : 'bg-danger' ?> text-white text-center">
                <div class="card-body d-flex flex-column justify-content-center py-4">
                    <small class="opacity-75"><?= $surplus >= 0 ? 'Surplus Terkumpul' : 'Defisit Anggaran' ?> Bulan Ini</small>

                    <div class="d-flex align-items-center justify-content-center mt-2 gap-2">
                        <h3 class="fw-bold mb-0">
                            <span class="amount" data-original="Rp <?= number_format($surplus, 0, ',', '.') ?>">
                                Rp <?= number_format($surplus, 0, ',', '.') ?>
                            </span>
                        </h3>

                        <?php if ($persen_surplus != 0) :
                            $is_naik = $persen_surplus >= 0;
                            $ikon = $is_naik ? 'bi-caret-up-fill text-success' : 'bi-caret-down-fill text-danger';
                        ?>
                            <span class="badge rounded-pill text-dark bg-white bg-opacity-20 d-flex align-items-center" style="font-size: 11px; padding: 4px 8px; font-weight: 600;">
                                <i class="bi <?= $ikon ?> me-1"></i>
                                <?= number_format(abs($persen_surplus), 0) ?>%
                            </span>
                        <?php endif; ?>
                    </div>
                </div>
                <i class="bi bi-clipboard-data-fill position-absolute start-0 top-0 opacity-25 m-n3" style="font-size: 100px; z-index: 1;"></i>

            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 rounded-4 h-100 bg-white text-center text-md-start">
                <h6 class="fw-bold mb-3">Monitoring Anggaran</h6>
                <div class="row g-3">
                    <?php if (!empty($daftar_anggaran)) :
                        foreach (array_slice($daftar_anggaran, 0, 3) as $ang) :
                            $p = ($ang->total_terpakai > 0) ? ($ang->total_terpakai / $ang->nominal_target) * 100 : 0;
                    ?>
                            <div class="col-md-6">
                                <div class="small d-flex justify-content-between mb-1">
                                    <span class="text-truncate fw-medium"><?= $ang->nama_kategori ?></span>
                                    <span class="fw-bold"><?= number_format($p, 0) ?>%</span>
                                </div>
                                <div class="progress rounded-pill" style="height: 6px;">
                                    <div class="progress-bar <?= $p >= 100 ? 'bg-danger' : 'bg-primary' ?>" style="width: <?= min($p, 100) ?>%"></div>
                                </div>
                            </div>
                        <?php endforeach;
                    else : ?>
                        <div class="col-12">
                            <p class="text-muted small mb-0">Belum ada anggaran yang diatur bulan ini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100 rounded-4 bg-white">
                <h6 class="fw-bold mb-4">Distribusi Pemasukan</h6>
                <div class="d-flex align-items-center gap-4">
                    <div style="flex: 1; max-width: 180px;"><canvas id="doughnutPemasukan"></canvas></div>
                    <div id="legendPemasukan" class="flex-grow-1"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100 rounded-4 bg-white">
                <h6 class="fw-bold mb-4">Distribusi Pengeluaran</h6>
                <div class="d-flex align-items-center gap-4">
                    <div style="flex: 1; max-width: 180px;"><canvas id="doughnutPengeluaran"></canvas></div>
                    <div id="legendPengeluaran" class="flex-grow-1"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h6 class="fw-bold mb-0">Transaksi Terbaru</h6>
                        <a href="<?= base_url('transaksi') ?>" class="text-primary small text-decoration-none">Lihat Semua</a>
                    </div>

                    <?php if (!empty($recent_transactions)) : ?>
                        <div class="transaction-list">
                            <?php foreach ($recent_transactions as $rt) : ?>
                                <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light last-child-border-0">
                                    <div class="flex-shrink-0 bg-light rounded-3 p-2 me-3 text-center" style="width: 45px;">
                                        <i class="bi <?= $rt->tipe == 'pendapatan' ? 'bi-arrow-down-left text-success' : ($rt->tipe == 'transfer' ? 'bi-arrow-left-right text-primary' : 'bi-arrow-up-right text-danger') ?> fs-5"></i>
                                    </div>
                                    <div class="flex-grow-1 overflow-hidden">
                                        <h6 class="small fw-bold mb-0 text-truncate">
                                            <?= $rt->tipe == 'transfer' ? 'Transfer Saldo' : htmlspecialchars($rt->nama_kategori) ?>
                                        </h6>
                                        <small class="text-muted" style="font-size: 11px;">
                                            <?= date('d M Y', strtotime($rt->tanggal)) ?> • <?= ucfirst($rt->sumber) ?>
                                        </small>
                                    </div>
                                    <div class="text-end">
                                        <div class="small fw-bold <?= $rt->tipe == 'pendapatan' ? 'text-success' : ($rt->tipe == 'transfer' ? 'text-primary' : 'text-danger') ?>">
                                            <?= $rt->tipe == 'pengeluaran' ? '-' : ($rt->tipe == 'pendapatan' ? '+' : '') ?>
                                            Rp<?= number_format($rt->jumlah, 0, ',', '.') ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <div class="text-center py-4">
                            <i class="bi bi-receipt text-muted opacity-25" style="font-size: 3rem;"></i>
                            <p class="text-muted small mt-2">Belum ada transaksi</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>


    <div class="row flex-row g-4">
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 d-flex flex-column">
                <h6 class="fw-bold mb-4">Tren Keuangan 6 Bulan Terakhir</h6>
                <div class="flex-grow-1" style="min-height: 250px; position: relative; width: 100%;">
                    <canvas id="barChart6Bulan"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100 d-flex flex-column">
                <h6 class="fw-bold mb-4">Perkembangan Saldo 6 Bulan Terakhir</h6>
                <div class="flex-grow-1" style="min-height: 250px; position: relative; width: 100%;">
                    <canvas id="lineChartSaldo"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Fungsi untuk Doughnut Chart
    function createDoughnut(canvasId, legendId, dataArray) {
        const canvas = document.getElementById(canvasId);
        const legend = document.getElementById(legendId);
        if (!canvas || !dataArray.length) {
            legend.innerHTML = "<small class='text-muted'>Belum ada data</small>";
            return;
        }

        const values = dataArray.map(i => parseFloat(i.total || 0));
        const colors = ['#5f60ff', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6', '#06b6d4'];

        new Chart(canvas.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: dataArray.map(i => i.nama_kategori),
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderWidth: 2,
                    borderColor: '#fff'
                }]
            },
            options: {
                cutout: '0%',
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        legend.innerHTML = dataArray.map((item, i) => `
            <div class="d-flex align-items-center mb-2">
                <div style="width:10px;height:10px;background:${colors[i % colors.length]};border-radius:50%;margin-right:10px;"></div>
                <div class="small"><b>${item.nama_kategori}</b><br><span class="text-muted">Rp ${parseFloat(item.total).toLocaleString('id-ID')}</span></div>
            </div>
        `).join('');
    }

    document.addEventListener("DOMContentLoaded", function() {
        // Render Doughnut
        createDoughnut('doughnutPemasukan', 'legendPemasukan', <?= json_encode($pemasukan_kategori ?? []) ?>);
        createDoughnut('doughnutPengeluaran', 'legendPengeluaran', <?= json_encode($pengeluaran_kategori ?? []) ?>);

        // === RENDER BAR CHART 6 BULAN ===
        const barCanvas = document.getElementById('barChart6Bulan');
        if (barCanvas) {
            const rawData = <?= json_encode($bulanan_6 ?? []) ?>;

            new Chart(barCanvas.getContext('2d'), {
                type: 'bar',
                data: {
                    labels: rawData.map(i => i.periode),
                    datasets: [{
                            label: 'Pendapatan',
                            data: rawData.map(i => i.pendapatan),
                            backgroundColor: 'rgba(16, 185, 129, 0.2)',
                            borderColor: '#10b981',
                            borderWidth: 2,
                            borderRadius: 6,
                            barPercentage: 0.6
                        },
                        {
                            label: 'Pengeluaran',
                            data: rawData.map(i => i.pengeluaran),
                            backgroundColor: 'rgba(239, 68, 68, 0.2)',
                            borderColor: '#ef4444',
                            borderWidth: 2,
                            borderRadius: 6,
                            barPercentage: 0.6
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                display: true, // AKTIFKAN INI
                                color: 'rgba(0, 0, 0, 0.07)', // Warna garis tipis (soft grey)
                                drawBorder: false, // Menghilangkan garis tepi kiri yang kaku
                                borderDash: [5, 5]
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                callback: v => 'Rp ' + v.toLocaleString('id-ID')
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                boxWidth: 8,
                                font: {
                                    size: 11,
                                    family: 'Poppins'
                                }
                            }
                        }
                    }
                }
            });
        }

        // === RENDER LINE CHART PERKEMBANGAN SALDO ===
        const lineCanvas = document.getElementById('lineChartSaldo');
        if (lineCanvas) {
            const rawData = <?= json_encode($bulanan_6 ?? []) ?>;

            // Logika menghitung saldo kumulatif (perkembangan)
            let saldoAkumulatif = 0;
            const dataSaldo = rawData.map(i => {
                saldoAkumulatif += (parseFloat(i.pendapatan) - parseFloat(i.pengeluaran));
                return saldoAkumulatif;
            });

            new Chart(lineCanvas.getContext('2d'), {
                type: 'line',
                data: {
                    labels: rawData.map(i => i.periode),
                    datasets: [{
                        label: 'Total Saldo',
                        data: dataSaldo,
                        borderColor: '#5f60ff', // Warna primary kamu
                        backgroundColor: 'rgba(95, 96, 255, 0.1)',
                        fill: true,
                        tension: 0.4, // Membuat garis melengkung (smooth)
                        pointRadius: 4,
                        pointBackgroundColor: '#5f60ff',
                        borderWidth: 3
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: false, // Biarkan menyesuaikan dengan saldo
                            grid: {
                                color: 'rgba(0,0,0,0.07)'
                            },
                            ticks: {
                                font: {
                                    size: 10
                                },
                                callback: v => 'Rp ' + v.toLocaleString('id-ID')
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                font: {
                                    size: 10
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }, // Legend disembunyikan agar lebih clean
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return ' Saldo: Rp ' + context.parsed.y.toLocaleString('id-ID');
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

<script>
    $(document).ready(function() {
        // Cek status terakhir di localStorage
        let isHidden = localStorage.getItem('balanceHidden') === 'true';

        function applyBalanceStatus() {
            if (isHidden) {
                $('.amount').each(function() {
                    $(this).text('Rp •••••••••');
                });
                $('#btn-hide-balance').html('<i class="bi bi-eye me-1"></i> Tampilkan Saldo');
                $('#btn-hide-balance').removeClass('btn-outline-primary').addClass('btn-primary text-white');
            } else {
                $('.amount').each(function() {
                    $(this).text($(this).data('original'));
                });
                $('#btn-hide-balance').html('<i class="bi bi-eye-slash me-1"></i> Sembunyikan Saldo');
                $('#btn-hide-balance').removeClass('btn-primary text-white').addClass('btn-outline-primary');
            }
        }

        // Jalankan saat halaman pertama load
        applyBalanceStatus();

        $('#btn-hide-balance').on('click', function() {
            isHidden = !isHidden;
            localStorage.setItem('balanceHidden', isHidden);
            applyBalanceStatus();
        });
    });
</script>

<style>
    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-danger,
    .btn-outline-warning {
        background-color: transparent !important;
        border-width: 2px !important;
        transition: all 0.3s ease;
        font-weight: 600;
    }

    .btn-outline-primary {
        color: #5f60ff !important;
        border-color: #5f60ff !important;
    }

    .btn-outline-primary:hover {
        background-image: var(--primary-gradient) !important;
        color: #fff !important;
        border-color: transparent !important;
        box-shadow: 0 4px 15px rgba(95, 96, 255, 0.3);
    }
</style>