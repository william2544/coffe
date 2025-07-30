-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 05, 2025 at 03:06 PM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `coffee_shop`
--

-- --------------------------------------------------------

--
-- Table structure for table `delivery_areas`
--

CREATE TABLE `delivery_areas` (
  `id` int(11) NOT NULL,
  `area_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_areas`
--

INSERT INTO `delivery_areas` (`id`, `area_name`) VALUES
(1, 'Thika Town'),
(2, 'Runda'),
(3, 'Bidco'),
(4, 'Pilot'),
(5, 'Biafra'),
(6, 'En Gen');

-- --------------------------------------------------------

--
-- Table structure for table `delivery_persons`
--

CREATE TABLE `delivery_persons` (
  `id` int(11) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `delivery_area` varchar(100) DEFAULT NULL,
  `status` enum('Available','Busy') DEFAULT 'Available'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `delivery_persons`
--

INSERT INTO `delivery_persons` (`id`, `name`, `phone`, `delivery_area`, `status`) VALUES
(1, 'James Mwangi', '0712345678', NULL, ''),
(2, 'Ann Njeri', '0723456789', NULL, ''),
(3, 'Kevin Otieno', '0734567890', NULL, 'Available'),
(4, 'Faith Wambui', '0745678901', NULL, 'Available'),
(5, 'Brian Kiptoo', '0756789012', NULL, 'Available'),
(6, 'Mercy Achieng', '0767890123', NULL, 'Available'),
(7, 'Samuel Kariuki', '0778901234', NULL, 'Available'),
(8, 'Cynthia Muthoni', '0789012345', NULL, 'Available'),
(9, 'George Kimani', '0790123456', NULL, 'Available'),
(10, 'Diana Chebet', '0701234567', NULL, 'Available');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `stock_quantity` int(11) NOT NULL DEFAULT '0',
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`id`, `name`, `amount`, `stock_quantity`, `image`) VALUES
(1, 'Coffee', '150.00', 12, 'images/coffee2.jpeg'),
(2, 'Irish coffee milkshake', '450.00', 9, 'images/Irish coffee milkshake.jpeg'),
(3, 'Cappuccino', '300.00', 12, 'images/capuccino.jpeg'),
(4, 'Iced Mocha', '400.00', 10, 'images/Iced Mocha.jpeg'),
(5, 'Iced Caramel Latte', '350.00', 9, 'images/Iced Caramel Latte.jpeg'),
(6, 'Coffee Milkshake', '400.00', 12, 'images/Coffee Milkshake.jpeg'),
(7, 'Chocolate Coffee', '200.00', 7, 'images/Chocolate Coffee.jpeg'),
(8, 'Latte', '150.00', 6, 'images/Latte.jpeg'),
(9, 'Iced Coffee', '250.00', 5, 'images/Iced Coffee.jpeg'),
(10, 'Latte Macchiato', '350.00', 8, 'images/Latte Macchiato.jpeg'),
(11, 'Oreo Iced Coffee', '300.00', 3, 'images/Oreo Iced Coffee.jpeg'),
(12, 'Salted Caramel Macchiato', '450.00', 1, 'images/Salted Caramel Macchiato.jpeg'),
(13, 'Donuts (pineapple flavoured)', '150.00', 25, 'images/Pineapple  Donuts.jpeg'),
(14, 'Sausage Rolls', '150.00', 16, 'images/Sausage Rolls.jpeg'),
(15, 'Cherry Pies', '150.00', 11, 'images/Cherry Pastry Pies.jpeg'),
(16, 'Cheesecake Cupcakes', '50.00', 28, 'images/Cheesecake Cupcakes.jpeg'),
(17, 'Peanut Butter Muffins', '40.00', 11, 'images/Chocolate Peanut Butter Swirl Muffins.jpeg'),
(18, 'Chocolate Tiramisu', '120.00', 7, 'images/Chocolate Tiramisu.jpeg'),
(19, 'Ham and Cheese Pinwheels', '80.00', 12, 'images/Ham and cheese pastry pinwheels.jpeg'),
(20, 'Mocha Ice Cream Cake', '250.00', 10, 'images/Mocha Ice Cream Cake.jpeg'),
(21, 'Pecan Caramel Rum Cake', '270.00', 12, 'images/Pecan caramel rum cake.jpeg'),
(22, 'Strawberry Cheesecake', '250.00', 13, 'images/Strawberry Cheesecake.jpeg'),
(23, 'Pink Drip Cake', '2500.00', 2, 'images/Pink Drip Cake.jpeg'),
(24, 'Oreo Cake', '3000.00', 1, 'images/Oreo Cake.jpeg'),
(25, 'Chocolate Cake', '2500.00', 4, 'images/Chocolate Cake.jpeg'),
(26, 'Red Velvet Cake', '2500.00', 2, 'images/red velvet cake.jpeg'),
(27, 'Salted Caramel Cake', '3000.00', 3, 'images/Salted Caramel Cake.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `Order_id` int(25) NOT NULL,
  `transaction_id` varchar(255) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `phone_number` varchar(15) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `status` varchar(20) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `address` varchar(255) NOT NULL,
  `receipt_number` varchar(255) NOT NULL,
  `delivery_person_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `password`, `created_at`) VALUES
(1, 'Admin', 'admin@gmail.com', '$2y$10$seDQgRJiUQ9bQ9mogqmON.Qlbf7GajArya/ARgJDJQIaFyOPqtGLy', '2025-01-18 14:33:57'),
(2, 'Alice', 'jkhnj@gmail', '$2y$10$SgyFd5VFkB1yxjvaXzwrpeXa4xCHEcfgRYE46pjGm/IGtrCrwKrqq', '2025-01-18 14:35:57'),
(3, 'max', 'max@gmail.com', '$2y$10$OTgOAYRvGqqBX9wn4Y552O7iFIBZsbM/8gXUYuwWgKDrFkdNM1Hci', '2025-01-18 14:38:51'),
(4, 'ghjjhjklm', 'jkhnfj@gmail', '$2y$10$1dK5q2adeJCgxBFm0U7xiu0iRV5218iLD/Ms0E8aN6QxM4S4MSoeq', '2025-01-18 14:42:36'),
(5, 'william', 'william@gmail.com', '$2y$10$z/wR3P58o5RMEMfFPvqWFeMsxkMGPZEtouaXCrIZJVTHC5OXuw6Ae', '2025-06-03 07:12:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `delivery_areas`
--
ALTER TABLE `delivery_areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_persons`
--
ALTER TABLE `delivery_persons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`Order_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `delivery_areas`
--
ALTER TABLE `delivery_areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `delivery_persons`
--
ALTER TABLE `delivery_persons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `Order_id` int(25) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
