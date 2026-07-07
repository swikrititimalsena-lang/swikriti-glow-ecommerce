<?php include 'includes/header.php'; ?>
<?php include 'includes/auth_check.php'; ?>

<h2>My Orders</h2>

<?php
$user_id = $_SESSION['user_id'];
$result = $conn->query("SELECT * FROM orders WHERE user_id = $user_id ORDER BY id DESC");
?>

<table class="table">
    <tr>
        <th>Order ID</th>
        <th>Total</th>
        <th>Status</th>
        <th>Notification</th>
        <th>Date</th>
    </tr>

    <?php while($row = $result->fetch_assoc()): ?>

    <tr>
        <td><?php echo $row['id']; ?></td>
        <td>Rs<?php echo number_format($row['total_amount'], 2); ?></td>
        <td><?php echo $row['status']; ?></td>

        <td>
            <?php
            if ($row['status'] == 'On the Way') {
                echo "Your order is on the way 🚚";
            } elseif ($row['status'] == 'Delivered') {
                echo "Your order has been delivered ✅";
            } elseif ($row['status'] == 'Completed') {
                echo "Your order has been confirmed and is being prepared.";
            } else {
                echo "Your order is pending.";
            }
            ?>
        </td>

        <td><?php echo $row['created_at']; ?></td>
    </tr>

    <?php endwhile; ?>
</table>

<?php include 'includes/footer.php'; ?>
