<?php
include "../db.php";
include "auth.php";
include "header.php";

$products = $conn->query("SELECT COUNT(*) as t FROM products")->fetch_assoc()['t'];
$users = $conn->query("SELECT COUNT(*) as t FROM users")->fetch_assoc()['t'];
$orders = $conn->query("SELECT COUNT(*) as t FROM orders")->fetch_assoc()['t'];
$categories = $conn->query("SELECT COUNT(*) as t FROM categories")->fetch_assoc()['t'];
?>

<div class="container py-4">
<h3 class="mb-4">Admin Dashboard</h3>
<div class="row g-3">

<div class="col-md-3">
<div class="card shadow border-0 text-center p-3">
<h6>Products</h6>
<h2><?= $products ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 text-center p-3">
<h6>Users</h6>
<h2><?= $users ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 text-center p-3">
<h6>Orders</h6>
<h2><?= $orders ?></h2>
</div>
</div>

<div class="col-md-3">
<div class="card shadow border-0 text-center p-3">
<h6>Categories</h6>
<h2><?= $categories ?></h2>
</div>
</div>
</div>
</div>

<?php include "footer.php"; ?>