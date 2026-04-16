<?php
include "../db.php";
include "auth.php";
include "header.php";

$id = (int)$_GET['id'];

$stmt = $conn->prepare("SELECT * FROM users WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

if (isset($_POST['update'])) {
    $role = $_POST['role'];

    $stmt = $conn->prepare("UPDATE users SET role=? WHERE id=?");
    $stmt->bind_param("si", $role, $id);
    $stmt->execute();

    header("Location: users.php");
    exit;
}
?>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-md-5">

<div class="card p-3 shadow border-0">
<h5>Edit User Role</h5>

<form method="POST">

<p><b><?= htmlspecialchars($user['name']) ?></b></p>
<p><?= htmlspecialchars($user['email']) ?></p>

<select name="role" class="form-control mb-2">
    <option value="user" <?= $user['role']=='user'?'selected':'' ?>>User</option>
    <option value="admin" <?= $user['role']=='admin'?'selected':'' ?>>Admin</option>
</select>

<button name="update" class="btn btn-warning w-100">Save</button>

</form>
</div>
</div>
</div>
</div>

<?php include "footer.php"; ?>