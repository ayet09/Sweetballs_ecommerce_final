<?php
include "../db.php";
include "auth.php";
include "header.php";

$res = $conn->query("
    SELECT o.*, u.name AS user_name, u.email
    FROM orders o
    LEFT JOIN users u ON u.id = o.user_id
    ORDER BY o.id DESC
");
?>

<div class="container py-4">
<div class="card shadow border-0 p-3">
<h5 class="mb-3">Orders List</h5>
<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>#</th>
<th>Order Details</th>
<th>Total</th>
<th>Status</th>
<th>Date</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($o = $res->fetch_assoc()): ?>

<?php
$total = 0;

$items = $conn->query("
    SELECT oi.quantity, p.price
    FROM order_items oi
    JOIN products p ON p.id = oi.product_id
    WHERE oi.order_id = {$o['id']}
");

while ($i = $items->fetch_assoc()) {
    $total += $i['price'] * $i['quantity'];
}
?>

<tr>
<td>#<?= $o['id'] ?></td>
<td>
    <?= htmlspecialchars($o['user_name'] ?? 'Unknown') ?><br>
    <small>
        <?= htmlspecialchars($o['email'] ?? '') ?><br>
        <?= htmlspecialchars($o['address']) ?><br>
        <?= htmlspecialchars($o['payment_method']) ?>
    </small>
</td>
<td>₱<?= number_format($total, 2) ?></td>
<td>
<span class="badge 
<?=
    $o['status'] == 'cancelled' ? 'bg-danger' :
    ($o['status'] == 'pending' ? 'bg-warning' :
    ($o['status'] == 'shipped' ? 'bg-info' :
    ($o['status'] == 'delivered' ? 'bg-success' : 'bg-secondary')))
?>">
<?= ucfirst($o['status']) ?>
</span>
</td>
<td><?= $o['created_at'] ?? 'N/A' ?></td>
<td>
<form method="POST" action="update_status.php" class="d-flex gap-1">
<input type="hidden" name="id" value="<?= $o['id'] ?>">

<select name="status" class="form-select form-select-sm">
<option value="pending" <?= $o['status']=='pending'?'selected':'' ?>>Pending</option>
<option value="shipped" <?= $o['status']=='shipped'?'selected':'' ?>>Shipped</option>
<option value="delivered" <?= $o['status']=='delivered'?'selected':'' ?>>Delivered</option>
</select>
<button class="btn btn-sm btn-primary">Update</button>
</form>
</td>
</tr>

<?php endwhile; ?>

</tbody>
</table>
</div>
</div>
</div>

<?php include "footer.php"; ?>