<div class="container-fluid p-3 p-md-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">

            <?php if ($this->session->flashdata('success')) : ?>
                <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
                    <i class="bi bi-check-circle-fill me-2"></i> <?= $this->session->flashdata('success') ?>
                </div>
            <?php endif; ?>

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                <div class="bg-primary p-4 text-white text-center position-relative">
                    <div class="position-relative" style="z-index: 2;">
                        <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center text-primary fw-bold shadow-lg mb-3" style="width: 80px; height: 80px; font-size: 2rem;">
                            <?php
                            $name = $this->session->userdata('user_name');
                            $words = explode(" ", $name);
                            echo strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                            ?>
                        </div>
                        <h4 class="fw-bold mb-1"><?= $user->nama ?></h4>
                        <p class="opacity-75 small mb-0">Siklus Keuangan: Tanggal <?= $user->cycle_date ?> tiap bulan</p>
                    </div>
                    <i class="bi bi-person-gear position-absolute end-0 bottom-0 opacity-25 m-n3" style="font-size: 100px;"></i>
                </div>

                <div class="card-body p-4">
                    <form action="<?= base_url('profile/update_action') ?>" method="POST">
                        <h6 class="fw-bold mb-4 text-muted small text-uppercase" style="letter-spacing: 1px;">Informasi Dasar</h6>

                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Nama Lengkap</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-person text-muted"></i></span>
                                    <input type="text" name="nama" class="form-control bg-light border-0 py-2" value="<?= $user->nama ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Username</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-at text-muted"></i></span>
                                    <input type="text" class="form-control bg-light border-0 py-2" value="<?= $user->username ?>" disabled>
                                </div>
                                <small class="text-muted" style="font-size: 10px;">Username tidak dapat diubah.</small>
                            </div>
                        </div>

                        <h6 class="fw-bold mb-4 text-muted small text-uppercase" style="letter-spacing: 1px;">Pengaturan Keuangan</h6>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Tanggal Siklus (Cycle Date)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event text-muted"></i></span>
                                <input type="number" name="cycle_date" class="form-control bg-light border-0 py-2" min="1" max="28" value="<?= $user->cycle_date ?>" required>
                            </div>
                            <small class="text-muted">Laporan dan dashboard akan dihitung dari tanggal ini (Max: 28 untuk kestabilan sistem).</small>
                        </div>

                        <hr class="my-4 opacity-25">

                        <h6 class="fw-bold mb-4 text-muted small text-uppercase" style="letter-spacing: 1px;">Keamanan</h6>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Ganti Password</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0"><i class="bi bi-shield-lock text-muted"></i></span>
                                <input type="password" name="password" class="form-control bg-light border-0 py-2" placeholder="Biarkan kosong jika tidak ingin ganti">
                            </div>
                            <small class="text-danger" style="font-size: 11px;">*Hanya isi jika ingin mengganti password lama Anda.</small>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary px-4 py-2 rounded-pill fw-bold shadow-sm">
                                <i class="bi bi-check2-circle me-2"></i> Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="card border-0 shadow-sm rounded-4 p-4 bg-light border-start border-primary border-4 mb-5 bg-white">
                <div class="row align-items-center">
                    <div class="col-md-7 mb-3 mb-md-0">
                        <h6 class="fw-bold mb-1"><i class="bi bi-printer me-2 text-primary"></i>Cetak Laporan Bulanan</h6>
                        <p class="text-muted small mb-0">Laporan akan dihitung berdasarkan siklus tanggal <?= $user->cycle_date ?> Anda.</p>
                    </div>
                    <div class="col-md-5">
                        <form action="<?= base_url('profile/print_laporan') ?>" method="GET" target="_blank" class="d-flex gap-2">
                            <input type="month" name="periode" class="form-control form-control-sm rounded-3 border-0 shadow-sm" value="<?= date('Y-m') ?>" required>
                            <button type="submit" class="btn btn-primary btn-sm rounded-3 px-3 shadow-sm">
                                <i class="bi bi-download"></i>
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<style>
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(95, 96, 255, 0.1);
        border: 1px solid #5f60ff !important;
    }

    .input-group-text {
        border-right: none !important;
    }
</style>