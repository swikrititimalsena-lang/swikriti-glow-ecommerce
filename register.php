<?php include 'includes/header.php'; ?>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $password);

    if ($stmt->execute()) {
        echo "<p class='message'>Registration successful. <a href='login.php'>Login now</a>.</p>";
    } else {
        echo "<p class='error'>Email already exists or something went wrong.</p>";
    }
}
?>
<form method="POST">
    <h2>Register</h2>
    <label>Name</label>
    <input type="text" name="name" required>

    <label>Email</label>
    <input type="email" name="email" required>

    <label>Password</label>
    <input type="password" name="password" required>

    <button type="submit" class="btn">Register</button>
</form>
<?php include 'includes/footer.php'; ?>
