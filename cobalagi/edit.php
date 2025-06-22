<?php
include_once("config.php");

// Ambil ID menu dari URL
if (isset($_GET['no_menu'])) {
    $no_menu = $_GET['no_menu'];

    // Ambil data menu
    $result = mysqli_query($connection, "SELECT * FROM menu WHERE no_menu = $no_menu");
    if ($result && mysqli_num_rows($result) > 0) {
        $menu = mysqli_fetch_assoc($result);
    } else {
        echo "Menu not found.";
        exit;
    }
} else {
    echo "No ID specified.";
    exit;
}

// Jika form disubmit
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $name = mysqli_real_escape_string($connection, $_POST['Nama']);
    $type = mysqli_real_escape_string($connection, $_POST['TypeMenu']);
    $price = (float) $_POST['Price'];

    $update = mysqli_query($connection, "UPDATE menu SET name_menu='$name', type_menu='$type', price='$price' WHERE no_menu=$id");

    if ($update) {
        header("Location: menu.php");
        exit;
    } else {
        echo "Failed to update: " . mysqli_error($connection);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Menu</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
  <h2>Edit Menu</h2>
  <form method="post" action="">
    <input type="hidden" name="id" value="<?php echo $menu['no_menu']; ?>">
    
    <div class="mb-3">
      <label class="form-label">Name Menu</label>
      <input type="text" class="form-control" name="Nama" value="<?php echo htmlspecialchars($menu['name_menu']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Type Menu</label>
      <select class="form-select" name="TypeMenu" required>
        <option value="" disabled>Choose...</option>
        <option value="appetizer" <?php if($menu['type_menu']=='appetizer') echo 'selected'; ?>>Appetizer</option>
        <option value="main_course" <?php if($menu['type_menu']=='main_course') echo 'selected'; ?>>Main Course</option>
        <option value="dessert" <?php if($menu['type_menu']=='dessert') echo 'selected'; ?>>Dessert</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Price</label>
      <input type="number" class="form-control" name="Price" value="<?php echo $menu['price']; ?>" required>
    </div>

    <button type="submit" class="btn btn-primary" name="update">Update Menu</button>
  </form>
</div>
</body>
</html>
