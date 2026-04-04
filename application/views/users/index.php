<div class="container-fluid p-3 p-md-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Manajemen Users</h4>
            <p class="text-muted small mb-0">Kelola identitas dan hak akses pengguna FinanceApp.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambahUser">
            <i class="bi bi-person-plus-fill me-2"></i> Tambah User
        </button>
    </div>

    <?php if($this->session->flashdata('success')): ?>
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4 alert-dismissible fade show">
            <?= $this->session->flashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 alert-dismissible fade show">
            <?= $this->session->flashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-4">
            <div class="table-responsive">
                <table class="table table-hover align-middle" id="tableUsers">
                    <thead class="bg-light">
                        <tr>
                            <th class="small fw-bold">No</th>
                            <th class="small fw-bold">Nama Lengkap</th>
                            <th class="small fw-bold">Username</th>
                            <th class="small fw-bold">Dibuat Pada</th>
                            <th class="small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($users as $u) : ?>
                            <tr>
                                <td class="small"><?= $no++ ?></td>
                                <td>
                                    <div class="fw-bold text-dark d-flex align-items-center">
                                        <?= htmlspecialchars($u->nama ?? 'Belum Diatur') ?>
                                        <?php if($u->id == 1): ?>
                                            <span class="badge bg-primary bg-opacity-10 text-white ms-2 rounded-pill" style="font-size: 9px;">Admin</span>
                                        <?php endif; ?>
                                    </div>
                                    <small class="text-muted" style="font-size: 10px;">ID: #<?= $u->id ?></small>
                                </td>
                                <td class="text-primary fw-medium">@<?= htmlspecialchars($u->username) ?></td>
                                <td class="small text-muted"><?= date('d M Y', strtotime($u->created_at ?? date('Y-m-d'))) ?></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-primary rounded-pill px-3 me-1" 
                                            onclick="editUser('<?= $u->id ?>', '<?= htmlspecialchars($u->nama ?? '') ?>', '<?= htmlspecialchars($u->username) ?>')">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    
                                    <?php if($u->id != 1): ?>
                                        <a href="<?= base_url('users/hapus/'.$u->id) ?>" 
                                           class="btn btn-sm btn-outline-danger rounded-pill px-3"
                                           onclick="return confirm('Hapus user <?= $u->nama ?>? Semua data terkait user ini akan ikut terhapus.')">
                                            <i class="bi bi-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambahUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="<?= base_url('users/tambah') ?>" method="POST">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold">Tambah User Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control rounded-3" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username</label>
                        <input type="text" name="username" class="form-control rounded-3" required placeholder="username_budi">
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Password</label>
                        <input type="password" name="password" class="form-control rounded-3" required placeholder="Minimal 6 karakter">
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">Simpan User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <form action="<?= base_url('users/simpan_edit') ?>" method="POST">
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-header border-0 pb-0 pt-4 px-4">
                    <h5 class="fw-bold">Edit Profil User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Nama Lengkap</label>
                        <input type="text" name="nama" id="edit_nama" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold text-muted">Username</label>
                        <input type="text" name="username" id="edit_username" class="form-control rounded-3" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label small fw-bold text-muted">Password Baru (Opsional)</label>
                        <input type="password" name="password" class="form-control rounded-3" placeholder="Isi jika ingin ganti">
                        <small class="text-muted" style="font-size: 10px;">*Kosongkan jika tidak ingin mengubah password.</small>
                    </div>
                </div>
                <div class="modal-footer border-0 p-4 pt-0">
                    <button type="button" class="btn btn-light px-4 rounded-pill fw-bold" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary px-4 rounded-pill fw-bold shadow-sm">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Inisialisasi DataTables
        $('#tableUsers').DataTable({
            "pageLength": 10,
            "language": {
                "search": "Cari user:",
                "lengthMenu": "Tampilkan _MENU_ entri",
                "paginate": {
                    "previous": "<",
                    "next": ">"
                }
            }
        });
    });

    // Fungsi untuk memicu Modal Edit dan mengisi datanya
    function editUser(id, nama, username) {
        $('#edit_id').val(id);
        $('#edit_nama').val(nama);
        $('#edit_username').val(username);
        $('#modalEditUser').modal('show');
    }
</script>

<style>
    /* Styling tambahan agar DataTables selaras dengan tema */
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
    }
</style>