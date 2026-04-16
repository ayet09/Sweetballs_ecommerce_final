<?php
include "../db.php";
include "auth.php";
include "header.php";

if (!isset($_GET['id'])) {
    die("Invalid request");
}

$id = (int) $_GET['id'];

$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$p = $result->fetch_assoc();

if (!$p) {
    die("Product not found");
}

if (isset($_POST['update'])) {

    $name = trim($_POST['name']);
    $price = (float) $_POST['price'];
    $category_id = !empty($_POST['category_id']) ? (int) $_POST['category_id'] : null;

    if ($name === '' || $price <= 0) {
        die("Invalid input");
    }

    $image = $p['image'];

    if (!empty($_FILES['image']['name'])) {

        $allowed = ['jpg','jpeg','png','webp'];
        $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) {
            die("Invalid image type");
        }

        $image = uniqid() . "." . $ext;

        move_uploaded_file(
            $_FILES['image']['tmp_name'],
            "../images/" . $image
        );

        if (!empty($p['image']) && file_exists("../images/" . $p['image'])) {
            unlink("../images/" . $p['image']);
        }
    }

    $stmt = $conn->prepare("UPDATE products SET name=?, price=?, image=?, category_id=? WHERE id=?");
    $stmt->bind_param("sdsii", $name, $price, $image, $category_id, $id);
    $stmt->execute();

    header("Location: prods.php");
    exit;
}
?>

<div class="container py-4">
<div class="row justify-content-center">
<div class="col-md-5">
<div class="card shadow border-0 p-3">

<h5>Edit Product</h5>
<form method="POST" enctype="multipart/form-data">
<input name="name" value="<?= htmlspecialchars($p['name']) ?>" class="form-control mb-2" required>
<input name="price" value="<?= htmlspecialchars($p['price']) ?>" class="form-control mb-2" required>
<select name="category_id" class="form-control mb-2">

    <option value="">Select Category</option>

    <?php
    $cats = $conn->query("SELECT * FROM categories");
    while ($c = $cats->fetch_assoc()):
    ?>
        <option value="<?= $c['id'] ?>"
            <?= $p['category_id'] == $c['id'] ? 'selected' : '' ?>>
            <?= htmlspecialchars($c['name']) ?>
        </option>
    <?php endwhile; ?>

</select>
<img src="../images/<?= htmlspecialchars($p['image']) ?>"
     class="mb-2"
     width="100"
     style="object-fit:cover;">

<input type="file" name="image" class="form-control mb-2">

<button name="update" class="btn btn-warning w-100">Update</button>

</form>
</div>
</div>
</div>
</div>

<?php include "footer.php"; ?>