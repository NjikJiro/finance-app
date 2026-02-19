<div class="container-fluid p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 ">Anggaran Pengeluaran</h4>
            <p class="text-muted small mb-0">Atur batas pengeluaran bulanan Anda</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAnggaran">
            <i class="bi bi-bullseye me-2"></i>Atur Target
        </button>
    </div>

    <div class="row">
        <?php if (empty($daftar_anggaran)) : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-clipboard2-check fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-2">Belum ada anggaran yang diatur bulan ini.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($daftar_anggaran as $a) :
            $persentase = ($a->total_terpakai > 0) ? ($a->total_terpakai / $a->nominal_target) * 100 : 0;
            $warna_bar = "bg-success";
            if ($persentase >= 80) $warna_bar = "bg-warning text-dark";
            if ($persentase >= 100) $warna_bar = "bg-danger";
        ?>
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="fw-bold text-dark mb-0"><?= htmlspecialchars($a->nama_kategori) ?></h6>
                            <span class="badge <?= $warna_bar ?> rounded-pill"><?= number_format($persentase, 0) ?>%</span>
                        </div>

                        <div class="progress rounded-pill mb-3" style="height: 12px; background-color: #f0f0f0;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated <?= $warna_bar ?>" role="progressbar" style="width: <?= min($persentase, 100) ?>%"></div>
                        </div>

                        <div class="row text-muted small">
                            <div class="col-6">
                                <span>Terpakai:</span><br>
                                <span class="fw-bold text-dark">Rp <?= number_format($a->total_terpakai, 0, ',', '.') ?></span>
                            </div>
                            <div class="col-6 text-end">
                                <span>Target:</span><br>
                                <span class="fw-bold text-primary">Rp <?= number_format($a->nominal_target, 0, ',', '.') ?></span>
                            </div>
                        </div>

                        <?php if ($persentase >= 100) : ?>
                            <div class="mt-3 p-2 bg-danger bg-opacity-10 text-white rounded-3 small text-center fw-bold">
                                <i class="bi bi-exclamation-octagon-fill me-1"></i> Wah, sudah lewat batas!
                            </div>
                        <?php elseif ($persentase >= 80) : ?>
                            <div class="mt-3 p-2 bg-warning bg-opacity-10 text-dark rounded-3 small text-center fw-bold">
                                <i class="bi bi-exclamation-triangle-fill me-1"></i> Hati-hati, hampir penuh!
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="modalAnggaran" tabindex="-1" aria-labelledby="modalAnggaranLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">

            <form action="<?= base_url('anggaran/simpan') ?>" method="POST">

                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold text-dark" id="modalAnggaranLabel">Atur Target Anggaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body p-4">

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kategori Pengeluaran</label>
                        <select name="kategori_id" class="form-select form-select-lg rounded-3 fs-6" required>
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            <?php foreach ($kategori_pengeluaran as $k) : ?>
                                <option value="<?= $k->id ?>">
                                    <?= htmlspecialchars($k->nama_kategori) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div class="form-text mt-2 small">Hanya kategori bertipe <strong>Pengeluaran</strong> yang muncul di sini.</div>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Nominal Target (Rp)</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light border-end-0 text-muted" style="border-radius: 12px 0 0 12px;">Rp</span>
                            <input type="number" name="nominal_target" class="form-control form-control-lg border-start-0 shadow-none" placeholder="Contoh: 1500000" min="1" required style="border-radius: 0 12px 12px 0; font-size: 1rem;">
                        </div>
                    </div>
                </div>

                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success px-4 rounded-pill fw-bold shadow-sm">
                        Simpan Anggaran
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>