<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <title>home</title>
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
                        <a class="nav-link" href="#footer">Contact Us</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>


    <div class="container py-5" style="margin-top: -50px;">
        <div class="row align-items-center g-0">
            <div class="col" style="margin-left: 10%;">
                <h1 class="fw-bold">Welcome to nyam.nyam!</h1>
                <p class="lead">Discover our delicious menu and enjoy a delightful dining experience.</p>
            </div>
            <div class="col" style="margin-right: 5%;">
                <img src="img/logo.png" alt="nyam.nyam logo" style="max-width: 100%; height: auto;">
            </div>
        </div>
    </div>

    <div class="justify-content-center text-center py-5" style="background-color:aliceblue; margin-top: -7%;">
        <h2 class="fw-bold">Our Specialties</h2>
        <p>Explore our range of mouth-watering dishes crafted with love and passion.</p>
    </div>

    <div class="container text-center py-5">
    <div class="d-flex justify-content-center flex-wrap gap-4">
        <div class="card" style="width: 18rem;">
            <img src="img/ap.jpeg" class="card-img-top" alt="..." style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">Appetizer</h5>
                <p class="card-text">A small dish served before the main course to stimulate the appetite</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="img/lobster.jpeg" class="card-img-top" alt="..." style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">Main Course</h5>
                <p class="card-text">The primary and most substantial dish of a meal</p>
            </div>
        </div>
        <div class="card" style="width: 18rem;">
            <img src="img/dessert.jpeg" class="card-img-top" alt="..." style="height: 200px; object-fit: cover;">
            <div class="card-body">
                <h5 class="card-title">Dessert</h5>
                <p class="card-text">A sweet dish served at the end of a meal.</p>
            </div>
        </div>
    </div>
    <button type="button" class="btn btn-primary mt-4">
        <a href="menu.php" style="color: white; text-decoration: none;">Let's See The Menu</a>
    </button>
</div> 

<footer class="bg-dark text-white pt-5 pb-4" id="footer">
    <div class="container text-center text-md-left">
        <div class="row text-center text-md-left">
            <div class="col-md-6 col-lg-6 col-xl-6 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Contact Us</h5>
                <p>
                    Email: info@nyamnyam.com<br>
                    Phone: +62 812-3456-7890
                </p>
            </div>
            <div class="col-md-6 col-lg-6 col-xl-6 mx-auto mt-3">
                <h5 class="text-uppercase mb-4 font-weight-bold">Location</h5>
                <p>
                    Jl. Kuliner No. 123, Malang, Indonesia
                </p>
                <iframe src="https://www.google.com/maps?q=Malang,Indonesia&output=embed" width="100%" height="150" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.bundle.min.js" integrity="sha384-j1CDi7MgGQ12Z7Qab0qlWQ/Qqz24Gc6BM0thvEMVjHnfYGF0rmFCozFSxQBxwHKO" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/js/bootstrap.min.js" integrity="sha384-RuyvpeZCxMJCqVUGFI0Do1mQrods/hhxYlcVfGPOfQtPJh0JCw12tUAZ/Mv10S7D" crossorigin="anonymous"></script>
</body>
</html>