<div class="container-fluid p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Anggaran Siklus</h4>
            <p class="text-muted small mb-0">
                Periode: <span class="badge bg-light text-muted border"><?= $periode_text ?></span> 
                • Sisa <b><?= $sisa_hari ?> hari</b> lagi.
            </p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalAnggaran">
            <i class="bi bi-bullseye me-2"></i>Atur Target
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4"><?= $this->session->flashdata('success') ?></div>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($daftar_anggaran)) : ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-clipboard2-check fs-1 text-muted opacity-25"></i>
                <p class="text-muted mt-2">Belum ada anggaran yang diatur untuk siklus ini.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($daftar_anggaran as $a) :
            $persentase = ($a->total_terpakai > 0) ? ($a->total_terpakai / $a->nominal_target) * 100 : 0;
            $sisa_budget = $a->nominal_target - $a->total_terpakai;

            // Logika jatah harian berdasarkan sisa hari siklus
            $jatah_harian = ($sisa_budget > 0) ? ($sisa_budget / $sisa_hari) : 0;

            $warna_status = "success";
            if ($persentase >= 80 && $persentase < 100) $warna_status = "warning";
            if ($persentase >= 100) $warna_status = "danger";
        ?>
            <div class="col-md-6 col-xl-4 mb-4">
                <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="pe-2 text-truncate">
                                <h6 class="fw-bold text-dark mb-1 text-truncate"><?= htmlspecialchars($a->nama_kategori) ?></h6>
                                <small class="text-muted" style="font-size: 11px;">
                                    Target Siklus: <span class="fw-bold text-dark">IDR <?= number_format($a->nominal_target, 0, ',', '.') ?></span>
                                </small>
                            </div>
                            <a href="<?= base_url('anggaran/hapus/' . $a->id) ?>" class="btn btn-sm btn-light text-danger rounded-circle btn-delete-anggaran" onclick="return confirm('Hapus anggaran <?= $a->nama_kategori ?>?')" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center;">
                                <i class="bi bi-trash3 small"></i>
                            </a>
                        </div>

                        <div class="bg-primary-soft rounded-4 p-3 mb-3 border-start border-primary border-4">
                            <small class="text-muted d-block mb-1" style="font-size: 11px;">Jatah harian gajian ini:</small>
                            <h5 class="fw-bold text-primary mb-0">
                                IDR <?= number_format($jatah_harian, 0, ',', '.') ?>
                                <small class="text-muted fw-normal" style="font-size: 10px;">/ hari</small>
                            </h5>
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <small class="fw-bold text-muted" style="font-size: 10px;">Pemakaian Siklus</small>
                            <span class="badge bg-<?= $warna_status ?> <?= $warna_status == 'warning' ? 'text-dark' : '' ?> rounded-pill" style="font-size: 10px;">
                                <?= number_format($persentase, 0) ?>%
                            </span>
                        </div>
                        <div class="progress rounded-pill mb-3" style="height: 8px; background-color: #f0f0f0;">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-<?= $warna_status ?>" role="progressbar" style="width: <?= min($persentase, 100) ?>%"></div>
                        </div>

                        <div class="row g-0 py-2 border-top mt-2">
                            <div class="col-6 border-end pe-2">
                                <small class="text-muted d-block" style="font-size: 10px;">Terpakai:</small>
                                <span class="fw-bold text-danger" style="font-size: 12px;">
                                    IDR <?= number_format($a->total_terpakai, 0, ',', '.') ?>
                                </span>
                            </div>
                            <div class="col-6 ps-3">
                                <small class="text-muted d-block" style="font-size: 10px;">Sisa Budget:</small>
                                <span class="fw-bold <?= $sisa_budget < 0 ? 'text-danger' : 'text-success' ?>" style="font-size: 12px;">
                                    IDR <?= number_format(abs($sisa_budget), 0, ',', '.') ?>
                                    <?= $sisa_budget < 0 ? ' (Over)' : '' ?>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="modalAnggaran" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold">Atur Target Anggaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('anggaran/simpan') ?>" method="POST">
                <div class="modal-body py-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Kategori Pengeluaran</label>
                        <select name="kategori_id" class="form-select rounded-3" required>
                            <option value="">Pilih Kategori...</option>
                            <?php foreach($kategori_pengeluaran as $kp): ?>
                                <option value="<?= $kp->id ?>"><?= $kp->nama_kategori ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nominal Target per Siklus</label>
                        <div class="input-group">
                            <span class="input-group-text border-0 bg-light">IDR</span>
                            <input type="number" name="nominal_target" class="form-control border-0 bg-light" placeholder="Contoh: 500000" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0">
                    <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold">Simpan Anggaran</button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    :root {
        --primary-color: #5f60ff;
        --primary-gradient: linear-gradient(135deg, #5f60ff 0%, #8b5cf6 100%);
    }
    .bg-primary-soft { background-color: rgba(95, 96, 255, 0.08) !important; }
    .btn-primary { background-image: var(--primary-gradient); border: none; }
    .btn-delete-anggaran { opacity: 0.5; transition: 0.2s; }
    .btn-delete-anggaran:hover { opacity: 1; background: #fff1f1 !important; }
</style>