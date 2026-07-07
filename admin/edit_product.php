<?php include '../config/db.php'; ?>
<?php
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    die('Product not found');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $stock = (int)$_POST['stock'];
    $image = trim($_POST['image']);

    $stmt = $conn->prepare("UPDATE products SET name=?, category=?, description=?, price=?, image=?, stock=? WHERE id=?");
    $stmt->bind_param("sssdsii", $name, $category, $description, $price, $image, $stock, $id);
    $stmt->execute();

    header('Location: dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container">
    <h2 style="margin-top:20px;">Edit Product</h2>
    <form method="POST">
        <label>Product Name</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>

        <label>Category</label>
        <select name="category" required>
            <option value="Beads Jewellery" <?php if($product['category']=='Beads Jewellery') echo 'selected'; ?>>Beads Jewellery</option>
            <option value="Cosmetics" <?php if($product['category']=='Cosmetics') echo 'selected'; ?>>Cosmetics</option>
            <option value="Women Clothes">Women Clothes</option>
        </select>

        <label>Description</label>
        <textarea name="description" required><?php echo htmlspecialchars($product['description']); ?></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" value="<?php echo $product['price']; ?>" required>

        <label>Stock</label>
        <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>

        <label>Image File Name</label>
        <input type="text" name="image" value="<?php echo htmlspecialchars($product['image']); ?>" required>

        <button class="btn" type="submit">Update Product</button>
    </form>
</div>
</body>
</html>
