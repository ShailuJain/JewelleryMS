-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2019 at 11:37 AM
-- Server version: 10.1.38-MariaDB
-- PHP Version: 7.3.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `jms`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL,
  `gst_id` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`, `gst_id`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'GOLD', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(2, 'SILVER', 2, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(3, 'Artificial', 3, 0, '2019-04-09 19:21:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(4, 'New Category', 3, 0, '2019-04-11 21:00:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `customer_id` int(11) NOT NULL,
  `customer_name` varchar(255) NOT NULL,
  `customer_address` text NOT NULL,
  `customer_email` varchar(255) NOT NULL,
  `customer_contact` varchar(13) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`customer_id`, `customer_name`, `customer_address`, `customer_email`, `customer_contact`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Nikhil', 'Ulhasnagar', 'nnagdev58@gmail.com', '9876543210', 0, '2019-04-02 01:46:26', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(2, 'Shailesh Jain', 'Solitaire heights, shivaji nagar, opp sona hospital\r\nVakola, Santacruz east', 'jainshailu91@gmail.com', '07021682429', 0, '2019-04-02 01:59:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(11, 'New Customer', 'And again One Edit New Address', 'newcustomer@gmail.com', '12323421221', 1, '2019-04-07 22:11:54', '2019-04-07 23:36:14', '2019-04-07 23:36:19', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `gst`
--

CREATE TABLE `gst` (
  `gst_id` int(11) NOT NULL,
  `hsn_code` int(11) NOT NULL,
  `gst_rate` double NOT NULL,
  `wef` date NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`gst_id`, `hsn_code`, `gst_rate`, `wef`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `deleted_by`, `updated_by`) VALUES
(1, 7113, 3, '2019-03-31', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(2, 7106, 3, '2019-03-31', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(3, 7106, 6, '2019-04-09', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(4, 7113, 9, '2019-04-30', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(5, 74102, 9, '2019-04-12', 0, '2019-04-12 22:59:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `pending_amount` double NOT NULL,
  `due_date` date NOT NULL,
  `invoice_date` datetime NOT NULL,
  `deleted` int(1) NOT NULL,
  `created_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL,
  `updated_at` date NOT NULL,
  `updated_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `invoice_product`
--

CREATE TABLE `invoice_product` (
  `invoice_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_rate` double NOT NULL,
  `quantity` double NOT NULL,
  `unit` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payment`
--

CREATE TABLE `payment` (
  `payment_id` int(11) NOT NULL,
  `invoice_id` int(11) NOT NULL,
  `payment_amount` double NOT NULL,
  `payment_date` datetime NOT NULL,
  `payment_mode` varchar(15) NOT NULL,
  `created_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_at` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted` int(2) NOT NULL,
  `deleted_at` datetime NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `product_name` varchar(255) NOT NULL,
  `product_quantity` double NOT NULL,
  `additional_specifications` text NOT NULL,
  `category_id` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `product_name`, `product_quantity`, `additional_specifications`, `category_id`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(1, 'Gold ring', 100, '', 1, 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(2, 'ring', 50, '', 2, 0, '2019-03-26 18:17:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(3, 'Necklace', 100, 'Gold necklace', 1, 0, '2019-03-28 16:09:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(4, 'Mangalsutra', 200, '', 1, 0, '2019-03-28 16:11:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(5, 'Baali', 100, '', 1, 0, '2019-03-28 16:15:54', '2019-04-06 04:17:46', '0000-00-00 00:00:00', 0, 0, 0),
(6, 'Ear Ring', 32, 'Ear', 1, 0, '2019-03-28 17:40:13', '2019-04-06 16:15:43', '0000-00-00 00:00:00', 0, 0, 0),
(8, 'Bracelet', 800, '', 1, 0, '2019-03-28 20:54:00', '2019-04-03 12:34:33', '0000-00-00 00:00:00', 0, 0, 0),
(14, 'Earring', 35, '', 1, 1, '2019-03-29 14:38:04', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(15, 'Bangles', 500, '', 1, 0, '2019-03-29 14:43:44', '2019-04-03 10:21:36', '0000-00-00 00:00:00', 0, 0, 0),
(16, 'Bichhudi', 342, '', 2, 0, '2019-03-29 15:19:45', '2019-04-06 04:19:21', '0000-00-00 00:00:00', 0, 0, 0),
(21, 'Some Product', 100, 'Session will start now', 1, 1, '2019-04-06 12:06:33', '2019-04-06 16:23:17', '2019-04-06 16:40:02', 0, 0, 0),
(22, 'Edit New Product one more time', 234, 'One more Edit New Product', 1, 1, '2019-04-06 15:00:10', '2019-04-07 00:17:38', '2019-04-07 22:16:18', 0, 0, 0),
(23, 'New product', 23, '', 1, 1, '2019-04-06 15:37:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(24, 'dfhgjk', 778509, '', 1, 1, '2019-04-07 00:17:16', '0000-00-00 00:00:00', '2019-04-07 00:17:50', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `date_of_purchase` date NOT NULL,
  `total_purchase_amount` double NOT NULL,
  `gst_id` int(11) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_product`
--

CREATE TABLE `purchase_product` (
  `purchase_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rate_of_purchase` double NOT NULL,
  `quantity_purchased` double NOT NULL,
  `unit` varchar(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `purchase_supplier`
--

CREATE TABLE `purchase_supplier` (
  `purchase_id` int(11) NOT NULL,
  `supplier_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL,
  `access_rights` text NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `suppliers`
--

CREATE TABLE `suppliers` (
  `supplier_id` int(11) NOT NULL,
  `supplier_name` varchar(255) NOT NULL,
  `supplier_shopname` varchar(255) NOT NULL,
  `supplier_address` text NOT NULL,
  `supplier_contact` varchar(10) NOT NULL,
  `supplier_email` varchar(255) NOT NULL,
  `gst_no` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `user_contact` varchar(10) NOT NULL,
  `user_email` varchar(255) NOT NULL,
  `user_address` text NOT NULL,
  `role_id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL,
  `deleted` int(1) NOT NULL DEFAULT '0',
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime NOT NULL,
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`customer_id`);

--
-- Indexes for table `gst`
--
ALTER TABLE `gst`
  ADD PRIMARY KEY (`gst_id`);

--
-- Indexes for table `invoices`
--
ALTER TABLE `invoices`
  ADD PRIMARY KEY (`invoice_id`);

--
-- Indexes for table `invoice_product`
--
ALTER TABLE `invoice_product`
  ADD PRIMARY KEY (`invoice_id`,`product_id`);

--
-- Indexes for table `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`payment_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `purchases`
--
ALTER TABLE `purchases`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `purchase_product`
--
ALTER TABLE `purchase_product`
  ADD PRIMARY KEY (`purchase_id`,`product_id`);

--
-- Indexes for table `purchase_supplier`
--
ALTER TABLE `purchase_supplier`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexes for table `suppliers`
--
ALTER TABLE `suppliers`
  ADD PRIMARY KEY (`supplier_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `gst_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment`
--
ALTER TABLE `payment`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `suppliers`
--
ALTER TABLE `suppliers`
  MODIFY `supplier_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
