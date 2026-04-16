<?php include "../db.php"; ?>
<?php include "auth.php"; ?>
<?php include "header.php"; ?>

<?php
if (isset($_GET['delete'])) {
    $id = (int) $_GET['delete'];

    if (isset($_SESSION['user']['id']) && $_SESSION['user']['id'] == $id) {
        die("You cannot delete your own account.");
    }

    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    header("Location: users.php");
    exit;
}

$res = $conn->query("SELECT * FROM users ORDER BY id DESC");
?>

<div class="container py-4">
<div class="card shadow border-0 p-3">

<h5 class="mb-3">Users List</h5>

<div class="table-responsive">
<table class="table table-hover align-middle">

<thead class="table-dark">
<tr>
<th>ID</th>
<th>Name</th>
<th>Email</th>
<th>Role</th>
<th>Action</th>
</tr>
</thead>

<tbody>

<?php while($u = $res->fetch_assoc()): ?>
<tr>

<td><?= $u['id'] ?></td>
<td><?= htmlspecialchars($u['name']) ?></td>
<td><?= htmlspecialchars($u['email']) ?></td>

<td>
<span class="badge bg-secondary">
<?= $u['role'] ?? 'user' ?>
</span>
</td>
<td>

<a href="edit_user.php?id=<?= $u['id'] ?>"
   class="btn btn-sm btn-dark">
   Edit Role
</a>

<a href="users.php?delete=<?= $u['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Are you sure you want to delete this user?');">
   Delete
</a>

</td>
</tr>
<?php endwhile; ?>

</tbody>
</table>
</div>
</div>
</div>

<?php include "footer.php"; ?>