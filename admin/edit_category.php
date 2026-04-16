<?php
include "../db.php";
include "auth.php";
include "header.php";

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM categories WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$cat = $stmt->get_result()->fetch_assoc();

if (isset($_POST['update'])) {
    $name = $_POST['name'];

    $stmt = $conn->prepare("UPDATE categories SET name=? WHERE id=?");
    $stmt->bind_param("si", $name, $id);
    $stmt->execute();

    header("Location: categories.php");
    exit;
}
?>

<div class="container py-4">
<form method="POST">
<input name="name" value="<?= htmlspecialchars($cat['name']) ?>" class="form-control mb-2">
<button name="update" class="btn btn-warning">Update</button>
</form>
</div>

<?php include "footer.php"; ?>