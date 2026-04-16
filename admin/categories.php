<?php
include "../db.php";
include "auth.php";
include "header.php";

if (isset($_POST['add'])) {
    $name = trim($_POST['name']);

    $stmt = $conn->prepare("INSERT INTO categories(name) VALUES(?)");
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $stmt = $conn->prepare("DELETE FROM categories WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

$res = $conn->query("SELECT * FROM categories ORDER BY id DESC");
?>

<div class="container py-4">
<div class="row g-3">

<div class="col-md-4">
<div class="card p-3 shadow border-0">
<h5>Add Category</h5>

<form method="POST">
<input name="name" class="form-control mb-2" required>
<button name="add" class="btn btn-warning w-100">Add</button>
</form>

</div>
</div>

<div class="col-md-8">
<div class="card p-3 shadow border-0">
<h5>Categories</h5>

<table class="table">
<tr>
<th>ID</th>
<th>Name</th>
<th>Action</th>
</tr>

<?php while($c = $res->fetch_assoc()): ?>
<tr>
<td><?= $c['id'] ?></td>
<td><?= htmlspecialchars($c['name']) ?></td>
<td>
<a href="edit_category.php?id=<?= $c['id'] ?>"class="btn btn-sm btn-dark">Edit</a>
<a href="?delete=<?= $c['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Delete category?')">
Delete
</a>
</td>
</tr>
<?php endwhile; ?>

</table>
</div>
</div>
</div>
</div>

<?php include "footer.php"; ?>