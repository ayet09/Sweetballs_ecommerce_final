<?php
include "db.php";

if (!isset($_SESSION['user']['id'])) {
    header("Location: login.php");
    exit;
}

$order_id = (int)$_POST['id'];
$user_id = $_SESSION['user']['id'];

$stmt = $conn->prepare("
    UPDATE orders 
    SET status='cancelled' 
    WHERE id=? AND user_id=? AND status='pending'
");

$stmt->bind_param("ii", $order_id, $user_id);
$stmt->execute();

header("Location: orders.php");
exit;