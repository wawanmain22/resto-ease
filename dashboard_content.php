<?php
include ('proses/proses_connect_database.php');

// Fetch total orders
$sql_orders = "SELECT COUNT(*) as total_orders FROM Pemesanan";
$result_orders = $conn->query($sql_orders);
$total_orders = $result_orders->fetch_assoc()['total_orders'];
$total_orders = $total_orders ?? 0; // Check for null value

// Fetch total customers
$sql_customers = "SELECT COUNT(DISTINCT nama_pemesan) as total_customers FROM Pemesanan";
$result_customers = $conn->query($sql_customers);
$total_customers = $result_customers->fetch_assoc()['total_customers'];
$total_customers = $total_customers ?? 0; // Check for null value

// Fetch daily revenue
$sql_daily_revenue = "SELECT SUM(total_bayar) as daily_revenue FROM Pemesanan WHERE DATE(tgl_pesan) = CURDATE()";
$result_daily_revenue = $conn->query($sql_daily_revenue);
$daily_revenue = $result_daily_revenue->fetch_assoc()['daily_revenue'];
$daily_revenue = $daily_revenue ?? 0; // Check for null value

// Fetch top menu items
$sql_top_menu = "SELECT Menu.nama, SUM(Detail_Pesanan.jumlah) as total FROM Detail_Pesanan JOIN Menu ON Detail_Pesanan.id_menu = Menu.id GROUP BY Menu.nama ORDER BY total DESC LIMIT 1";
$result_top_menu = $conn->query($sql_top_menu);
$top_menu = $result_top_menu->fetch_assoc();
$top_menu_name = $top_menu['nama'] ?? 'No data'; // Check for null value
$top_menu_total = $top_menu['total'] ?? 0; // Check for null value

// Fetch total revenue
$sql_total_revenue = "SELECT SUM(total_bayar) as total_revenue FROM Pemesanan";
$result_total_revenue = $conn->query($sql_total_revenue);
$total_revenue = $result_total_revenue->fetch_assoc()['total_revenue'];
$total_revenue = $total_revenue ?? 0; // Check for null value
?>

<div class="row">
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Orders</h5>
                                <h2 class="mb-3 font-18"><?= $total_orders ?></h2>
                                <p class="mb-0"><span class="col-green">All time</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="assets/img/banner/1.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Customers</h5>
                                <h2 class="mb-3 font-18"><?= $total_customers ?></h2>
                                <p class="mb-0"><span class="col-orange">Unique customers</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="assets/img/banner/2.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Daily Revenue</h5>
                                <h2 class="mb-3 font-18">RP. <?= number_format($daily_revenue, 0, ',', '.') ?></h2>
                                <p class="mb-0"><span class="col-green">Today</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="assets/img/banner/3.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Top Menu Item</h5>
                                <h2 class="mb-3 font-18"><?= $top_menu_name ?></h2>
                                <p class="mb-0"><span class="col-green"><?= $top_menu_total ?> orders</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="assets/img/banner/4.png" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
        <div class="card">
            <div class="card-statistic-4">
                <div class="align-items-center justify-content-between">
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                            <div class="card-content">
                                <h5 class="font-15">Total Revenue</h5>
                                <h2 class="mb-3 font-18">RP. <?= number_format($total_revenue, 0, ',', '.') ?></h2>
                                <p class="mb-0"><span class="col-green">All time</span></p>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                            <div class="banner-img">
                                <img src="" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>