-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 20, 2024 at 06:02 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ecommerce_project`
--

-- --------------------------------------------------------

--
-- Table structure for table `admins`
--

CREATE TABLE `admins` (
  `admin_id` int(11) NOT NULL,
  `admin_name` varchar(250) NOT NULL,
  `admin_email` text NOT NULL,
  `admin_password` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admins`
--

INSERT INTO `admins` (`admin_id`, `admin_name`, `admin_email`, `admin_password`) VALUES
(1, 'admin', 'admin@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(150) DEFAULT NULL,
  `cat_status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`cat_id`, `cat_name`, `cat_status`) VALUES
(1, 'shoes', 1),
(2, 'clothes', 1);

-- --------------------------------------------------------

--
-- Table structure for table `colors`
--

CREATE TABLE `colors` (
  `col_id` int(11) NOT NULL,
  `col_name` varchar(150) DEFAULT NULL,
  `col_status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `colors`
--

INSERT INTO `colors` (`col_id`, `col_name`, `col_status`) VALUES
(1, 'red', 1),
(2, 'blue', 1),
(3, 'white', 1);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) NOT NULL,
  `order_cost` decimal(6,2) NOT NULL,
  `order_status` varchar(100) NOT NULL,
  `user_id` int(11) NOT NULL,
  `user_phone` int(11) NOT NULL,
  `user_city` varchar(255) NOT NULL,
  `user_address` varchar(255) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`order_id`, `order_cost`, `order_status`, `user_id`, `user_phone`, `user_city`, `user_address`, `order_date`) VALUES
(6, '509.00', 'not paid', 1, 2147483647, 'teok', 'teok', '2024-04-23 09:45:20'),
(7, '796.00', 'delivered', 1, 1111111111, 'sib', 'sib', '2024-04-23 10:58:43'),
(9, '155.00', 'on_hold', 1, 2147483647, 'qwer', 'qwer', '2024-04-24 10:55:47'),
(10, '155.00', 'on_hold', 1, 0, 'asdda', 'asfas', '2024-04-24 13:16:53'),
(11, '465.00', 'on_hold', 1, 0, 'asdasd', 'adasd', '2024-04-24 13:17:11'),
(12, '465.00', 'on_hold', 1, 0, 'ascasc', 'ascasc', '2024-04-24 13:22:21'),
(13, '465.00', 'on_hold', 1, 0, 'ascas', 'ascasc', '2024-04-24 13:25:37'),
(14, '505.00', 'on_hold', 2, 1234567890, 'teok', 'teok', '2024-05-06 23:09:22'),
(15, '1515.00', 'on_hold', 2, 1234567890, 'ghy', 'ghy', '2024-05-07 20:51:54'),
(16, '199.00', 'on_hold', 2, 1234567890, 'teok', 'teok', '2024-05-08 09:57:28'),
(17, '199.00', 'on_hold', 2, 1111111111, 'teok', 'teok', '2024-05-08 13:37:20'),
(18, '199.00', 'on_hold', 2, 2147483647, 'teok', 'teok', '2024-05-08 14:38:32'),
(19, '3221.00', 'on_hold', 2, 1234567890, 'teok', 'teok', '2024-05-13 18:45:55'),
(20, '3199.00', 'on_hold', 2, 1234567899, 'teok', 'teok', '2024-05-13 19:05:53'),
(21, '708.00', 'on_hold', 2, 2147483647, 'jorhat', 'jorhat', '2024-05-13 20:22:09'),
(22, '5118.00', 'on_hold', 2, 1234567890, 'teok', 'teok', '2024-05-20 11:31:55'),
(23, '2716.00', 'paid', 2, 1234567890, 'teok', 'teok', '2024-05-20 11:51:19'),
(24, '2020.00', 'on_hold', 2, 2147483647, 'teok', 'teok', '2024-05-20 17:57:44'),
(25, '2020.00', 'paid', 2, 1111111111, 'teok', 'teok', '2024-05-20 17:59:22');

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `product_price` decimal(6,2) NOT NULL,
  `product_quantity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `product_id`, `product_name`, `product_image`, `user_id`, `order_date`, `product_price`, `product_quantity`) VALUES
(4, 6, '0', 'White Shoes', 'F1.webp', 1, '2024-04-23 09:45:20', '155.00', 2),
(5, 6, '0', 'Red coat', 'C1.jpg', 1, '2024-04-23 09:45:20', '199.00', 1),
(6, 7, '0', 'Red coat', 'C1.jpg', 1, '2024-04-23 10:58:43', '199.00', 4),
(8, 9, '0', 'White Shoes', 'F1.webp', 1, '2024-04-24 10:55:47', '155.00', 1),
(9, 10, '0', 'White Shoes', 'F1.webp', 1, '2024-04-24 13:16:53', '155.00', 1),
(10, 11, '0', 'White Shoes', 'F1.webp', 1, '2024-04-24 13:17:11', '155.00', 3),
(11, 12, '0', 'White Shoes', 'F1.webp', 1, '2024-04-24 13:22:21', '155.00', 3),
(12, 13, '0', 'White Shoes', 'F1.webp', 1, '2024-04-24 13:25:37', '155.00', 3),
(13, 14, '0', 'White Shoes', 'F1.webp', 2, '2024-05-06 23:09:22', '505.00', 1),
(14, 15, '0', 'White Shoes', 'F1.webp', 2, '2024-05-07 20:51:54', '505.00', 3),
(15, 16, '0', 'Red coat', 'C1.jpg', 2, '2024-05-08 09:57:28', '199.00', 1),
(16, 17, '0', 'Red coat', 'C1.jpg', 2, '2024-05-08 13:37:20', '199.00', 1),
(17, 18, '0', 'Red coat', 'C1.jpg', 2, '2024-05-08 14:38:32', '199.00', 1),
(18, 19, '0', 'White Shoes', 'F1.webp', 2, '2024-05-13 18:45:55', '505.00', 1),
(19, 19, '0', 'Blue Denim', 'C2.jpg', 2, '2024-05-13 18:45:55', '1201.00', 1),
(20, 19, '0', 'White Shoes', 'F1.webp', 2, '2024-05-13 18:45:55', '505.00', 3),
(21, 20, '1', 'White Shoes', 'F1.webp', 2, '2024-05-13 19:05:53', '505.00', 2),
(22, 20, '4', 'Red coat', 'C1.jpg', 2, '2024-05-13 19:05:53', '199.00', 11),
(23, 21, '2', 'White Shoes', 'F2.webp', 2, '2024-05-13 20:22:09', '177.00', 4),
(24, 22, '1', 'White Shoes', 'F1.webp', 2, '2024-05-20 11:31:55', '505.00', 3),
(25, 22, '3', 'Blue Denim', 'C2.jpg', 2, '2024-05-20 11:31:55', '1201.00', 3),
(26, 23, '1', 'White Shoes', 'F1.webp', 2, '2024-05-20 11:51:19', '505.00', 3),
(27, 23, '3', 'Blue Denim', 'C2.jpg', 2, '2024-05-20 11:51:19', '1201.00', 1),
(28, 24, '1', 'White Shoes', 'F1.webp', 2, '2024-05-20 17:57:44', '505.00', 4),
(29, 25, '1', 'White Shoes', 'F1.webp', 2, '2024-05-20 17:59:22', '505.00', 4);

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `razorpay_payment_id` varchar(255) NOT NULL,
  `payment_date` datetime DEFAULT current_timestamp(),
  `amount` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `payments`
--

INSERT INTO `payments` (`payment_id`, `order_id`, `razorpay_payment_id`, `payment_date`, `amount`) VALUES
(2, 23, '', '2024-05-20 15:23:40', '2716.00'),
(3, 23, 'pay_OCi5R0GvRnPaCA', '2024-05-20 12:10:21', '2716.00'),
(4, 25, 'pay_OCo2xCQc6rolv3', '2024-05-20 18:00:12', '2020.00');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(100) NOT NULL,
  `product_category` varchar(108) NOT NULL,
  `product_description` varchar(255) NOT NULL,
  `product_image` varchar(255) NOT NULL,
  `product_image2` varchar(255) DEFAULT NULL,
  `product_image3` varchar(255) DEFAULT NULL,
  `product_image4` varchar(255) DEFAULT NULL,
  `product_price` decimal(6,2) NOT NULL,
  `product_special_offer` int(2) DEFAULT NULL,
  `product_color` varchar(108) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_category`, `product_description`, `product_image`, `product_image2`, `product_image3`, `product_image4`, `product_price`, `product_special_offer`, `product_color`) VALUES
(1, 'White Shoes', 'shoes', 'Awsome White Shoes', 'F1.webp', 'F1.webp', 'F1.webp', 'F1.webp', '505.00', 27, 'white'),
(2, 'White Shoes', 'Shoes', 'Awsome White Shoes', 'F2.webp', 'F2.webp', 'F2.webp', 'F2.webp', '177.00', 0, 'White'),
(5, 'White Shoes', 'Shoes', 'Awsome White Shoes', 'F1.webp', 'F1.webp', 'F1.webp', 'F1.webp', '155.00', 0, 'White'),
(14, 'red shoes', 'Shoes', 'red shoes', 'red shoes1.jpeg', 'red shoes2.jpeg', 'red shoes3.jpeg', 'red shoes4.jpeg', '111.00', 11, 'red'),
(18, 'Watch One', 'Watches', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic est eveniet voluptatibus, incidunt debitis nam excepturi magnam labore error deserunt cumque minima nisi ex obcaecati accusamus voluptatem? Sequi quasi illum quidem dignissimos in quam. Quaerat ', 'Watch One1.jpeg', 'Watch One2.jpeg', 'Watch One3.jpeg', 'Watch One4.jpeg', '999.00', 10, 'white'),
(19, 'Watch Two', 'Watches', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic est eveniet voluptatibus, incidunt debitis nam excepturi magnam labore error deserunt cumque minima nisi ex obcaecati accusamus voluptatem? Sequi quasi illum quidem dignissimos in quam. Quaerat ', 'Watch Two1.jpeg', 'Watch Two2.jpeg', 'Watch Two3.jpeg', 'Watch Two4.jpeg', '1299.00', 15, 'white'),
(20, 'Watch Three', 'Watches', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic est eveniet voluptatibus, incidunt debitis nam excepturi magnam labore error deserunt cumque minima nisi ex obcaecati accusamus voluptatem? Sequi quasi illum quidem dignissimos in quam. Quaerat ', 'Watch Three1.jpeg', 'Watch Three2.jpeg', 'Watch Three3.jpeg', 'Watch Three4.jpeg', '1199.00', 10, 'blue'),
(21, 'Watch Four', 'Watches', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic est eveniet voluptatibus, incidunt debitis nam excepturi magnam labore error deserunt cumque minima nisi ex obcaecati accusamus voluptatem? Sequi quasi illum quidem dignissimos in quam. Quaerat ', 'Watch Four1.jpeg', 'Watch Four2.jpeg', 'Watch Four3.jpeg', 'Watch Four4.jpeg', '899.00', 10, 'red'),
(22, 'Coat One', 'clothes', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic est eveniet voluptatibus, incidunt debitis nam excepturi magnam labore error deserunt cumque minima nisi ex obcaecati accusamus voluptatem? Sequi quasi illum quidem dignissimos in quam. Quaerat ', 'Coat One1.jpeg', 'Coat One2.jpeg', 'Coat One3.jpeg', 'Coat One4.jpeg', '549.00', 8, 'red'),
(24, 'Coat three', 'clothes', 'Lorem ipsum dolor sit amet consectetur adipisicing elit. Hic est eveniet voluptatibus, incidunt debitis nam excepturi magnam labore error deserunt cumque minima nisi ex obcaecati accusamus voluptatem? Sequi quasi illum quidem dignissimos in quam. Quaerat ', 'Coat three1.jpeg', 'Coat three2.jpeg', 'Coat three3.jpeg', 'Coat three4.jpeg', '799.00', 10, 'white');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(108) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `user_name`, `user_email`, `user_password`) VALUES
(1, 'Dhritiman', 'dhriti@gmail.com', '7c222fb2927d828af22f592134e8932480637c0d'),
(2, 'admin', 'admin@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admins`
--
ALTER TABLE `admins`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `colors`
--
ALTER TABLE `colors`
  ADD PRIMARY KEY (`col_id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `UX_Constraint` (`user_email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admins`
--
ALTER TABLE `admins`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `colors`
--
ALTER TABLE `colors`
  MODIFY `col_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `payments_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
