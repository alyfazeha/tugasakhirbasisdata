<?php
require_once 'config.php';

// Mendapatkan data laporan
$dailySales = getDailySalesReport($pdo);
$customerOrderDetails = getCustomerOrderDetails($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Reports - nyam.nyam</title>
</head>
<body>
    <nav class="navbar navbar-expand-lg bg-body-tertiary sticky-top" data-bs-theme="dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center p-0" href="index.php" style="font-weight: bold;">
                <img src="img/lightlogo.png" alt="logo" style="height: 70px; margin-right: 10px;">
                nyam.nyam
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav mb-2 mb-lg-0 ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stat.php">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#footer">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="justify-content-center text-center py-5" style="margin-bottom: -3%;">
        <h2 class="fw-bold">Sales Reports</h2>
        <p>Comprehensive reports showing daily sales and customer order details.</p>
    </div>

    <div class="container py-4">
        <!-- Daily Sales Report -->
        <div class="row mb-5">
            <div class="col-12">
                <h4 class="mb-3">Daily Sales Report</h4>
                <p class="text-muted">Data menggunakan <strong>INNER JOIN</strong>, <strong>COUNT()</strong>, <strong>SUM()</strong>, <strong>GROUP BY</strong>, dan <strong>ORDER BY DESC</strong></p>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Date</th>
                                <th>Total Orders</th>
                                <th>Total Revenue</th>
                                <th>Payment Methods Used</th>
                                <th>Avg Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($dailySales as $sale): ?>
                                <?php $avgOrderValue = $sale['total_revenue'] / $sale['total_orders']; ?>
                                <tr>
                                    <td>
                                        <strong><?= date('d M Y', strtotime($sale['date'])) ?></strong><br>
                                        <small class="text-muted"><?= date('l', strtotime($sale['date'])) ?></small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info fs-6"><?= $sale['total_orders'] ?></span>
                                        <small class="text-muted">orders</small>
                                    </td>
                                    <td>
                                        <strong class="text-success">Rp <?= $sale['formatted_revenue'] ?></strong>
                                    </td>
                                    <td>
                                        <?php 
                                        $methods = explode(', ', $sale['payment_methods']);
                                        foreach ($methods as $method): 
                                        ?>
                                            <span class="badge bg-secondary me-1"><?= ucfirst(str_replace('_', ' ', $method)) ?></span>
                                        <?php endforeach; ?>
                                    </td>
                                    <td>
                                        <small>Rp <?= number_format($avgOrderValue, 0, ',', '.') ?></small>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Daily Sales Summary -->
                <div class="row mt-4">
                    <?php 
                    $totalOrders = array_sum(array_column($dailySales, 'total_orders'));
                    $totalRevenue = array_sum(array_column($dailySales, 'total_revenue'));
                    $avgDailyRevenue = $totalRevenue / count($dailySales);
                    ?>
                    <div class="col-md-3">
                        <div class="card text-center bg-primary text-white">
                            <div class="card-body">
                                <h6>Total Days</h6>
                                <h4><?= count($dailySales) ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center bg-success text-white">
                            <div class="card-body">
                                <h6>Total Orders</h6>
                                <h4><?= $totalOrders ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center bg-info text-white">
                            <div class="card-body">
                                <h6>Total Revenue</h6>
                                <h6>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center bg-warning text-dark">
                            <div class="card-body">
                                <h6>Avg Daily Revenue</h6>
                                <h6>Rp <?= number_format($avgDailyRevenue, 0, ',', '.') ?></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Order Details -->
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Customer Order Details</h4>
                <p class="text-muted">Data menggunakan <strong>Multiple INNER JOIN</strong> (4 tabel), <strong>ORDER BY</strong>, dan kalkulasi harga</p>
                
                <!-- Filter Controls -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <input type="text" id="customerSearch" class="form-control" placeholder="Search by customer name..." />
                    </div>
                    <div class="col-md-6">
                        <select id="menuTypeFilter" class="form-select">
                            <option value="">All Menu Types</option>
                            <option value="appetizer">Appetizer</option>
                            <option value="main_course">Main Course</option>
                            <option value="dessert">Dessert</option>
                        </select>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="orderDetailsTable">
                        <thead class="table-success">
                            <tr>
                                <th>Customer</th>
                                <th>Phone</th>
                                <th>Order #</th>
                                <th>Date</th>
                                <th>Menu Item</th>
                                <th>Type</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customerOrderDetails as $detail): ?>
                                <tr>
                                    <td><strong><?= htmlspecialchars($detail['name_customer']) ?></strong></td>
                                    <td><?= htmlspecialchars($detail['phone']) ?></td>
                                    <td>
                                        <span class="badge bg-primary">#<?= $detail['no_order'] ?></span>
                                    </td>
                                    <td>
                                        <small><?= date('d/m/Y', strtotime($detail['date_order'])) ?></small>
                                    </td>
                                    <td><?= htmlspecialchars($detail['name_menu']) ?></td>
                                    <td>
                                        <span class="badge <?= 
                                            $detail['type_menu'] === 'appetizer' ? 'bg-success' : 
                                            ($detail['type_menu'] === 'main_course' ? 'bg-primary' : 'bg-warning text-dark') 
                                        ?>">
                                            <?= ucfirst(str_replace('_', ' ', $detail['type_menu'])) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-info"><?= $detail['quantity'] ?></span>
                                    </td>
                                    <td>Rp <?= number_format($detail['price'], 0, ',', '.') ?></td>
                                    <td><strong>Rp <?= $detail['formatted_subtotal'] ?></strong></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Order Details Summary -->
                <div class="row mt-4">
                    <?php 
                    $totalOrderItems = count($customerOrderDetails);
                    $totalQuantity = array_sum(array_column($customerOrderDetails, 'quantity'));
                    $totalSubtotal = array_sum(array_column($customerOrderDetails, 'subtotal'));
                    $uniqueCustomers = count(array_unique(array_column($customerOrderDetails, 'name_customer')));
                    ?>
                    <div class="col-md-3">
                        <div class="card text-center bg-secondary text-white">
                            <div class="card-body">
                                <h6>Total Order Items</h6>
                                <h4><?= $totalOrderItems ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center bg-primary text-white">
                            <div class="card-body">
                                <h6>Total Quantity</h6>
                                <h4><?= $totalQuantity ?></h4>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center bg-success text-white">
                            <div class="card-body">
                                <h6>Total Value</h6>
                                <h6>Rp <?= number_format($totalSubtotal, 0, ',', '.') ?></h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card text-center bg-info text-white">
                            <div class="card-body">
                                <h6>Unique Customers</h6>
                                <h4><?= $uniqueCustomers ?></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search and filter functionality
        document.getElementById('customerSearch').addEventListener('keyup', filterTable);
        document.getElementById('menuTypeFilter').addEventListener('change', filterTable);
        
        function filterTable() {
            const searchText = document.getElementById('customerSearch').value.toLowerCase();
            const typeFilter = document.getElementById('menuTypeFilter').value.toLowerCase();
            const tableRows = document.querySelectorAll('#orderDetailsTable tbody tr');
            
            tableRows.forEach(row => {
                const customerName = row.cells[0].textContent.toLowerCase();
                const menuType = row.cells[5].textContent.toLowerCase();
                
                const matchesSearch = customerName.includes(searchText);
                const matchesType = typeFilter === '' || menuType.includes(typeFilter.replace('_', ' '));
                
                if (matchesSearch && matchesType) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>