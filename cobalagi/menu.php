<!DOCTYPE html>

<?php
include_once 'config.php';

$result = mysqli_query($connection, "SELECT * FROM menu");
$jumlah = 1;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Menu</title>
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
                        <a class="nav-link" href="index.php#footer">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <div class="justify-content-center text-center py-5" style="margin-bottom: -5%;">
        <h2 class="fw-bold">Menu</h2>
        <p>Explore our delicious menu below and find your favorite dishes!</p>
    </div>

    <div class="justify-content-center text-center py-5" style="margin-bottom: -5%;">  
        <div class="btn-group" role="group" aria-label="Basic outlined example">
            <button type="button" class="btn btn-outline-primary"><a href="menu.php">All Menu</a></button>
            <button type="button" class="btn btn-outline-primary"><a href="appetizer.php">Appetizer</a></button>
            <button type="button" class="btn btn-outline-primary"><a href="maincourse.php">Main Course</a></button>
            <button type="button" class="btn btn-outline-primary"><a href="dessert.php">Dessert</a></button>
        </div>
    </div>

    <div class="container my-5">
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name Menu</th>
                        <th scope="col">Type Menu</th>
                        <th scope="col">Price</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        while ($list_menu = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $jumlah . "</td>";
                            $jumlah++;
                            echo "<td>" . $list_menu['name_menu'] . "</td>";
                            echo "<td>";
                            if ($list_menu['type_menu'] == 'appetizer') {
                                echo "<span class=\"badge rounded-pill text-bg-primary\">Appetizer</span>";
                            } elseif ($list_menu['type_menu'] == 'main_course') {
                                echo "<span class=\"badge rounded-pill text-bg-success\">Main Course</span>";
                            } elseif ($list_menu['type_menu'] == 'dessert') {
                                echo "<span class=\"badge rounded-pill text-bg-warning\">Dessert</span>";
                            }
                            echo "</td>";
                            echo "<td><strong>Rp " . number_format($list_menu['price'], 0, ',', '.') . "</strong></td>";
                            echo "<td>";
                            echo "<a href='edit.php?no_menu=" . $list_menu['no_menu'] . "' class='btn btn-warning btn-sm'>Edit</a> ";
                            echo "<a href='delete.php?no_menu=" . $list_menu['no_menu'] . "' class='btn btn-danger btn-sm'>Delete</a>";
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container text-center" style="padding-bottom: 40px; ">
        <div class="row">
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Total Menu</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">
                            <?php
                            $total_menu = mysqli_query($connection, "SELECT COUNT(no_menu) AS total FROM menu");
                            $total_menu = mysqli_fetch_assoc($total_menu)['total'];
                            echo $total_menu;
                            ?>
                        </h6>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card" >
                    <div class="card-body">
                        <h5 class="card-title">Average Price</h5>
                        <h6 class="card-subtitle mb-2 text-body-secondary">
                            <?php
                            $average_price = mysqli_query($connection, "SELECT AVG(price) AS average FROM menu");
                            $average_price = mysqli_fetch_assoc($average_price)['average'];
                            echo "Rp " . number_format($average_price, 0, ',', '.');
                            ?>
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container text-center" style="padding-bottom: 40px; ">
    <div class="d-grid ">
        <a href="add.php" class="btn btn-primary">Add Menu</a>
    </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>