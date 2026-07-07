<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $category = $_POST['category'];
    $description = trim($_POST['description']);
    $price = $_POST['price'];
    $image = trim($_POST['image']);
    $stock = $_POST['stock'];

    $stmt = $conn->prepare("INSERT INTO products (name, category, description, price, image, stock) VALUES (?, ?, ?, ?, ?, ?)");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("sssdsi", $name, $category, $description, $price, $image, $stock);

    if ($stmt->execute()) {
        header("Location: dashboard.php");
        exit();
    } else {
        $message = "Error adding product: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h2>Add Product</h2>

    <?php if ($message != ""): ?>
        <p class="error"><?php echo $message; ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Product Name</label>
        <input type="text" name="name" required>

        <label>Category</label>
        <select name="category" required>
            <option value="Beads Jewellery">Beads Jewellery</option>
            <option value="Cosmetics">Cosmetics</option>
            <option value="Women Clothes">Women Clothes</option>
        </select>

        <label>Description</label>
        <textarea name="description" required></textarea>

        <label>Price</label>
        <input type="number" step="0.01" name="price" required>

        <label>Image URL</label>
        <input type="text" name="image" placeholder="Paste image URL here" required>

        <label>Stock</label>
        <input type="number" name="stock" required>

        <button type="submit" class="btn">Add Product</button>
    </form>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
