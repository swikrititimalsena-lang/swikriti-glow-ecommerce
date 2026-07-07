<?php include 'includes/header.php'; ?>
<?php
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();

if (!$product) {
    echo "<p class='error'>Product not found.</p>";
    include 'includes/footer.php';
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;
    if ($qty < 1) $qty = 1;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (isset($_SESSION['cart'][$id])) {
        $_SESSION['cart'][$id]['quantity'] += $qty;
    } else {
        $_SESSION['cart'][$id] = [
            'name' => $product['name'],
            'price' => $product['price'],
            'quantity' => $qty,
            'image' => $product['image']
        ];
    }

    echo "<p class='message'>Product added to cart.</p>";
}
?>
<div class="card">
    <img src="images/<?php echo htmlspecialchars($product['image']); ?>" alt="product" style="max-width:300px;">
    <h2><?php echo htmlspecialchars($product['name']); ?></h2>
    <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
    <p><?php echo htmlspecialchars($product['description']); ?></p>
    <p><strong>Price:</strong> Rs<?php echo number_format($product['price'], 2); ?></p>
    <p><strong>Stock:</strong> <?php echo (int)$product['stock']; ?></p>

    <form method="POST">
        <label>Quantity</label>
        <input type="number" name="quantity" value="1" min="1">
        <button type="submit" class="btn">Add to Cart</button>
    </form>
</div>
<?php include 'includes/footer.php'; ?>
