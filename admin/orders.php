<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

include '../config/db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

$message = "";

if (isset($_POST['update_status'])) {
    $order_id = (int) $_POST['order_id'];
    $status = $_POST['status'];

    $stmt = $conn->prepare("UPDATE orders SET status = ? WHERE id = ?");

    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("si", $status, $order_id);

    if ($stmt->execute()) {
        $message = "Order status updated successfully!";
    } else {
        $message = "Update failed: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Orders</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>

<div class="container">
    <h2>Customer Orders</h2>

    <?php if ($message != ""): ?>
        <p class="message"><?php echo $message; ?></p>
    <?php endif; ?>

    <table class="table">
        <tr>
            <th>Order ID</th>
            <th>User ID</th>
            <th>Total</th>
            <th>Status</th>
            <th>Date</th>
            <th>Update Status</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM orders ORDER BY id DESC");

        while($row = $result->fetch_assoc()):
        ?>

        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td>Rs<?php echo number_format($row['total_amount'], 2); ?></td>
            <td><?php echo htmlspecialchars($row['status']); ?></td>
            <td><?php echo $row['created_at']; ?></td>

            <td>
                <form method="POST" style="padding:0; margin:0; background:none;">
                    <input type="hidden" name="order_id" value="<?php echo $row['id']; ?>">

                    <select name="status">
                        <option value="Pending" <?php if($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                        <option value="Completed" <?php if($row['status'] == 'Completed') echo 'selected'; ?>>Completed</option>
                        <option value="On the Way" <?php if($row['status'] == 'On the Way') echo 'selected'; ?>>On the Way</option>
                        <option value="Delivered" <?php if($row['status'] == 'Delivered') echo 'selected'; ?>>Delivered</option>
                    </select>

                    <button type="submit" name="update_status" class="btn">Update</button>
                </form>
            </td>
        </tr>

        <?php endwhile; ?>
    </table>

    <br>
    <a href="dashboard.php">Back to Dashboard</a>
</div>

</body>
</html>
