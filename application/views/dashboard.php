<div class="container-fluid p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Halo <?= $this->session->userdata('user_name') ?></h4>
            <p class="text-muted small mb-0">Berikut adalah status keuanganmu</p>
        </div>
        <button class="btn btn-outline-primary shadow-sm rounded-pill px-3 py-2" id="btn-hide-balance">
            <i class="bi bi-eye-slash me-1"></i> <span id="text-hide">Sembunyikan Saldo</span>
        </button>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-5">
            <div class="card bg-white border-0 shadow-sm h-100 rounded-4">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-primary bg-opacity-10 p-3 rounded-3 me-3"><i class="bi bi-credit-card-2-front text-white fs-3"></i></div>
                    <div><small class="text-muted d-block">Saldo ATM / Bank</small>
                        <h5 class="fw-bold mb-0 text-dark"><span class="amount" data-original="IDR <?= number_format($saldo_atm, 0, ',', '.') ?>">IDR <?= number_format($saldo_atm, 0, ',', '.') ?></span></h5>
                    </div>
                </div>
                <hr class="my-0 mx-3" style="opacity: 0.05;">
                <div class="card-body d-flex align-items-center py-3">
                    <div class="flex-shrink-0 bg-success bg-opacity-10 p-3 rounded-3 me-3"><i class="bi bi-cash-stack text-white fs-3"></i></div>
                    <div><small class="text-muted d-block">Saldo Tunai (Cash)</small>
                        <h5 class="fw-bold mb-0 text-dark"><span class="amount" data-original="IDR <?= number_format($saldo_tunai, 0, ',', '.') ?>">IDR <?= number_format($saldo_tunai, 0, ',', '.') ?></span></h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card bg-primary text-white border-0 shadow-sm rounded-4 position-relative overflow-hidden h-100">
                <div class="card-body p-4" style="z-index: 2;">
                    <small class="opacity-75 d-block mb-1 text-uppercase fw-bold">Kekayaan Bersih</small>
                    <h1 class="fw-bold mb-0"><span class="amount" data-original="IDR <?= number_format($saldo, 0, ',', '.') ?>">IDR <?= number_format($saldo, 0, ',', '.') ?></span></h1>
                    <div class="mt-3 d-flex gap-3">
                        <div class="d-flex align-items-center small">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px;"><i class="bi bi-arrow-up text-success fw-bold"></i></div>
                            <span class="amount" data-original="+IDR <?= number_format($pendapatan_bulan, 0, ',', '.') ?>">+IDR <?= number_format($pendapatan_bulan, 0, ',', '.') ?></span>
                        </div>
                        <div class="d-flex align-items-center small">
                            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center me-2" style="width: 24px; height: 24px;"><i class="bi bi-arrow-down text-danger fw-bold"></i></div>
                            <span class="amount" data-original="-IDR <?= number_format($pengeluaran_bulan, 0, ',', '.') ?>">-IDR <?= number_format($pengeluaran_bulan, 0, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
                <i class="bi bi-shield-lock position-absolute end-0 bottom-0 opacity-25 m-n3" style="font-size: 120px;"></i>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden position-relative <?= $surplus >= 0 ? 'bg-success' : 'bg-danger' ?> text-white text-center py-4">
                <i class="bi <?= $surplus >= 0 ? 'bi-graph-up-arrow' : 'bi-graph-down-arrow' ?> position-absolute start-0 bottom-0 opacity-25 ms-n2 mb-n2" style="font-size: 80px;"></i>

                <div class="position-relative" style="z-index: 2;">
                    <div class="mb-2">
                        <div class="d-inline-flex align-items-center justify-content-center bg-white bg-opacity-20 rounded-circle mb-2" style="width: 45px; height: 45px;">
                            <i class="bi <?= $surplus >= 0 ? 'bi-piggy-bank text-success' : 'bi-exclamation-triangle text-danger' ?> fs-4 "></i>
                        </div>
                        <br>
                        <small class="text-uppercase fw-bold opacity-75" style="letter-spacing: 1px; font-size: 10px;">
                            <?= $surplus >= 0 ? 'Surplus' : 'Defisit' ?> Siklus Ini
                        </small>
                    </div>

                    <h2 class="fw-bold mb-0">
                        <span class="amount" data-original="IDR <?= number_format($surplus, 0, ',', '.') ?>">
                            IDR <?= number_format($surplus, 0, ',', '.') ?>
                        </span>
                    </h2>

                    <?php if ($persen_surplus != 0) : ?>
                        <div class="mt-2">
                            <span class="badge rounded-pill bg-white bg-opacity-25 px-3 py-2 fw-bold" style="backdrop-filter: blur(4px); font-size: 11px;">
                                <i class="bi <?= $persen_surplus >= 0 ? 'bi-caret-up-fill' : 'bi-caret-down-fill' ?> me-1"></i>
                                <?= number_format(abs($persen_surplus), 0) ?>% dari siklus lalu
                            </span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100">
                <h6 class="fw-bold mb-3">Monitoring Anggaran</h6>
                <div class="row g-3">
                    <?php
                    if (!empty($daftar_anggaran)) :
                        // array_slice memastikan hanya data ke-1 sampai ke-4 yang diambil
                        foreach (array_slice($daftar_anggaran, 0, 4) as $ang) :
                            $p = ($ang->total_terpakai > 0) ? ($ang->total_terpakai / $ang->nominal_target) * 100 : 0;
                            $sisa = $ang->nominal_target - $ang->total_terpakai;

                            // Tentukan warna agar sinkron dengan halaman Anggaran
                            $color = 'bg-success'; // Hijau jika di bawah 80%
                            $text_color = 'text-success';

                            if ($p >= 80 && $p < 100) {
                                $color = 'bg-warning'; // Kuning Siaga
                                $text_color = 'text-warning';
                            } elseif ($p >= 100) {
                                $color = 'bg-danger'; // Merah Over
                                $text_color = 'text-danger';
                            }
                    ?>
                            <div class="col-md-6 mb-3">
                                <div class="p-3 border rounded-4 border-light-subtle h-100 shadow-sm bg-white">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-truncate fw-bold small text-dark" style="max-width: 100px;">
                                            <?= htmlspecialchars($ang->nama_kategori) ?>
                                        </span>
                                        <span class="fw-bold small <?= $text_color ?>"><?= number_format($p, 0) ?>%</span>
                                    </div>

                                    <div class="progress rounded-pill mb-2" style="height: 6px; background-color: rgba(0,0,0,0.05);">
                                        <div class="progress-bar <?= $color ?> progress-bar-striped progress-bar-animated" role="progressbar" style="width: <?= min($p, 100) ?>%">
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted" style="font-size: 10px;">Sisa:</small>
                                        <small class="fw-bold amount" style="font-size: 10px;" data-original="IDR <?= number_format(max(0, $sisa), 0, ',', '.') ?>">
                                            IDR <?= number_format(max(0, $sisa), 0, ',', '.') ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <div class="col-12 text-center py-3">
                            <p class="text-muted small mb-0">Belum ada anggaran diatur.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100 rounded-4 bg-white text-center">
                <h6 class="fw-bold mb-4 text-start">Distribusi Pemasukan</h6>
                <div class="chart-box-wrapper">
                    <div class="chart-canvas-container"><canvas id="doughnutPemasukan"></canvas></div>
                    <div id="legendPemasukan" class="legend-container"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm p-4 h-100 rounded-4 bg-white text-center">
                <h6 class="fw-bold mb-4 text-start">Distribusi Pengeluaran</h6>
                <div class="chart-box-wrapper">
                    <div class="chart-canvas-container"><canvas id="doughnutPengeluaran"></canvas></div>
                    <div id="legendPengeluaran" class="legend-container"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 bg-white h-100 p-4">
                <h6 class="fw-bold mb-4">Transaksi Terbaru</h6>
                <?php if (!empty($recent_transactions)) : foreach ($recent_transactions as $rt) : ?>
                        <div class="d-flex align-items-center mb-3 pb-3 border-bottom border-light">
                            <div class="flex-shrink-0 bg-light rounded-3 p-2 me-3 text-center" style="width: 45px;"><i class="bi <?= $rt->tipe == 'pendapatan' ? 'bi-arrow-down-left text-success' : ($rt->tipe == 'transfer' ? 'bi-arrow-left-right text-primary' : 'bi-arrow-up-right text-danger') ?>"></i></div>
                            <div class="flex-grow-1 overflow-hidden">
                                <h6 class="small fw-bold mb-0 text-truncate"><?= $rt->tipe == 'transfer' ? 'Transfer' : htmlspecialchars($rt->nama_kategori) ?></h6><small class="text-muted" style="font-size: 10px;"><?= date('d M', strtotime($rt->tanggal)) ?> • <?= ucfirst($rt->sumber) ?></small>
                            </div>
                            <div class="text-end small fw-bold <?= $rt->tipe == 'pendapatan' ? 'text-success' : ($rt->tipe == 'transfer' ? 'text-primary' : 'text-danger') ?>"><?= $rt->tipe == 'pengeluaran' ? '-' : ($rt->tipe == 'pendapatan' ? '+' : '') ?>IDR <?= number_format($rt->jumlah, 0, ',', '.') ?></div>
                        </div>
                    <?php endforeach;
                else : ?><p class="text-center text-muted small">Belum ada data.</p><?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-5">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100">
                <h6 class="fw-bold mb-4">Tren Keuangan 6 Bulan</h6>
                <div style="height: 300px;"><canvas id="barChart6Bulan"></canvas></div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card border-0 shadow-sm p-4 rounded-4 bg-white h-100">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h6 class="fw-bold mb-0">Perkembangan Saldo</h6>
                    <select id="periodeLineChart" class="form-select custom-select-premium">
                        <option value="7days" selected>7 Hari Terakhir</option>
                        <option value="1month">1 Bulan Terakhir</option>
                        <option value="6months">6 Bulan Terakhir</option>
                    </select>
                </div>
                <div style="height: 300px;"><canvas id="lineChartSaldo"></canvas></div>
            </div>
        </div>
    </div>
</div>

<style>
    .chart-box-wrapper {
        display: flex;
        flex-direction: column;
        align-items: center;
        width: 100%;
    }

    .chart-canvas-container {
        width: 180px;
        height: 180px;
        position: relative;
    }

    .legend-container {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 10px;
        width: 100%;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #f1f5f9;
    }

    .legend-dot {
        width: 8px;
        height: 8px;
        border-radius: 50%;
        margin-right: 8px;
        flex-shrink: 0;
        margin-top: 4px;
    }

    .amount {
        transition: all 0.3s ease;
    }

    .progress {
        background-color: #f1f5f9 !important;
    }

    /* CSS Premium Select */
    .custom-select-premium {
        width: auto;
        min-width: 200px;
        padding: 10px 24px;
        font-size: 0.875rem;
        font-weight: 700;
        color: #5f60ff;
        background-color: #f8faff;
        background-image: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%);
        border: 2px solid rgba(95, 96, 255, 0.2);
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(95, 96, 255, 0.08);
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        appearance: none;
        /* Menghilangkan panah bawaan */
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%235f60ff' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 18px center;
        background-size: 12px;
    }

    /* Efek Hover */
    .custom-select-premium:hover {
        border-color: #5f60ff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(95, 96, 255, 0.15);
    }

    /* Efek Focus */
    .custom-select-premium:focus {
        background-color: transparent;
        border-color: #5f60ff;
        color: #5f60ff;
        box-shadow: none;
    }

    /* Styling untuk pilihan di dalam (Hanya bekerja di beberapa browser) */
    .custom-select-premium option {
        font-weight: 500;
        color: #333;
        background: #ffffff;
        padding: 10px;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const colors = ['#5f60ff', '#10b981', '#ef4444', '#f59e0b', '#8b5cf6', '#06b6d4', '#ec4899'];

        // 1. DOUGHNUT CHARTS
        function renderDoughnut(canvasId, legendId, dataArray) {
            const canvas = document.getElementById(canvasId);
            const legend = document.getElementById(legendId);
            if (!canvas || !dataArray.length) {
                legend.innerHTML = "<small class='text-muted'>Belum ada data</small>";
                return;
            }
            new Chart(canvas.getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: dataArray.map(i => i.nama_kategori),
                    datasets: [{
                        data: dataArray.map(i => parseFloat(i.total)),
                        backgroundColor: colors,
                        borderWidth: 0,
                        borderRadius: 10,
                        spacing: 5
                    }]
                },
                options: {
                    cutout: '75%',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
            legend.innerHTML = dataArray.map((item, i) => `<div class="d-flex align-items-start"><div class="legend-dot" style="background:${colors[i % colors.length]}"></div><div style="line-height:1.2"><div class="small fw-bold text-dark text-truncate" style="max-width:80px">${item.nama_kategori}</div><small class="text-muted" style="font-size:9px">IDR ${parseFloat(item.total).toLocaleString('id-ID')}</small></div></div>`).join('');
        }
        renderDoughnut('doughnutPemasukan', 'legendPemasukan', <?= json_encode($pemasukan_kategori ?? []) ?>);
        renderDoughnut('doughnutPengeluaran', 'legendPengeluaran', <?= json_encode($pengeluaran_kategori ?? []) ?>);

        // 2. BAR CHART
        const barData = <?= json_encode($bulanan_6 ?? []) ?>;
        new Chart(document.getElementById('barChart6Bulan').getContext('2d'), {
            type: 'bar',
            data: {
                labels: barData.map(i => i.periode),
                datasets: [{
                    label: 'Masuk',
                    data: barData.map(i => i.pendapatan),
                    backgroundColor: 'rgba(16, 185, 129, 0.2)',
                    borderColor: '#10b981',
                    borderWidth: 2,
                    borderRadius: 5
                }, {
                    label: 'Keluar',
                    data: barData.map(i => i.pengeluaran),
                    backgroundColor: 'rgba(239, 68, 68, 0.2)',
                    borderColor: '#ef4444',
                    borderWidth: 2,
                    borderRadius: 5
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: v => 'IDR ' + (v / 1000000).toFixed(1) + 'jt',
                            font: {
                                size: 10
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            boxWidth: 10
                        }
                    }
                }
            }
        });

        // 3. LINE CHART WITH FILTER
        const lineDataConfig = {
            '7days': {
                raw: <?= json_encode($raw_7days ?? []) ?>,
                base: <?= $base_7days ?? 0 ?>
            },
            '1month': {
                raw: <?= json_encode($raw_1month ?? []) ?>,
                base: <?= $base_1month ?? 0 ?>
            },
            '6months': {
                raw: <?= json_encode($raw_6months ?? []) ?>,
                base: <?= $base_6months ?? 0 ?>
            }
        };

        function processLineData(range) {
            const cfg = lineDataConfig[range];
            let cumulative = parseFloat(cfg.base);
            return {
                labels: cfg.raw.map(i => range === '6months' ? i.label : new Date(i.label).toLocaleDateString('id-ID', {
                    day: 'numeric',
                    month: 'short'
                })),
                values: cfg.raw.map(i => {
                    cumulative += parseFloat(i.selisih);
                    return cumulative;
                })
            };
        }

        const lineCtx = document.getElementById('lineChartSaldo').getContext('2d');
        let currentLineData = processLineData('7days');
        const lineChart = new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: currentLineData.labels,
                datasets: [{
                    label: 'Saldo',
                    data: currentLineData.values,
                    borderColor: '#5f60ff',
                    backgroundColor: 'rgba(95, 96, 255, 0.1)',
                    fill: true,
                    tension: 0.4,
                    pointRadius: 2,
                    borderWidth: 2
                }]
            },
            options: {
                maintainAspectRatio: false,
                scales: {
                    y: {
                        ticks: {
                            callback: v => 'IDR ' + (v / 1000000).toFixed(1) + 'jt',
                            font: {
                                size: 10
                            }
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
                    }
                }
            }
        });

        document.getElementById('periodeLineChart').addEventListener('change', function() {
            const newData = processLineData(this.value);
            lineChart.data.labels = newData.labels;
            lineChart.data.datasets[0].data = newData.values;
            lineChart.update();
        });

        // 4. BALANCE TOGGLE
        let isHidden = localStorage.getItem('balanceHidden') === 'true';
        const toggleBalance = () => {
            document.querySelectorAll('.amount').forEach(el => el.innerText = isHidden ? 'IDR •••••••••' : el.dataset.original);
            const btn = document.getElementById('btn-hide-balance');
            if (btn) btn.innerHTML = isHidden ? '<i class="bi bi-eye"></i> Tampilkan' : '<i class="bi bi-eye-slash"></i> Sembunyikan';
        };
        toggleBalance();
        document.getElementById('btn-hide-balance').addEventListener('click', () => {
            isHidden = !isHidden;
            localStorage.setItem('balanceHidden', isHidden);
            toggleBalance();
        });
    });
</script>