<!DOCTYPE html>
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
    
    <div class="container my-5">
    <form action="add.php" method="post">
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Name Menu</label>
            <div class="col-sm-10">
            <input type="text" class="form-control" name="Nama">
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label" for="inputType">Type Menu</label>
            <div class="col-sm-10">
                <select id="inputType" class="form-select" name="TypeMenu" required>
                    <option value="" selected disabled>Choose...</option>
                    <option value="appetizer">Appetizer</option>
                    <option value="main_course">Main Course</option>
                    <option value="dessert">Dessert</option>
                </select>
            </div>
        </div>
        <div class="row mb-3">
            <label class="col-sm-2 col-form-label">Price</label>
            <div class="col-sm-10">
            <input type="number" class="form-control" name="Price">
            </div>
        </div>
        <div class="container text-center" style="padding-bottom: 40px; ">
        <div class="d-grid ">
            <button type="submit" class="btn btn-primary" name="submit">Add Menu</button>
        </div>
        </div>
    </form>
    </div>
 
    <?php 
    include_once("config.php");

    if(isset($_POST['submit'])) {
        $name = $_POST['Nama'];
        $type = $_POST['TypeMenu'];
        $price = $_POST['Price'];

        $result = mysqli_query($connection,"INSERT INTO menu(name_menu,type_menu,price) VALUES ('$name', '$type', '$price')");

        echo "<div class='container text-center'>";
        echo "<div class='alert alert-dark' role='alert'>
                Menu berhasil ditambahkan.
                <a href='menu.php' class='btn btn-sm btn-success ms-3'>Lihat Menu</a>
            </div>";
        echo "</div>";
    }
    ?> 
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>