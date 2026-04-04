<script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('show');
            if (window.innerWidth < 992) {
                document.body.classList.toggle('sidebar-open');
            }
        }
        
        // Klik di luar sidebar untuk menutup di mobile
        document.addEventListener('click', function(e) {
            const sidebar = document.getElementById('sidebar');
            const btn = e.target.closest('.d-lg-none');
            if (window.innerWidth < 992 && sidebar.classList.contains('show') && !sidebar.contains(e.target) && !btn) {
                toggleSidebar();
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<style>
    .btn-outline-primary,
    .btn-outline-success,
    .btn-outline-danger,
    .btn-outline-warning {
        background-color: transparent !important;
        border-width: 1.5px !important;
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

<script>
    function updateNavbarClock() {
        const clockElement = document.getElementById('realtime-clock');
        if (!clockElement) return; // Proteksi jika elemen tidak ditemukan

        const now = new Date();
        
        // Cek apakah tampilan mobile atau desktop untuk penyesuaian format
        const isMobile = window.innerWidth < 576;
        
        // Pengaturan format tanggal (Contoh: 04 Apr 2026)
        const dateOptions = isMobile 
            ? { day: '2-digit', month: 'short' } 
            : { day: '2-digit', month: 'long', year: 'numeric' };
        
        const tanggal = now.toLocaleDateString('id-ID', dateOptions);
        
        // Pengaturan format waktu (HH:mm:ss)
        const jam = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        const detik = String(now.getSeconds()).padStart(2, '0');
        
        const separator = isMobile ? ' ' : ' | ';
        
        // Update isi span dengan data baru
        clockElement.textContent = `${tanggal}${separator}${jam}:${menit}:${detik}`;
    }

    // Jalankan fungsi setiap 1 detik (1000ms)
    setInterval(updateNavbarClock, 1000);

    // Panggil sekali di awal agar tidak menunggu 1 detik pertama (biar tidak "Memuat..." kelamaan)
    updateNavbarClock();

    // Opsional: Update ulang jika user resize layar (untuk switch format mobile/desktop)
    window.addEventListener('resize', updateNavbarClock);
</script>