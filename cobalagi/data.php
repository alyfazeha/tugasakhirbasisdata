<!DOCTYPE html>

<?php
include_once 'config.php';

$result = mysqli_query($connection, "SELECT * FROM customer");
$jumlah = 1;

$transaction = mysqli_query($connection, "SELECT 
                            t.no_transaction AS 'Transaction Number',
                            t.date AS 'Date',
                            t.time AS 'Time',
                            c.name_customer AS 'Customer Name',
                            GROUP_CONCAT(CONCAT(m.name_menu, ' (x', od.quantity, ')') SEPARATOR ', ') AS 'Menus',
                            t.payment_method AS 'Payment Method',
                            t.total_bayar AS 'Total Price'
                            FROM transaction t
                            INNER JOIN `order` o ON t.no_order = o.no_order
                            INNER JOIN customer c ON o.no_customer = c.no_customer
                            INNER JOIN order_detail od ON o.no_order = od.no_order
                            INNER JOIN menu m ON od.no_menu = m.no_menu
                            GROUP BY t.no_transaction, t.date, t.time, c.name_customer, t.payment_method, t.total_bayar");
$jumlahtrans = 1;
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
        <h2 class="fw-bold">Another Data on Database</h2>
        <p>Here you can find additional information from our database.</p>
    </div>

    <div class="container my-5">
        <h3>Customer Data</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Name Customer</th>
                        <th scope="col">Phone</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        while ($list_cust = mysqli_fetch_array($result)) {
                            echo "<tr>";
                            echo "<td>" . $jumlah . "</td>";
                            $jumlah++;
                            echo "<td>" . $list_cust['name_customer'] . "</td>";
                            echo "<td>" . $list_cust['phone'] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="container my-5">
        <h3>History Transaction Data</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-primary">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Date</th>
                        <th scope="col">Time</th>
                        <th scope="col">Customer Name</th>
                        <th scope="col">Menus</th>
                        <th scope="col">Payment Method</th>
                        <th scope="col">Total Price</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <?php
                        while ($list_trans = mysqli_fetch_array($transaction)) {
                            echo "<tr>";
                            echo "<td>" . $list_trans['Transaction Number'] . "</td>";
                            echo "<td>" . $list_trans['Date'] . "</td>";
                            echo "<td>" . $list_trans['Time'] . "</td>";
                            echo "<td>" . $list_trans['Customer Name'] . "</td>";
                            echo "<td>" . $list_trans['Menus'] . "</td>";
                            echo "<td>";
                            if ($list_trans['Payment Method'] == 'cash') {
                                echo "<span class=\"badge rounded-pill text-bg-primary\">Cash</span>";
                            } elseif ($list_trans['Payment Method'] == 'credit_card') {
                                echo "<span class=\"badge rounded-pill text-bg-success\">Credit Card</span>";
                            } elseif ($list_trans['Payment Method'] == 'e_wallet') {
                                echo "<span class=\"badge rounded-pill text-bg-warning\">E-Wallet</span>";
                            } elseif ($list_trans['Payment Method'] == 'debit_card') {
                                echo "<span class=\"badge rounded-pill text-bg-danger\">Debit Card</span>";
                            }
                            echo "</td>";
                            echo "<td>";
                            echo "Rp " . number_format($list_trans['Total Price'], 0, ',', '.');
                            echo "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>