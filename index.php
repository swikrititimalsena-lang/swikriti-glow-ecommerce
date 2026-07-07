<?php include 'includes/header.php'; ?>
<section class="hero">
    <h2>Welcome to Swikriti Glow & Beads Shop</h2>
    <p>Simple online store for beads jewellery and cosmetics.</p>
    <br>
    <a href="products.php" class="btn">Shop Now</a>
</section>

<h2>Featured Products</h2>
<div class="grid">
<?php
$result = $conn->query("SELECT * FROM products ORDER BY id DESC LIMIT 4");
while($row = $result->fetch_assoc()):
?>
    <div class="card">
    <img src="<?php echo htmlspecialchars($row['image']); ?>"
     width="80"
     style="border-radius:8px; object-fit:cover;">
        <h3><?php echo htmlspecialchars($row['name']); ?></h3>
        <p><?php echo htmlspecialchars($row['category']); ?></p>
        <p>Rs<?php echo number_format($row['price'], 2); ?></p>
        <a class="btn" href="product_details.php?id=<?php echo $row['id']; ?>">View Details</a>
    </div>
<?php endwhile; ?>
</div>
<?php include 'includes/footer.php'; ?>
