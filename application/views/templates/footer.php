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