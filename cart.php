<?php include 'includes/header.php'; ?>
<h2>Your Cart</h2>
<?php
if (isset($_GET['remove'])) {
    $remove_id = (int)$_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    echo "<p class='message'>Item removed from cart.</p>";
}

$total = 0;
if (!empty($_SESSION['cart'])):
?>
<table class="table">
    <tr>
        <th>Product</th>
        <th>Price</th>
        <th>Quantity</th>
        <th>Subtotal</th>
        <th>Action</th>
    </tr>
    <?php foreach($_SESSION['cart'] as $id => $item):
        $subtotal = $item['price'] * $item['quantity'];
        $total += $subtotal;
    ?>
    <tr>
        <td><?php echo htmlspecialchars($item['name']); ?></td>
        <td>Rs<?php echo number_format($item['price'], 2); ?></td>
        <td><?php echo (int)$item['quantity']; ?></td>
        <td>Rs<?php echo number_format($subtotal, 2); ?></td>
        <td><a href="cart.php?remove=<?php echo $id; ?>">Remove</a></td>
    </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="3">Total</th>
        <th colspan="2">Rs<?php echo number_format($total, 2); ?></th>
    </tr>
</table>
<a href="checkout.php" class="btn">Proceed to Checkout</a>
<?php else: ?>
<p>Your cart is empty.</p>
<?php endif; ?>
<?php include 'includes/footer.php'; ?>
