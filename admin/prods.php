<?php include "../db.php"; ?>
<?php include "auth.php"; ?>
<?php include "header.php"; ?>

<?php
if (isset($_POST['add'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $category_id = !empty($_POST['category_id']) ? $_POST['category_id'] : null;

    if (empty($_FILES['image']['name'])) {
        die("Image is required");
    }

    $image = time() . "_" . $_FILES['image']['name'];
    move_uploaded_file($_FILES['image']['tmp_name'], "../images/" . $image);

    $stmt = $conn->prepare("
        INSERT INTO products(name, price, image, category_id)
        VALUES(?,?,?,?)
    ");

    $stmt->bind_param("sdsi", $name, $price, $image, $category_id);
    $stmt->execute();
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];

    $img = $conn->query("SELECT image FROM products WHERE id=$id")->fetch_assoc();

    if ($img && file_exists("../images/" . $img['image'])) {
        unlink("../images/" . $img['image']);
    }

    $conn->query("DELETE FROM products WHERE id=$id");
}

$res = $conn->query("
    SELECT products.*, categories.name AS category_name
    FROM products
    LEFT JOIN categories ON products.category_id = categories.id
    ORDER BY products.id DESC
");
?>

<div class="container py-4">
<div class="row g-3">

<div class="col-md-4">
<div class="card shadow border-0 p-3">
<h5>Add Product</h5>

<form method="POST" enctype="multipart/form-data">

<input name="name" class="form-control mb-2" placeholder="Product Name" required>

<input name="price" type="number" step="0.01" class="form-control mb-2" placeholder="Price" required>

<select name="category_id" class="form-control mb-2">
    <option value="">Select Category</option>

    <?php
    $cats = $conn->query("SELECT * FROM categories");
    while ($c = $cats->fetch_assoc()):
    ?>
        <option value="<?= $c['id'] ?>">
            <?= htmlspecialchars($c['name']) ?>
        </option>
    <?php endwhile; ?>
</select>

<input type="file" name="image" class="form-control mb-2" required>

<button name="add" class="btn btn-warning w-100">Add</button>

</form>
</div>
</div>

<div class="col-md-8">
<div class="card shadow border-0 p-3">

<h5>Products</h5>

<table class="table mt-3 align-middle">
<tr>
<th>Image</th>
<th>ID</th>
<th>Name</th>
<th>Category</th>
<th>Price</th>
<th>Action</th>
</tr>

<?php while ($p = $res->fetch_assoc()): ?>
<tr>

<td>
<img src="../images/<?= $p['image'] ?>"
     width="50"
     height="50"
     style="object-fit:cover;border-radius:5px;">
</td>

<td><?= $p['id'] ?></td>
<td><?= $p['name'] ?></td>

<td>
<?= $p['category_name'] ? htmlspecialchars($p['category_name']) : 'Uncategorized' ?>
</td>

<td>₱<?= number_format($p['price'],2) ?></td>

<td>
<a href="edit_prods.php?id=<?= $p['id'] ?>" class="btn btn-sm btn-dark">Edit</a>
<a href="?delete=<?= $p['id'] ?>"
   class="btn btn-sm btn-danger"
   onclick="return confirm('Are you sure you want to delete this product?')">
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