<?php include 'includes/header.php'; ?>
<?php include 'includes/auth_check.php'; ?>

<?php
if (empty($_SESSION['cart'])) {
    echo "<p class='error'>Your cart is empty.</p>";
    include 'includes/footer.php';
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<form method="POST" action="pay_with_esewa.php">
    <h2>Checkout</h2>
    <p>Total amount: <strong>Rs<?php echo number_format($total, 2); ?></strong></p>

    <button type="submit" class="btn">Pay with eSewa</button>
</form>

<?php include 'includes/footer.php'; ?>
