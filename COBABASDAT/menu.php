<?php
require_once 'config.php';

// Mendapatkan kategori dari parameter GET
$category = isset($_GET['category']) ? $_GET['category'] : '';
$menus = getMenuByCategory($pdo, $category);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Menu - nyam.nyam</title>
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
                        <a class="nav-link active" href="menu.php">Menu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="stat.php">Statistics</a>
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
        <h2 class="fw-bold">Menu</h2>
        <p>Explore our delicious menu below and find your favorite dishes!</p>
    </div>

    <!-- Filter Kategori -->
    <div class="container mb-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="btn-group w-100" role="group">
                    <a href="menu.php" class="btn <?= empty($category) ? 'btn-primary' : 'btn-outline-primary' ?>">All</a>
                    <a href="menu.php?category=appetizer" class="btn <?= $category === 'appetizer' ? 'btn-primary' : 'btn-outline-primary' ?>">Appetizer</a>
                    <a href="menu.php?category=main_course" class="btn <?= $category === 'main_course' ? 'btn-primary' : 'btn-outline-primary' ?>">Main Course</a>
                    <a href="menu.php?category=dessert" class="btn <?= $category === 'dessert' ? 'btn-primary' : 'btn-outline-primary' ?>">Dessert</a>
                </div>
            </div>
        </div>
    </div>

    <div class="container my-5">
        <div class="row">
            <div class="col-12">
                <?php if (!empty($category)): ?>
                    <h4 class="mb-3">
                        Category: <span class="badge bg-primary"><?= ucfirst(str_replace('_', ' ', $category)) ?></span>
                        <small class="text-muted">(<?= count($menus) ?> items)</small>
                    </h4>
                <?php endif; ?>
                
                <div class="table-responsive">
                    <table class="table table-bordered table-striped align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th scope="col">No</th>
                                <th scope="col">Menu Type</th>
                                <th scope="col">Menu Name</th>
                                <th scope="col">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($menus)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No menu items found.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($menus as $index => $menu): ?>
                                    <tr>
                                        <td><?= $index + 1 ?></td>
                                        <td>
                                            <span class="badge <?= 
                                                $menu['type_menu'] === 'appetizer' ? 'bg-success' : 
                                                ($menu['type_menu'] === 'main_course' ? 'bg-primary' : 'bg-warning text-dark') 
                                            ?>">
                                                <?= ucfirst(str_replace('_', ' ', $menu['type_menu'])) ?>
                                            </span>
                                        </td>
                                        <td><?= htmlspecialchars($menu['name_menu']) ?></td>
                                        <td><strong>Rp <?= $menu['formatted_price'] ?></strong></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Summary Statistics -->
                <div class="mt-4">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Total Items</h5>
                                    <h3 class="text-primary"><?= count($menus) ?></h3>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Price Range</h5>
                                    <?php if (!empty($menus)): ?>
                                        <?php 
                                        $prices = array_column($menus, 'price');
                                        $minPrice = min($prices);
                                        $maxPrice = max($prices);
                                        ?>
                                        <h6 class="text-success">Rp <?= number_format($minPrice, 0, ',', '.') ?> - Rp <?= number_format($maxPrice, 0, ',', '.') ?></h6>
                                    <?php else: ?>
                                        <h6 class="text-muted">-</h6>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card text-center">
                                <div class="card-body">
                                    <h5 class="card-title">Avg Price</h5>
                                    <?php if (!empty($menus)): ?>
                                        <?php 
                                        $avgPrice = array_sum(array_column($menus, 'price')) / count($menus);
                                        ?>
                                        <h6 class="text-info">Rp <?= number_format($avgPrice, 0, ',', '.') ?></h6>
                                    <?php else: ?>
                                        <h6 class="text-muted">-</h6>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
</body>
</html>