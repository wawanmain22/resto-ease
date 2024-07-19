<?php
$current_page = basename($_SERVER['PHP_SELF']);
$user_jabatan = $_SESSION['user_jabatan']; // Pastikan variabel ini diambil dari session login
?>

<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.php"> <img alt="image" src="assets/img/logo.png" class="header-logo" /> <span
                    class="logo-name">RestoEase</span></a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Main</li>
            <li class="dropdown <?= $current_page == 'dashboard.php' ? 'active' : '' ?>">
                <a href="dashboard.php" class="nav-link"><i data-feather="monitor"></i><span>Dashboard</span></a>
            </li>
            <?php if ($user_jabatan == 'Owner' || $user_jabatan == 'Koki' || $user_jabatan == 'Kasir' || $user_jabatan == 'Pelayan'): ?>
                <li class="menu-header">Management</li>
            <?php endif; ?>
            <?php if ($user_jabatan == 'Owner' || $user_jabatan == 'Kasir'): ?>
                <li class="dropdown <?= $current_page == 'pemesanan.php' ? 'active' : '' ?>">
                    <a href="pemesanan.php" class="nav-link"><i data-feather="shopping-cart"></i><span>Pemesanan</span></a>
                </li>
            <?php endif; ?>
            <?php if ($user_jabatan == 'Owner' || $user_jabatan == 'Koki'): ?>
                <li class="dropdown <?= $current_page == 'menu.php' ? 'active' : '' ?>">
                    <a href="menu.php" class="nav-link"><i data-feather="grid"></i><span>Menu</span></a>
                </li>
            <?php endif; ?>
            <?php if ($user_jabatan == 'Owner' || $user_jabatan == 'Kasir' || $user_jabatan == 'Pelayan'): ?>
                <li class="dropdown <?= $current_page == 'transaksi.php' ? 'active' : '' ?>">
                    <a href="transaksi.php" class="nav-link"><i data-feather="dollar-sign"></i><span>Transaksi</span></a>
                </li>
            <?php endif; ?>
            <?php if ($user_jabatan == 'Owner'): ?>
                <li class="dropdown <?= $current_page == 'user.php' ? 'active' : '' ?>">
                    <a href="user.php" class="nav-link"><i data-feather="users"></i><span>User</span></a>
                </li>
            <?php endif; ?>
        </ul>
    </aside>
</div>