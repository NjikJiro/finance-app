<div class="container-fluid p-3 p-md-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Kategori Transaksi</h4>
            <p class="text-muted small mb-0">Kelola kategori untuk memisahkan jenis keuangan Anda</p>
        </div>
        <button class="btn btn-primary shadow-sm px-4 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#modalTambahKategori">
            <i class="bi bi-plus-lg me-1"></i> Tambah
        </button>
    </div>

    <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm rounded-3" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i>
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive p-3">
                <table id="tableKategori" class="table table-hover align-middle w-100">
                    <thead class="bg-light">
                        <tr>
                            <th class="border-0 px-3 py-3 text-muted small text-uppercase">Nama Kategori</th>
                            <th class="border-0 py-3 text-muted small text-uppercase">Tipe</th>
                            <th class="border-0 py-3 text-muted small text-uppercase text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($kategori)) : ?>
                            <?php foreach ($kategori as $k) : ?>
                                <tr>
                                    <td class="px-3">
                                        <div class="fw-regular text-dark"><?= htmlspecialchars($k->nama_kategori) ?></div>
                                    </td>
                                    <td>
                                        <?php if ($k->tipe == 'pendapatan') : ?>
                                            <span class="text-white badge rounded-pill bg-success bg-opacity-10 text-success px-3 py-2">
                                                <i class="bi bi-arrow-down-left me-1"></i> Pendapatan
                                            </span>
                                        <?php elseif ($k->tipe == 'transfer') : ?>
                                            <span class="text-white badge rounded-pill bg-primary px-3 py-2">
                                                <i class="bi bi-arrow-left-right me-1"></i> Transfer
                                            </span>
                                        <?php else : ?>
                                            <span class="text-white badge rounded-pill bg-danger bg-opacity-10 text-danger px-3 py-2">
                                                <i class="bi bi-arrow-up-right me-1"></i> Pengeluaran
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-center">
                                        <a href="<?= base_url('kategori/hapus/' . $k->id) ?>" class="btn btn-outline-danger btn-sm border-0 rounded-circle" onclick="return confirm('Yakin hapus kategori ini?')">
                                            <i class="bi bi-trash3"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php else : ?>
                            <tr>
                                <td colspan="3" class="text-center py-4 text-muted small">Belum ada data kategori</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow rounded-4">
            <form method="post" action="<?= base_url('kategori/simpan') ?>">
                <div class="modal-header border-0 pb-0">
                    <h5 class="fw-bold">Tambah Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Kategori</label>
                        <input type="text" name="nama_kategori" class="form-control form-control-lg rounded-3 fs-6" placeholder="" required>
                    </div>

                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Tipe Kategori</label>
                        <select name="tipe" class="form-select form-select-lg rounded-3 fs-6" required>
                            <option value="pendapatan">Pendapatan (Uang Masuk)</option>
                            <option value="pengeluaran">Pengeluaran (Uang Keluar)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer border-0 pt-0 p-4">
                    <button type="button" class="btn btn-outline-primary px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#tableKategori').DataTable({
            responsive: true,
            "order": [],
            "pageLength": 20,
            "lengthMenu": [20, 25, 50],
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari kategori...",
                lengthMenu: "_MENU_",
                info: "Data _START_ - _END_ dari _TOTAL_",
                paginate: {
                    previous: "<",
                    next: ">"
                }
            },
            dom: "<'row'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        });
    });
</script>


<style>
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

    /* Merapikan DataTables Search Box */
    .dataTables_filter input {
        border-radius: 50px;
        padding: 5px 15px;
        border: 1px solid #eee;
        outline: none !important;
    }

    .dataTables_filter input:focus {
        border-color: #5f60ff;
        box-shadow: 0 0 0 0.2rem rgba(95, 96, 255, 0.1);
    }

    .pagination .page-link {
        border: none;
        margin: 0 3px;
        border-radius: 8px;
        color: #666;
    }

    .pagination .page-item.active .page-link {
        color: white;
        background-color: #5f60ff;
        background-image: linear-gradient(90deg, #5f60ff, #7b68ee);
    }
</style>