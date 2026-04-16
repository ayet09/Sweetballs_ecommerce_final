<?php
include "../db.php";
include "auth.php";

$id = (int)$_POST['id'];
$new_status = $_POST['status'];

$res = $conn->query("SELECT status FROM orders WHERE id=$id");
$order = $res->fetch_assoc();
$current_status = $order['status'];

if ($current_status == 'cancelled') {
    header("Location: orders.php");
    exit;
}

$allowed = false;

if ($current_status == 'pending' && $new_status == 'shipped') {
    $allowed = true;
}

if ($current_status == 'shipped' && $new_status == 'delivered') {
    $allowed = true;
}

if (!$allowed) {
    header("Location: orders.php");
    exit;
}

$stmt = $conn->prepare("UPDATE orders SET status=? WHERE id=?");
$stmt->bind_param("si", $new_status, $id);
$stmt->execute();

header("Location: orders.php");