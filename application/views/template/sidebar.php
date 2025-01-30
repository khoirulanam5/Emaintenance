<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items justify-content-center" href="">
                <div class="sidebar-brand-text ml-1"><li class="fa fa-cogs"></li> CV. Mandiri Mulya</div>
            </a>

            <hr class="sidebar-divider my-0">
            
            <a class="sidebar-brand d-flex align-items justify-content-center" href="">
                <small><?= $this->session->userdata('role'); ?> (<?= $this->session->userdata('nama'); ?>)</small>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?= ($this->uri->segment(1) == 'dashboard') ? 'active' : '' ?>">
                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <?php if($this->session->userdata('role') == 'admin maintenance'): ?>
                <li class="nav-item <?= ($this->uri->segment(2) == 'datateknisi') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/datateknisi') ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data Teknisi</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'datasupir') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/datasupir') ?>">
                        <i class="fas fa-fw fa-users"></i>
                        <span>Data Supir</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'datakendaraan') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/datakendaraan') ?>">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>Data Kendaraan</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'dataaset') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/dataaset') ?>">
                        <i class="fas fa-fw fa-clipboard-list"></i>
                        <span>Data Aset Kendaraan</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'service') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/service') ?>">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Kendaraan Service</span>
                    </a>
                </li>
                <li class="nav-item <?= ($this->uri->segment(2) == 'riwayatservice') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('admin/riwayatservice') ?>">
                        <i class="fas fa-fw fa-list"></i>
                        <span>Riwayat Service</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if($this->session->userdata('role') == 'teknisi'): ?>
                <li class="nav-item <?= ($this->uri->segment(2) == 'service') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('teknisi/service') ?>">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Service Kendaraan</span>
                    </a>
                </li>
            <?php endif; ?>

            <?php if($this->session->userdata('role') == 'supir'): ?>
                <li class="nav-item <?= ($this->uri->segment(2) == 'service') ? 'active' : '' ?>">
                    <a class="nav-link" href="<?= base_url('supir/service') ?>">
                        <i class="fas fa-fw fa-cogs"></i>
                        <span>Service Kendaraan</span>
                    </a>
                </li>
            <?php endif; ?>

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <div class="navbar">

                            <div class="topbar-divider d-none d-sm-block"></div>

                            <ul class="nav navbar-nav navbar-right">

                                <a class="btn btn-primary btn-sm logout" href="<?= base_url('auth/logout') ?>">Logout</a>

                            </ul>

                        </div>
                    </ul>

                </nav>

                <script>
                document.querySelectorAll('.logout').forEach(item => {
                        item.addEventListener('click', function(e) {
                            e.preventDefault(); // Mencegah link agar tidak langsung dijalankan
                            var url = this.getAttribute('href'); // Ambil URL dari atribut href
                            Swal.fire({
                                title: "Yakin ingin keluar?",
                                text: "",
                                icon: "warning",
                                showCancelButton: true,
                                confirmButtonColor: "#3085d6",
                                cancelButtonColor: "#d33",
                                confirmButtonText: "Keluar"
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Jika konfirmasi, redirect ke URL penghapusan
                                    window.location.href = url;
                                }
                            });
                        });
                    });
                </script>