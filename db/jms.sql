-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 11, 2019 at 08:49 PM
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
(1, 'Gold', 1, 0, '2019-04-29 19:51:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(2, 'Silver', 2, 0, '2019-04-29 19:51:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0);

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
  `deleted_at` datetime NOT NULL,
  `created_by` int(11) NOT NULL,
  `deleted_by` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `gst`
--

INSERT INTO `gst` (`gst_id`, `hsn_code`, `gst_rate`, `wef`, `deleted`, `created_at`, `deleted_at`, `created_by`, `deleted_by`) VALUES
(1, 7113, 3, '2017-07-22', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0),
(2, 7106, 3, '2017-07-22', 0, '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `invoices`
--

CREATE TABLE `invoices` (
  `invoice_id` int(11) NOT NULL,
  `invoice_no` varchar(20) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `total_amount` double NOT NULL,
  `invoice_date` date NOT NULL,
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
  `making_charges` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `payment_of` varchar(255) NOT NULL,
  `fk_id` int(11) NOT NULL,
  `payment_amount` double NOT NULL,
  `payment_date` date NOT NULL,
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
  `product_label` int(11) NOT NULL,
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

INSERT INTO `products` (`product_id`, `product_name`, `product_label`, `product_quantity`, `additional_specifications`, `category_id`, `deleted`, `created_at`, `updated_at`, `deleted_at`, `created_by`, `updated_by`, `deleted_by`) VALUES
(8, 'haar', 1, 9, '', 1, 1, '2019-06-03 12:51:41', '0000-00-00 00:00:00', '2019-06-04 10:45:32', 0, 0, 0),
(9, 'haar', 2, 15.2, '92\r\n', 1, 0, '2019-06-03 12:54:32', '2019-06-04 10:50:09', '0000-00-00 00:00:00', 0, 0, 0),
(10, 'haar', 3, 15.57, '92', 1, 0, '2019-06-03 12:55:29', '2019-06-04 10:52:14', '0000-00-00 00:00:00', 0, 0, 0),
(11, 'haar', 4, 8.09, '', 1, 0, '2019-06-03 12:56:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(12, 'haar', 5, 10.48, '', 1, 0, '2019-06-03 12:57:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(13, 'haar', 6, 12.92, '', 1, 0, '2019-06-03 12:58:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(14, 'ms', 1, 4.72, '', 1, 0, '2019-06-03 13:01:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(15, 'ms', 2, 4.55, '', 1, 0, '2019-06-03 13:02:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(16, 'ms', 3, 7.46, '', 1, 0, '2019-06-03 13:03:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(17, 'ms', 4, 6.16, '', 1, 0, '2019-06-03 13:04:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(18, 'ms', 5, 5.3, '', 1, 0, '2019-06-03 13:05:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(19, 'ms', 6, 5.12, '', 1, 0, '2019-06-03 13:06:23', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(20, 'ms', 7, 7.63, '', 1, 0, '2019-06-03 13:07:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(21, 'ms', 8, 6.31, '', 1, 0, '2019-06-03 13:08:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(22, 'ms', 9, 6.25, '', 1, 0, '2019-06-03 13:09:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(23, 'ms', 10, 12.94, 'stock main se liya 4/6/19', 1, 0, '2019-06-03 13:10:19', '2019-06-04 10:41:45', '0000-00-00 00:00:00', 0, 0, 0),
(24, 'ms', 11, 12.39, '', 1, 0, '2019-06-03 13:11:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(25, 'ms', 12, 11.55, '', 1, 0, '2019-06-03 13:11:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(26, 'ms', 13, 25.97, '', 1, 0, '2019-06-03 13:12:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(27, 'ms', 14, 18.47, '', 1, 0, '2019-06-03 13:13:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(28, 'ms', 15, 19.75, '', 1, 0, '2019-06-03 13:14:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(29, 'ms', 16, 8.31, '', 1, 0, '2019-06-03 13:16:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(30, 'ms', 17, 13.65, '', 1, 0, '2019-06-03 13:18:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(31, 'ms', 18, 12.55, '', 1, 0, '2019-06-03 13:19:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(32, 'ms', 19, 9.27, '', 1, 0, '2019-06-03 13:19:53', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(33, 'ms', 20, 10.09, '', 1, 0, '2019-06-03 13:20:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(34, 'ms', 21, 12.37, '', 1, 0, '2019-06-03 13:21:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(35, 'ms', 22, 6.77, '', 1, 0, '2019-06-03 13:23:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(36, 'ms', 23, 6.07, '', 1, 0, '2019-06-03 13:25:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(37, 'ms', 24, 6.33, '', 1, 0, '2019-06-03 13:26:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(38, 'ms', 25, 13.55, '', 1, 0, '2019-06-03 13:27:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(39, 'ms', 26, 12.68, '', 1, 0, '2019-06-03 13:28:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(40, 'ms', 27, 15.27, '', 1, 0, '2019-06-03 13:29:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(41, 'ms', 28, 9.79, '', 1, 0, '2019-06-03 13:30:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(42, 'ms', 29, 12.26, '', 1, 0, '2019-06-03 13:31:24', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(43, 'haar', 1, 9, '', 1, 0, '2019-06-04 10:46:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(44, 'ms', 30, 27.41, '9.16', 1, 0, '2019-06-04 19:41:10', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(45, 'ms', 31, 51.33, 'yogita sinde odar', 1, 0, '2019-06-04 19:42:43', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(46, 'ms', 32, 30.42, '9.16', 1, 0, '2019-06-04 19:46:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(47, 'ms', 33, 23.34, '9.16', 1, 0, '2019-06-04 19:49:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(48, 'ms', 34, 29, 'vati ke sath tha vati dusare ko de diya 34.600 total tha', 1, 0, '2019-06-04 20:01:19', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(49, 'ms', 35, 18.09, '9.16', 1, 0, '2019-06-04 20:10:36', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(50, 'ms', 36, 19.83, '9.16', 1, 0, '2019-06-04 20:11:37', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(51, 'ms', 37, 19.48, '9.16', 1, 0, '2019-06-04 20:12:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(52, 'ms', 38, 19.54, '9.16', 1, 0, '2019-06-04 20:13:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(53, 'ms', 39, 19.99, '9.16', 1, 0, '2019-06-04 20:15:11', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(54, 'ms', 40, 20.84, '9.16', 1, 0, '2019-06-04 20:16:54', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(55, 'ms', 41, 20.63, '9.16', 1, 0, '2019-06-04 20:17:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(56, 'ms', 42, 21.43, '9.16', 1, 0, '2019-06-04 20:18:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(57, 'ms', 43, 4.42, '9.16', 1, 0, '2019-06-04 20:24:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(58, 'ms', 44, 5.85, '9.16', 1, 0, '2019-06-04 20:26:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(59, 'ms', 45, 4.67, '9.16', 1, 0, '2019-06-04 20:27:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(60, 'ms', 46, 7.42, '9.16', 1, 0, '2019-06-04 20:28:40', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(61, 'ms', 47, 6.35, '9.16', 1, 0, '2019-06-04 20:30:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(62, 'ms', 48, 6.34, '9.16', 1, 0, '2019-06-04 20:43:03', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(63, 'ms', 49, 8.39, '9.16', 1, 0, '2019-06-04 20:44:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(64, 'ms', 50, 7.4, '9.16', 1, 0, '2019-06-04 20:45:22', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(65, 'ms', 51, 5.02, '9.16', 1, 0, '2019-06-06 12:19:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(66, 'ms', 52, 5.72, '9.16', 1, 0, '2019-06-06 12:20:35', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(67, 'ms', 53, 6.28, '9.16', 1, 0, '2019-06-06 12:21:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(68, 'ms', 54, 7.45, '9.16', 1, 0, '2019-06-06 12:22:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(69, 'ms', 55, 5.26, '9.16', 1, 0, '2019-06-06 12:24:32', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(70, 'ms', 56, 7.16, '9.16', 1, 0, '2019-06-06 12:25:42', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(71, 'ms', 57, 5.5, '9.16', 1, 0, '2019-06-06 12:27:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(72, 'ms', 58, 5.31, '9.16', 1, 0, '2019-06-06 12:29:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(73, 'ms', 59, 4.17, '9.16', 1, 0, '2019-06-06 12:31:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(74, 'ms', 60, 4.1, '9.16 magota', 1, 0, '2019-06-06 12:34:27', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(75, 'ms', 61, 11.73, '9.16', 1, 0, '2019-06-06 12:38:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(76, 'ms', 62, 7.06, '9.16', 1, 0, '2019-06-06 12:39:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(77, 'ms', 63, 5.79, '9.16', 1, 0, '2019-06-06 12:40:08', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(78, 'ms', 64, 5.66, '9.16', 1, 0, '2019-06-06 12:40:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(79, 'ms', 65, 4.97, '9.16', 1, 0, '2019-06-06 12:42:47', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(80, 'ms', 66, 5.72, '9.16', 1, 0, '2019-06-06 12:44:39', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(81, 'ms', 67, 8.45, '9.16', 1, 0, '2019-06-06 12:45:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(82, 'ms', 68, 8.22, '9.16', 1, 0, '2019-06-06 12:46:50', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(83, 'ms', 69, 10.06, '9.16', 1, 1, '2019-06-06 12:53:50', '0000-00-00 00:00:00', '2019-06-06 12:55:56', 0, 0, 0),
(84, 'ms', 69, 10.92, '9.16', 1, 0, '2019-06-06 13:04:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(85, 'ms', 70, 10.06, '9.16', 1, 0, '2019-06-06 13:04:45', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(86, 'ms', 71, 10.22, '9.16', 1, 0, '2019-06-06 13:07:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(87, 'chain', 1, 4.6, '9.1`6 nisha kumhar odar', 1, 0, '2019-06-06 19:38:30', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(88, 'chain', 2, 6.25, '9.16', 1, 0, '2019-06-06 19:39:38', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(89, 'chain', 3, 6.9, 'shidhi jhadav sel', 1, 0, '2019-06-06 19:40:56', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(90, 'chain', 4, 5.88, '9.16', 1, 0, '2019-06-06 19:42:16', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(91, 'chain', 5, 11.5, '9.16', 1, 1, '2019-06-06 19:43:13', '0000-00-00 00:00:00', '2019-06-06 19:45:57', 0, 0, 0),
(92, 'chain', 6, 5.85, '9.16', 1, 0, '2019-06-06 19:44:06', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(93, 'chain', 5, 25.94, '9.16', 1, 0, '2019-06-06 19:47:34', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(94, 'chain', 7, 7.04, '9.16', 1, 0, '2019-06-06 19:49:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(95, 'chain', 8, 9.46, '9.16', 1, 0, '2019-06-06 19:50:13', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(96, 'chain', 9, 13.27, '9.16', 1, 0, '2019-06-06 19:52:01', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(97, 'chain', 10, 12.57, '9.16', 1, 0, '2019-06-06 19:56:14', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(98, 'chain', 11, 12.79, '9.16', 1, 0, '2019-06-06 19:56:59', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(99, 'chain', 12, 11.75, '9.16', 1, 0, '2019-06-06 19:58:21', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(100, 'chain', 13, 18.03, '9.16', 1, 0, '2019-06-06 19:59:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(101, 'chain', 14, 16.51, '9.16', 1, 0, '2019-06-06 20:00:05', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(102, 'chain', 15, 14.51, '9.16', 1, 0, '2019-06-06 20:01:12', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(103, 'chain', 16, 12.86, '9.16', 1, 0, '2019-06-06 20:02:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(104, 'ms', 72, 18, '', 1, 0, '2019-06-06 20:09:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(105, 'chain', 17, 8.48, '9.16', 1, 0, '2019-06-06 20:14:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(106, 'chain', 18, 7.4, '9.16', 1, 0, '2019-06-06 20:16:15', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(107, 'chain', 19, 10.1, '9.16', 1, 0, '2019-06-06 20:17:52', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(108, 'chain', 20, 1.59, '9.16', 1, 0, '2019-06-06 20:18:46', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(109, 'chain', 21, 14.89, '9.16', 1, 0, '2019-06-06 20:19:49', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(110, 'chain', 22, 20.66, '9.16', 1, 0, '2019-06-06 20:21:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(111, 'chain', 23, 11.73, '9.16', 1, 0, '2019-06-06 20:22:02', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(112, 'chain', 24, 7.54, '9.16', 1, 0, '2019-06-06 20:22:58', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(113, 'haar', 7, 8.7, '9.16', 1, 0, '2019-06-08 12:34:29', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(114, 'haar', 8, 23.72, '9.16', 1, 0, '2019-06-08 12:35:31', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(115, 'haar', 9, 41.35, 'odar', 1, 0, '2019-06-08 12:37:44', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(116, 'haar', 10, 17.62, '9.16', 1, 0, '2019-06-08 12:41:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(117, 'haar', 11, 23.3, '9.16', 1, 0, '2019-06-08 12:50:07', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(118, 'haar', 12, 9.71, '9.16', 1, 0, '2019-06-08 12:52:18', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(119, 'haar', 13, 26.02, '9.16 sidhi medam virar sel', 1, 0, '2019-06-08 12:56:41', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(120, 'haar', 14, 21.2, '9.16 odar', 1, 0, '2019-06-08 12:59:48', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0),
(121, 'ms', 73, 8.16, '9.16', 1, 0, '2019-06-09 16:59:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `purchases`
--

CREATE TABLE `purchases` (
  `purchase_id` int(11) NOT NULL,
  `supplier_detail` varchar(255) NOT NULL,
  `purchase_no` varchar(255) NOT NULL,
  `purchase_quantity` double NOT NULL,
  `purchase_rate` double NOT NULL,
  `date_of_purchase` date NOT NULL,
  `total_purchase_amount` double NOT NULL,
  `pending_amount` double NOT NULL,
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
-- Table structure for table `udhaari`
--

CREATE TABLE `udhaari` (
  `udhaari_id` int(11) NOT NULL,
  `udhaari_no` varchar(255) NOT NULL,
  `customer_id` int(11) NOT NULL,
  `udhaari_amount` double NOT NULL,
  `pending_amount` double NOT NULL,
  `udhaari_date` date NOT NULL,
  `due_date` date NOT NULL,
  `deleted` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
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
  `token` varchar(255) NOT NULL,
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
-- Indexes for table `payments`
--
ALTER TABLE `payments`
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
-- Indexes for table `udhaari`
--
ALTER TABLE `udhaari`
  ADD PRIMARY KEY (`udhaari_id`);

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
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `customer_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1011;

--
-- AUTO_INCREMENT for table `gst`
--
ALTER TABLE `gst`
  MODIFY `gst_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `invoices`
--
ALTER TABLE `invoices`
  MODIFY `invoice_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=122;

--
-- AUTO_INCREMENT for table `purchases`
--
ALTER TABLE `purchases`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `udhaari`
--
ALTER TABLE `udhaari`
  MODIFY `udhaari_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
