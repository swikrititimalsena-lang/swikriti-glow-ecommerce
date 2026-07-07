CREATE DATABASE IF NOT EXISTS simple_ecommerce;
USE simple_ecommerce;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') DEFAULT 'user',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category ENUM('Beads Jewellery','Cosmetics') NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(255) DEFAULT 'default.jpg',
    stock INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    status ENUM('Pending','Completed') DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
);

-- Password for admin@example.com is: admin123
INSERT INTO users (name, email, password, role)
VALUES (
    'Admin',
    'admin@example.com',
    '$2y$10$mjRGUhFkfmY4CecgM3O1jOy7dIQrjlwmVhG1t1x8q.QwjlwmTgkiS',
    'admin'
);

INSERT INTO products (name, category, description, price, image, stock) VALUES
('Rose Bead Bracelet', 'Beads Jewellery', 'Handmade pink rose bead bracelet.', 12.99, 'bracelet.jpg', 20),
('Pearl Bead Necklace', 'Beads Jewellery', 'Elegant pearl-style necklace.', 24.50, 'necklace.jpg', 15),
('Lip Gloss Set', 'Cosmetics', 'Set of 3 shiny lip glosses.', 18.00, 'lipgloss.jpg', 25),
('Matte Foundation', 'Cosmetics', 'Smooth matte finish foundation.', 22.99, 'foundation.jpg', 18);
