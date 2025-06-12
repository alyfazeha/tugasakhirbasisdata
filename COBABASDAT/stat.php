<?php
require_once 'config.php';

// Mendapatkan statistik menu
$menuStats = getMenuStatistics($pdo);
$topCustomers = getTopCustomers($pdo);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Statistics - nyam.nyam</title>
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
                        <a class="nav-link active" href="stat.php">Statistics</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="reports.php">Reports</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="index.php#footer">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="justify-content-center text-center py-5" style="margin-bottom: -3%;">
        <h2 class="fw-bold">Statistics</h2>
        <p>Here you can find the statistics of our restaurant's performance.</p>
    </div>

    <div class="container py-4">
        <!-- Menu Performance Statistics -->
        <div class="row mb-5">
            <div class="col-12">
                <h4 class="mb-3">Menu Performance Statistics</h4>
                <p class="text-muted">Data menggunakan <strong>LEFT JOIN</strong>, <strong>SUM()</strong>, <strong>AVG()</strong>, dan <strong>ORDER BY</strong></p>
                
                <input type="text" id="searchInput" class="form-control mb-3" placeholder="Search by item name..." />

                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="statsTable">
                        <thead class="table-primary">
                            <tr>
                                <th>Rank</th>
                                <th>Item</th>
                                <th>Sold</th>
                                <th>Rating</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($menuStats as $index => $stat): ?>
                                <tr>
                                    <td>
                                        <?php if ($index === 0): ?>
                                            <span class="badge bg-warning text-dark">🏆 #1</span>
                                        <?php elseif ($index === 1): ?>
                                            <span class="badge bg-secondary">🥈 #2</span>
                                        <?php elseif ($index === 2): ?>
                                            <span class="badge bg-warning">🥉 #3</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">#<?= $index + 1 ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($stat['item']) ?></td>
                                    <td>
                                        <strong><?= $stat['sold'] ?></strong>
                                        <?php if ($stat['sold'] > 0): ?>
                                            <small class="text-success">units</small>
                                        <?php else: ?>
                                            <small class="text-muted">no sales</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $stat['rating'] >= 4.5 ? 'bg-success' : ($stat['rating'] >= 4.0 ? 'bg-primary' : 'bg-secondary') ?>">
                                            ⭐ <?= $stat['rating'] ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if ($stat['sold'] >= 50): ?>
                                            <span class="badge bg-success">Popular</span>
                                        <?php elseif ($stat['sold'] >= 20): ?>
                                            <span class="badge bg-primary">Good</span>
                                        <?php elseif ($stat['sold'] > 0): ?>
                                            <span class="badge bg-warning text-dark">New</span>
                                        <?php else: ?>
                                            <span class="badge bg-secondary">No Sales</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="row mb-5">
            <div class="col-md-3">
                <div class="card text-center bg-primary text-white">
                    <div class="card-body">
                        <h5>Total Menu Items</h5>
                        <h3><?= count($menuStats) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-success text-white">
                    <div class="card-body">
                        <h5>Total Items Sold</h5>
                        <h3><?= array_sum(array_column($menuStats, 'sold')) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-info text-white">
                    <div class="card-body">
                        <h5>Average Rating</h5>
                        <h3><?= round(array_sum(array_column($menuStats, 'rating')) / count($menuStats), 1) ?></h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card text-center bg-warning text-dark">
                    <div class="card-body">
                        <h5>Best Seller</h5>
                        <h6><?= !empty($menuStats) ? $menuStats[0]['item'] : 'N/A' ?></h6>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Customers -->
        <div class="row">
            <div class="col-12">
                <h4 class="mb-3">Top Customers</h4>
                <p class="text-muted">Data menggunakan <strong>INNER JOIN</strong>, <strong>COUNT()</strong>, <strong>SUM()</strong>, dan <strong>AVG()</strong></p>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-success">
                            <tr>
                                <th>Rank</th>
                                <th>Customer Name</th>
                                <th>Phone</th>
                                <th>Total Orders</th>
                                <th>Total Spent</th>
                                <th>Avg Order Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($topCustomers as $index => $customer): ?>
                                <tr>
                                    <td>
                                        <?php if ($index === 0): ?>
                                            <span class="badge bg-warning text-dark">👑 VIP</span>
                                        <?php elseif ($index === 1): ?>
                                            <span class="badge bg-success">🌟 Gold</span>
                                        <?php elseif ($index === 2): ?>
                                            <span class="badge bg-primary">💎 Silver</span>
                                        <?php else: ?>
                                            <span class="badge bg-light text-dark">#<?= $index + 1 ?></span>
                                        <?php endif; ?>
                                    </td>
                                    <td><strong><?= htmlspecialchars($customer['name_customer']) ?></strong></td>
                                    <td><?= htmlspecialchars($customer['phone']) ?></td>
                                    <td>
                                        <span class="badge bg-info"><?= $customer['total_orders'] ?> orders</span>
                                    </td>
                                    <td><strong>Rp <?= $customer['formatted_total'] ?></strong></td>
                                    <td>Rp <?= $customer['formatted_avg'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Search functionality
        document.getElementById('searchInput').addEventListener('keyup', function() {
            const searchText = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#statsTable tbody tr');
            
            tableRows.forEach(row => {
                const itemName = row.cells[1].textContent.toLowerCase();
                if (itemName.includes(searchText)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>