<div class="sidebar d-flex flex-column" id="sidebar">
    <div class="brand p-4 text-center border-bottom">
        <h4 class="fw-bold mb-0" style="color: #5f60ff">FinanceApp</h4>
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

        <?php if ($this->session->userdata('user_id') == 1) :
            $m_status = $this->db->get_where('settings', ['key' => 'maintenance_mode'])->row()->value;
            $is_on = ($m_status == 'on');
        ?>
            <div class="my-3 mx-3 border-bottom opacity-100"></div>
            <small class="text-muted px-3 mb-2 d-block" style="font-size: 10px; letter-spacing: 1px;">LAYANAN</small>

            <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center <?= $this->uri->segment(1) == 'listrik' ? 'active text-white' : 'text-dark' ?>" href="<?= base_url('listrik') ?>">
                <i class="bi bi-lightning-charge me-3"></i> Listrik
            </a>
            <div class="my-3 mx-3 border-bottom opacity-100"></div>
            <small class="text-muted px-3 mb-2 d-block" style="font-size: 10px; letter-spacing: 1px;">KONTROL SISTEM</small>

            <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center <?= $this->uri->segment(1) == 'users' ? 'active text-white' : 'text-dark' ?>" href="<?= base_url('users') ?>">
                <i class="bi bi-people me-3"></i> Manajemen Users
            </a>

            <div class="px-0 mb-2">
                <a href="<?= base_url('users/toggle_maintenance') ?>" class="nav-link py-2 px-3 rounded-3 d-flex align-items-center justify-content-between <?= $is_on ? 'bg-danger text-white' : 'text-dark border' ?>" style="transition: 0.3s; font-size: 13px;">
                    <span>
                        <i class="bi <?= $is_on ? 'bi-toggle-on' : 'bi-toggle-off' ?> me-2"></i>
                        Maintenance
                    </span>
                    <span class="badge <?= $is_on ? 'bg-white text-danger' : 'bg-secondary' ?> rounded-pill" style="font-size: 9px;">
                        <?= strtoupper($m_status) ?>
                    </span>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <div class="p-3 border-top">
        <a class="nav-link mb-2 py-2 px-3 rounded-3 d-flex align-items-center text-danger fw-bold px-3" href="<?= base_url('auth/logout') ?>">
            <i class="bi bi-box-arrow-right me-3"></i> Logout
        </a>
    </div>
</div>

<div class="flex-grow-1 main-content">
    <div class="topbar d-flex align-items-center justify-content-between px-3 px-md-4 py-3 bg-white border-bottom shadow-sm">
        <div class="d-flex align-items-center flex-grow-1">
            <button class="btn d-lg-none p-0 me-3" onclick="toggleSidebar()">
                <i class="bi bi-list fs-2 text-dark"></i>
            </button>

            <div class="clock-wrapper d-flex align-items-center bg-light px-2 px-md-3 py-1 rounded-pill border shadow-sm">
                <i class="bi bi-clock-fill text-primary me-2 d-none d-sm-inline" style="font-size: 12px;"></i>
                <span id="realtime-clock" class="fw-bold text-dark" style="font-size: 10px; min-width: 110px; font-family: 'Poppins', sans-serif;">
                    Memuat...
                </span>
            </div>
        </div>

        <a href="<?= base_url('profile') ?>" class="text-decoration-none d-flex align-items-center gap-2 ms-2">
            <div class="text-end d-none d-md-block">
                <div class="fw-bold text-dark small mb-0"><?= $this->session->userdata('user_name') ?></div>
                <small class="text-muted" style="font-size: 10px;">Pengguna Aktif</small>
            </div>
            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" style="width: 38px; height: 38px; font-size: 14px;">
                <?php
                $name = $this->session->userdata('user_name');
                $words = explode(" ", $name);
                echo strtoupper(substr($words[0], 0, 1) . (isset($words[1]) ? substr($words[1], 0, 1) : ''));
                ?>
            </div>
        </a>
    </div>