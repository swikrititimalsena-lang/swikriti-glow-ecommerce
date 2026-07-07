<?php
include 'config/db.php';
include 'includes/header.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!empty($_SESSION['cart'])) {
    $total = 0;

    foreach ($_SESSION['cart'] as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    $user_id = $_SESSION['user_id'];

    $stmt = $conn->prepare("INSERT INTO orders (user_id, total_amount, status) VALUES (?, ?, 'Completed')");
    $stmt->bind_param("id", $user_id, $total);
    $stmt->execute();

    $order_id = $conn->insert_id;

    foreach ($_SESSION['cart'] as $product_id => $item) {
        $qty = $item['quantity'];
        $price = $item['price'];

        $stmt2 = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        $stmt2->bind_param("iiid", $order_id, $product_id, $qty, $price);
        $stmt2->execute();

        $stmt3 = $conn->prepare("UPDATE products SET stock = stock - ? WHERE id = ?");
        $stmt3->bind_param("ii", $qty, $product_id);
        $stmt3->execute();
    }

    unset($_SESSION['cart']);
}
?>

<div class="message">
    <h2>Payment Successful ✅</h2>
    <p>Your payment through eSewa has been completed successfully.</p>
    <p>Your order has been placed and product stock has been updated.</p>

    <br>

    <a href="my_orders.php" class="btn">View My Orders</a>
    <a href="index.php" class="btn">Back to Home</a>
</div>

<?php include 'includes/footer.php'; ?>
