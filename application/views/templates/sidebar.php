<div class="sidebar d-flex flex-column" id="sidebar">
    <div class="brand p-4 text-center border-bottom">
        <h4 class="fw-bold mb-0 text-primary">FinanceApp</h4>
    </div>

    <div class="mt-3 flex-grow-1 px-3">
        <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center <?= empty($this->uri->segment(1)) || $this->uri->segment(1) == 'dashboard' ? 'active text-white' : 'text-dark' ?>" href="<?= base_url('dashboard') ?>">
            <i class="bi bi-grid-1x2 me-3"></i> Dashboard
        </a>
        <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center <?= $this->uri->segment(1) == 'transaksi' ? 'active text-white' : 'text-dark' ?>" href="<?= base_url('transaksi') ?>">
            <i class="bi bi-wallet2 me-3"></i> Transaksi
        </a>
        <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center <?= $this->uri->segment(1) == 'kategori' ? 'active text-white' : 'text-dark' ?>" href="<?= base_url('kategori') ?>">
            <i class="bi bi-tags me-3"></i> Kategori
        </a>
         <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center <?= $this->uri->segment(1) == 'anggaran' ? 'active text-white' : 'text-dark' ?>" href="<?= base_url('anggaran') ?>">
            <i class="bi bi-pie-chart me-3"></i> Anggaran
        </a>
    </div>

    <div class="p-3 border-top">
        <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center  text-danger fw-bold px-3" href="<?= base_url('auth/logout') ?>">
            <i class="bi bi-box-arrow-right me-3"></i> Logout
        </a>
    </div>
</div>

<div class="flex-grow-1 main-content">
    <div class="topbar d-flex align-items-center justify-content-between">
        <button class="btn d-lg-none p-0" onclick="toggleSidebar()">
            <i class="bi bi-list fs-2 text-dark"></i>
        </button>
        <div class="fw-semibold text-muted">Ringkasan Keuangan</div>
    </div>