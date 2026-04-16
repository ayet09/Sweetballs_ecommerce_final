<?php
include "../db.php";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$current = basename($_SERVER['PHP_SELF']);
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
.nav-link.active {
    color: #ffc107 !important;
    font-weight: 600;
}
</style>

<nav class="navbar navbar-dark bg-dark navbar-expand-lg">
<div class="container">

<a class="navbar-brand fw-bold text-warning" href="dashboard.php">
    Admin Panel
</a>

<button class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="#navAdmin">
    <span class="navbar-toggler-icon"></span>
</button>

<div class="collapse navbar-collapse justify-content-end" id="navAdmin">

<ul class="navbar-nav gap-2">

<li class="nav-item">
    <a class="nav-link <?= $current == 'dashboard.php' ? 'active' : 'text-white' ?>"
       href="dashboard.php">
        Dashboard
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?= $current == 'prods.php' ? 'active' : 'text-white' ?>"
       href="prods.php">
        Products
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?= $current == 'users.php' ? 'active' : 'text-white' ?>"
       href="users.php">
        Users
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?= $current == 'orders.php' ? 'active' : 'text-white' ?>"
       href="orders.php">
        Orders
    </a>
</li>

<li class="nav-item">
    <a class="nav-link <?= $current == 'categories.php' ? 'active' : 'text-white' ?>"
       href="categories.php">
        Categories
    </a>
</li>

<li class="nav-item">
    <a class="nav-link text-danger" href="../logout.php">
        Logout
    </a>
</li>

</ul>
</div>
</div>
</nav>

<div class="container py-4">