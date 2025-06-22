<!DOCTYPE html>

<?php
include_once 'config.php';

$result = mysqli_query($connection, "SELECT m.name_menu AS 'Menu',
                        m.type_menu AS 'Type',
                        SUM(od.quantity) AS 'Qty'
                        FROM order_detail od
                        RIGHT JOIN menu m ON od.no_menu = m.no_menu
                        GROUP BY m.name_menu, m.type_menu
                        ORDER BY Qty DESC, m.type_menu ASC, m.name_menu ASC");

$jumlah = 1;

$cust = mysqli_query($connection, "SELECT c.name_customer AS 'Customer',
                        c.phone AS 'Phone',
                        SUM(o.total_price) AS 'Total'
                        FROM customer c
                        INNER JOIN `order` o ON c.no_customer = o.no_customer
                        GROUP BY c.name_customer, c.phone
                        ORDER BY Total DESC, c.name_customer ASC");
$jumlah_cust = 1;
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>Statistic</title>
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
        <h2 class="fw-bold">Statistics</h2>
        <p>Here you can find the statistics of our restaurant's performance.</p>
    </div>

    <div class="container py-4">
    <h3>Best Selling Menu Data</h3>
    <table class="table table-bordered table-striped align-middle" id="statsTable">
        <thead class="table-primary">
            <tr>
                <th>Rank</th>
                <th>Item</th>
                <th>Type</th>
                <th>Sold</th>
            </tr>
        </thead>
        <tbody>
                <?php
                        while ($list_menu = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>";
                            if ($jumlah == 1) {
                                echo "<span class=\"badge bg-warning text-dark\">🏆 1st</span>";
                            } elseif ($jumlah == 2) {
                                echo "<span class=\"badge bg-secondary\">🥈 2nd</span>";
                            } elseif ($jumlah == 3) {
                                echo "<span class=\"badge bg-dark\">🥉 3rd</span>";
                            } else {
                                echo $jumlah;
                            }
                            $jumlah++;
                            echo "</td>";  
                            echo "<td>" . $list_menu['Menu'] . "</td>";
                            echo "<td>";
                            if ($list_menu['Type'] == 'appetizer') {
                                echo "<span class=\"badge rounded-pill text-bg-primary\">Appetizer</span>";
                            } elseif ($list_menu['Type'] == 'main_course') {
                                echo "<span class=\"badge rounded-pill text-bg-success\">Main Course</span>";
                            } elseif ($list_menu['Type'] == 'dessert') {
                                echo "<span class=\"badge rounded-pill text-bg-warning\">Dessert</span>";
                            }
                            echo "</td>";
                            echo "<td>";
                            if ($list_menu['Qty'] == null) {
                                echo "0";
                            } else {
                                echo $list_menu['Qty'] ;
                            }
                            "</td>"; 
                            echo "</tr>";
                        }  
                ?>
        </tbody>
    </table>
</div>

<div class="container py-4">
    <h3>Top Customers Data</h3>
    <table class="table table-bordered table-striped align-middle" id="statsTable">
        <thead class="table-primary">
            <tr>
                <th>Rank</th>
                <th>Customer Name</th>
                <th>Phone</th>
                <th>Total Spent</th>
            </tr>
        </thead>
        <tbody>
                <?php
                        while ($list_menu = mysqli_fetch_array($cust)) {
                            echo "<tr>";
                            echo "<td>";
                            if ($jumlah_cust == 1) {
                                echo "<span class=\"badge bg-warning text-dark\">🏆 1st</span>";
                            } elseif ($jumlah_cust == 2) {
                                echo "<span class=\"badge bg-secondary\">🥈 2nd</span>";
                            } elseif ($jumlah_cust == 3) {
                                echo "<span class=\"badge bg-dark\">🥉 3rd</span>";
                            } else {
                                echo $jumlah_cust;
                            }
                            $jumlah_cust++;
                            echo "</td>";
                            echo "<td>" . $list_menu['Customer'] . "</td>";
                            echo "<td>" . $list_menu['Phone'] . "</td>";
                            echo "<td><strong>Rp " . number_format($list_menu['Total'], 0, ',', '.') . "</strong></td>";
                            echo "</tr>";
                        }  
                ?>
        </tbody>
    </table>
</div>

    <div class="container text-center" style="padding-bottom: 40px; ">
    <div class="d-grid ">
        <a href="data.php" class="btn btn-primary">See Another Data</a>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>