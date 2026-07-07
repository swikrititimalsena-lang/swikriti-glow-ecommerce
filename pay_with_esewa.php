<?php
include 'config/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (empty($_SESSION['cart'])) {
    header("Location: cart.php");
    exit();
}

$total = 0;
foreach ($_SESSION['cart'] as $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>eSewa Payment</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <div class="card" style="max-width:500px; margin:60px auto; text-align:center;">
        <h2>eSewa Payment</h2>
        <p>Total Amount: <strong>Rs<?php echo number_format($total, 2); ?></strong></p>

        <form action="esewa_success.php" method="POST" style="background:none;">
            <button type="submit" class="btn">Confirm Payment</button>
        </form>

        <br>

        <a href="esewa_failure.php">Cancel Payment</a>
    </div>
</div>

</body>
</html>
