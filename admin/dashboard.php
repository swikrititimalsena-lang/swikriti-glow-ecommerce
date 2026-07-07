<?php include '../config/db.php'; ?>

<?php

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    header('Location: ../login.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="../css/style.css">

    <style>
        .product-img{
            width:70px;
            height:70px;
            object-fit:cover;
            border-radius:8px;
        }
    </style>
</head>

<body>

<div class="container">

    <h2 style="margin-top:20px;">Admin Dashboard</h2>

    <p>
        Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?>
    </p>

    <p class="admin-links">
        <a class="btn" href="add_product.php">Add Product</a>
        <a class="btn" href="orders.php">View Orders</a>
        <a class="btn" href="../logout.php">Logout</a>
    </p>

    <h3>All Products</h3>

    <table class="table">

        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Price</th>
            <th>Stock</th>
            <th>Action</th>
        </tr>

        <?php
        $result = $conn->query("SELECT * FROM products ORDER BY id DESC");

        while($row = $result->fetch_assoc()):
        ?>

        <tr>

            <td>
                <?php echo $row['id']; ?>
            </td>

            <td>
                <img
                src="<?php echo htmlspecialchars($row['image']); ?>"
     width="80"
     style="border-radius:8px; object-fit:cover;"
                >
            </td>

            <td>
                <?php echo htmlspecialchars($row['name']); ?>
            </td>

            <td>
                <?php echo htmlspecialchars($row['category']); ?>
            </td>

            <td>
                Rs<?php echo number_format($row['price'], 2); ?>
            </td>

            <td>
                <?php echo $row['stock']; ?>
            </td>

            <td>
                <a href="edit_product.php?id=<?php echo $row['id']; ?>">Edit</a>
                |
                <a href="delete_product.php?id=<?php echo $row['id']; ?>">Delete</a>
            </td>

        </tr>

        <?php endwhile; ?>

    </table>

</div>

</body>
</html>