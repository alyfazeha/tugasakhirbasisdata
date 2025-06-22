<?php 
include_once("config.php");
$no_menu = $_GET['no_menu'];

$result = mysqli_query($connection, "DELETE FROM menu WHERE no_menu = $no_menu");
header("Location:menu.php");

?>