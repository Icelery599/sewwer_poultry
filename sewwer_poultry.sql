
/**
 * Sewwer Poultry Website - Complete Project
 * 
 * Installation Instructions:
 * 1. Place all files in your XAMPP/WAMP htdocs/sewwer_poultry folder
 * 2. Create a MySQL database named 'sewwer_poultry'
 * 3. Import the SQL file from 'sql/sewwer_poultry.sql'
 * 4. Update config/db.php with your database credentials
 * 5. Access the website at http://localhost/sewwer_poultry
 * 6. Admin Panel: /admin with credentials admin / admin123
 */



CREATE DATABASE IF NOT EXISTS `sewwer_poultry`;
USE `sewwer_poultry`;

-- Categories table
CREATE TABLE `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `slug` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert categories
INSERT INTO `categories` (`id`, `name`, `slug`) VALUES
(1, 'Noiler Birds', 'noiler-birds'),
(2, 'Matured Birds', 'matured-birds'),
(3, 'Fresh Eggs', 'fresh-eggs'),
(4, 'Organic Manure', 'organic-manure');

-- Products table
CREATE TABLE IF NOT EXISTS `products` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `category_id` int(11) NOT NULL,
  `name` varchar(200) NOT NULL,
  `slug` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT 0,
  `image` varchar(255) DEFAULT 'default-product.jpg',
  `status` tinyint(1) DEFAULT 1,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
);

INSERT INTO `products` (`category_id`, `name`, `slug`, `description`, `price`, `stock_quantity`) VALUES
(1, 'Noiler Birds (2-3 Weeks Old)', 'noiler-birds', 'Healthy Noiler birds, vaccinated', 3500.00, 100),
(2, 'Matured Noiler Birds', 'matured-birds', 'Fully grown for consumption', 8500.00, 50),
(3, 'Fresh Poultry Eggs (Tray of 30)', 'fresh-eggs', 'Farm-fresh eggs', 2500.00, 200),
(4, 'Poultry Manure (50kg Bag)', 'manure', 'Organic fertilizer', 3000.00, 80);

-- Orders table
CREATE TABLE `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_number` varchar(50) NOT NULL,
  `customer_name` varchar(100) NOT NULL,
  `customer_email` varchar(100) NOT NULL,
  `customer_phone` varchar(20) NOT NULL,
  `customer_address` text NOT NULL,
  `order_total` decimal(10,2) NOT NULL,
  `payment_method` varchar(50) DEFAULT 'Bank Transfer',
  `order_status` enum('pending','processing','completed','cancelled') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `order_number` (`order_number`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Order items table
CREATE TABLE `order_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `order_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_name` varchar(200) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `order_id` (`order_id`),
  CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Contacts/Inquiries table
CREATE TABLE `contacts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(20) DEFAULT NULL,
  `subject` varchar(200) NOT NULL,
  `message` text NOT NULL,
  `is_read` tinyint(1) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Users table (Admin)
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','staff') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert default admin user (password: admin123)
INSERT INTO `users` (`username`, `password`, `email`, `role`) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@sewwerpoultry.com', 'admin');

-- Gallery images table
CREATE TABLE `gallery` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `image` varchar(255) NOT NULL,
  `category` varchar(100) DEFAULT 'farm',
  `sort_order` int(11) DEFAULT 0,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Insert sample gallery images
INSERT INTO `gallery` (`title`, `image`, `category`) VALUES
('Healthy Noiler Birds', 'gallery-birds.jpg', 'birds'),
('Modern Poultry Coop', 'gallery-coop.jpg', 'farm'),
('Feeding Process', 'gallery-feeding.jpg', 'process'),
('Fresh Egg Collection', 'gallery-eggs.jpg', 'eggs'),
('Farm Environment', 'gallery-farm.jpg', 'farm'),
('Processing Activities', 'gallery-processing.jpg', 'process');

COMMIT;
-- Feature expansion: customer dashboard, tracking, payments, reviews, blog, notifications and SEO
CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(120) NOT NULL,
  `email` varchar(120) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `address` text DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

ALTER TABLE `orders`
  ADD COLUMN IF NOT EXISTS `customer_id` int(11) DEFAULT NULL AFTER `id`,
  ADD COLUMN IF NOT EXISTS `payment_status` enum('unpaid','paid','failed') DEFAULT 'unpaid' AFTER `payment_method`,
  ADD COLUMN IF NOT EXISTS `payment_reference` varchar(100) DEFAULT NULL AFTER `payment_status`,
  ADD COLUMN IF NOT EXISTS `order_notes` text DEFAULT NULL AFTER `payment_reference`,
  MODIFY COLUMN `order_status` enum('pending','processing','out_for_delivery','completed','cancelled') DEFAULT 'pending';

CREATE TABLE IF NOT EXISTS `notifications_log` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `channel` enum('email','sms') NOT NULL,
  `recipient` varchar(150) NOT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('queued','sent','failed') DEFAULT 'queued',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `reviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) DEFAULT NULL,
  `customer_name` varchar(120) NOT NULL,
  `customer_email` varchar(120) NOT NULL,
  `rating` tinyint(1) NOT NULL DEFAULT 5,
  `review` text NOT NULL,
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS `blog_posts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `title` varchar(200) NOT NULL,
  `slug` varchar(220) NOT NULL,
  `excerpt` text DEFAULT NULL,
  `content` longtext NOT NULL,
  `meta_title` varchar(200) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` enum('draft','published') DEFAULT 'draft',
  `published_at` datetime DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `slug` (`slug`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `reviews` (`customer_name`, `customer_email`, `rating`, `review`, `status`) VALUES
('Amina Yusuf', 'amina@example.com', 5, 'Fresh eggs and healthy birds delivered exactly as promised.', 'approved'),
('Daniel Musa', 'daniel@example.com', 5, 'The order tracking made it easy to know when my poultry supplies would arrive.', 'approved');

INSERT INTO `blog_posts` (`title`, `slug`, `excerpt`, `content`, `meta_title`, `meta_description`, `status`, `published_at`) VALUES
('How to Keep Noiler Birds Healthy in Their First Month', 'keep-noiler-birds-healthy-first-month', 'Simple brooding, feeding and hygiene tips for strong Noiler birds.', 'Start with a clean brooder, steady warmth, fresh water and quality starter feed. Watch your birds daily for weak movement, poor appetite or unusual droppings. Good ventilation and dry litter reduce stress and disease pressure.', 'Noiler Bird Care Tips for the First Month', 'Learn practical first-month Noiler bird care tips from Sewwer Poultry.', 'published', NOW()),
('Best Practices for Storing Fresh Poultry Eggs', 'best-practices-storing-fresh-poultry-eggs', 'Protect egg freshness with clean handling, cool storage and careful transport.', 'Collect eggs with clean hands, store them in trays with the pointed end downward, and keep them away from heat and strong smells. Rotate stock so older trays are sold or used first.', 'How to Store Fresh Poultry Eggs', 'Fresh egg storage tips for homes, restaurants and retailers.', 'published', NOW());
