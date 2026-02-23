<div class="container-fluid p-3 p-md-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Riwayat Transaksi</h4>
            <p class="text-muted small mb-0">Pantau pergerakan uang ATM dan Tunai Anda</p>
        </div>
        <div class="d-flex gap-2">
            <button class="btn btn-outline-primary shadow-sm px-4 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalTransfer">
                <i class="bi bi-arrow-left-right me-1"></i> Transfer
            </button>
            <button class="btn btn-primary shadow-sm px-4 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg me-1"></i> Tambah
            </button>
        </div>
    </div>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
            <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive p-3">
                <table id="tableTransaksi" class="table table-hover align-middle w-100">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-3 py-3 text-muted small text-uppercase">Tanggal</th>
                            <th class="border-0 py-3 text-muted small text-uppercase">Kategori</th>
                            <th class="border-0 py-3 text-muted small text-uppercase">Keterangan</th>
                            <th class="border-0 py-3 text-muted small text-uppercase">Sumber</th>
                            <th class="border-0 py-3 text-muted small text-uppercase text-end">Jumlah</th>
                            <th class="border-0 py-3 text-muted small text-uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($transaksi)) : ?>
                            <?php foreach ($transaksi as $t) : ?>
                                <tr>
                                    <td class="px-3">
                                        <div class="fw-medium"><?= date('d M Y', strtotime($t->tanggal)) ?></div>
                                    </td>
                                    <td>
                                        <?php if ($t->tipe == 'transfer') : ?>
                                            <span class="badge rounded-pill bg-primary bg-opacity-10 text-white px-3 py-2 border border-primary border-opacity-25">
                                                <i class="bi bi-arrow-left-right me-1"></i> Transfer Saldo
                                            </span>
                                        <?php else : ?>
                                            <span class="badge rounded-pill <?= $t->tipe == 'pengeluaran' ? 'bg-danger text-white' : 'bg-success text-white' ?> bg-opacity-10 px-3 py-2 border <?= $t->tipe == 'pengeluaran' ? 'border-danger' : 'border-success' ?> border-opacity-25">
                                                <i class="bi <?= $t->tipe == 'pengeluaran' ? 'bi-arrow-up-right' : 'bi-arrow-down-left' ?> me-1"></i>
                                                <?= htmlspecialchars($t->nama_kategori ?: 'Tanpa Kategori') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <div class="text-muted small " style="max-width: 150px;">
                                            <?= htmlspecialchars($t->keterangan ?: '-') ?>
                                        </div>
                                    </td>
                                    <td>
                                        <?php if ($t->sumber == 'atm') : ?>
                                            <span class="text-secondary small fw-bold"><i class="bi bi-credit-card-2-front me-1"></i> ATM</span>
                                        <?php else : ?>
                                            <span class="text-secondary small fw-bold"><i class="bi bi-cash-stack me-1"></i> TUNAI</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
                                        <?php if ($t->tipe == 'transfer') : ?>
                                            <span class="text-primary fw-bold">Rp <?= number_format($t->jumlah, 0, ',', '.') ?></span>
                                        <?php else : ?>
                                            <span class="<?= $t->tipe == 'pengeluaran' ? 'text-danger' : 'text-success' ?> fw-bold">
                                                <?= $t->tipe == 'pengeluaran' ? '-' : '+' ?> Rp <?= number_format($t->jumlah, 0, ',', '.') ?>
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('transaksi/hapus/' . $t->id) ?>" class="btn btn-outline-danger btn-sm border-0 rounded-circle" onclick="return confirm('Yakin hapus transaksi ini?')">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form method="post" action="<?= base_url('transaksi/simpan') ?>">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="fw-bold">Catat Transaksi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Kategori</label>
                        <select name="kategori_id" id="kategoriSelect" class="form-select form-select-lg rounded-3 fs-6" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategori as $k) : ?>
                                <option value="<?= $k->id ?>" data-tipe="<?= $k->tipe ?>">
                                    <?= htmlspecialchars($k->nama_kategori) ?> (<?= ucfirst($k->tipe) ?>)
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tipe</label>
                            <input type="text" id="tipeDisplay" class="form-control form-control-lg rounded-3 fs-6 bg-light fw-bold" readonly placeholder="-">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Sumber Dana</label>
                            <select name="sumber" class="form-select form-select-lg rounded-3 fs-6" required>
                                <option value="tunai">Tunai (Cash)</option>
                                <option value="atm">ATM / Bank</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Jumlah (Rp)</label>
                        <input type="text" name="jumlah" class="input-nominal form-control form-control-lg rounded-3 fs-6" placeholder="0" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Tanggal</label>
                            <input type="date" name="tanggal" class="form-control form-control-lg rounded-3 fs-6" value="<?= date('Y-m-d') ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label small fw-bold text-muted">Keterangan</label>
                            <input type="text" name="keterangan" class="form-control form-control-lg rounded-3 fs-6" placeholder="Opsional">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-outline-primary px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">Simpan Transaksi</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTransfer" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form method="post" action="<?= base_url('transaksi/proses_transfer') ?>">
                <div class="modal-header border-0 pb-0 px-4 pt-4">
                    <h5 class="fw-bold">Transfer Antar Saldo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Dari</label>
                            <select name="dari_sumber" class="form-select rounded-3" required>
                                <option value="tunai">Tunai (Cash)</option>
                                <option value="atm">ATM / Bank</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label class="form-label small fw-bold text-muted">Ke</label>
                            <select name="ke_sumber" class="form-select rounded-3" required>
                                <option value="atm">ATM / Bank</option>
                                <option value="tunai">Tunai (Cash)</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label small fw-bold text-muted">Jumlah Transfer (Rp)</label>
                        <input type="text" name="jumlah" class="form-control form-control-lg rounded-3 fs-6 input-nominal" placeholder="0" min="1" required>
                    </div>

                    <div class="mt-3">
                        <label class="form-label small fw-bold text-muted">Tanggal</label>
                        <input type="date" name="tanggal" class="form-control rounded-3" value="<?= date('Y-m-d') ?>" required>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-outline-primary px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">Proses Transfer</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        $('#tableTransaksi').DataTable({
            responsive: true,
            "order": [],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari data...",
                lengthMenu: "_MENU_",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row mt-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });

        $('#kategoriSelect').on('change', function() {
            const selected = $(this).find(':selected');
            const tipe = selected.data('tipe');
            const tipeInput = $('#tipeDisplay');

            if (tipe) {
                if (tipe === 'pengeluaran') {
                    tipeInput.val('PENGELUARAN').removeClass('text-success').addClass('text-danger');
                } else {
                    tipeInput.val('PENDAPATAN').removeClass('text-danger').addClass('text-success');
                }
            } else {
                tipeInput.val('-').removeClass('text-danger text-success');
            }
        });
    });
</script>

<script>
    // Gunakan class selector agar bisa menangani semua input nominal di halaman
    const inputsNominal = document.querySelectorAll('.input-nominal');

    inputsNominal.forEach(input => {
        input.addEventListener('keyup', function(e) {
            // Hapus karakter selain angka
            let cleanValue = this.value.replace(/[^0-9]/g, '');
            // Tampilkan dengan format titik
            this.value = formatRupiah(cleanValue);
        });
    });

    /* Fungsi formatRupiah */
    function formatRupiah(angka) {
        if (!angka) return '';
        let number_string = angka.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            let separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }
        return rupiah;
    }

    // Bersihkan titik untuk SEMUA form saat submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function() {
            const nominalField = this.querySelector('.input-nominal');
            if (nominalField) {
                nominalField.value = nominalField.value.replace(/\./g, '');
            }
        });
    });
</script>

<style>
    /* Styling DataTables agar selaras dengan tema */

    :root {
        /* ... variable kamu sebelumnya ... */
        --warning-gradient: linear-gradient(90deg, #fbbf24, #f59e0b);
        --warning-solid: #f59e0b;
    }

    /* Backgrounds */
    .bg-warning {
        background-color: var(--warning-solid) !important;
        background-image: var(--warning-gradient) !important;
        color: #fff !important;
        /* Memastikan teks di atas kuning tetap terbaca */
    }

    .dataTables_filter input {
        border-radius: 50px;
        padding: 8px 20px;
        border: 1px solid #e0e0e0;
        outline: none !important;
        transition: 0.3s;
    }

    .dataTables_filter input:focus {
        border-color: #5f60ff;
        box-shadow: 0 0 0 0.2rem rgba(95, 96, 255, 0.1);
    }

    .pagination .page-link {
        border: none;
        margin: 0 4px;
        border-radius: 10px;
        color: #6c757d;
        font-weight: 500;
    }

    .pagination .page-item.active .page-link {
        background: linear-gradient(90deg, #5f60ff, #7b68ee);
        color: white;
        box-shadow: 0 4px 10px rgba(95, 96, 255, 0.3);
    }
</style>