-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 22, 2023 at 02:44 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.3.20

SET FOREIGN_KEY_CHECKS=0;
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `laravel8_starter_spatie`
--

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'permissions-list', 'web', '2023-09-22 05:54:23', '2023-09-22 05:54:23'),
(2, 'permissions-create', 'web', '2023-09-22 05:54:23', '2023-09-22 05:54:23'),
(3, 'permissions-edit', 'web', '2023-09-22 05:54:23', '2023-09-22 05:54:23'),
(4, 'permissions-delete', 'web', '2023-09-22 05:54:23', '2023-09-22 05:54:23'),
(5, 'roles-list', 'web', '2023-09-22 05:56:28', '2023-09-22 05:56:28'),
(6, 'roles-create', 'web', '2023-09-22 05:56:28', '2023-09-22 05:56:28'),
(7, 'roles-edit', 'web', '2023-09-22 05:56:28', '2023-09-22 05:56:28'),
(8, 'roles-delete', 'web', '2023-09-22 05:56:28', '2023-09-22 05:56:28'),
(9, 'users-list', 'web', '2023-09-22 06:03:00', '2023-09-22 06:03:00'),
(10, 'users-create', 'web', '2023-09-22 06:03:00', '2023-09-22 06:03:00'),
(11, 'users-edit', 'web', '2023-09-22 06:03:00', '2023-09-22 06:03:00'),
(12, 'users-delete', 'web', '2023-09-22 06:03:00', '2023-09-22 06:03:00'),
(13, 'dashboard', 'web', '2023-09-22 06:03:00', '2023-09-22 06:03:00');

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `guard_name`, `created_at`, `updated_at`) VALUES
(1, 'Super Admin', 'web', '2023-09-22 06:17:38', '2023-09-22 06:17:38'),
(2, 'Admin', 'web', '2023-09-22 06:35:05', '2023-09-22 06:35:05'),
(3, 'User', 'web', '2023-09-22 06:35:05', '2023-09-22 06:35:05');

--
-- Dumping data for table `role_has_permissions`
--

INSERT INTO `role_has_permissions` (`permission_id`, `role_id`) VALUES
(1, 1),
(2, 1),
(3, 1),
(4, 1),
(5, 1),
(6, 1),
(7, 1),
(8, 1),
(9, 1),
(9, 2),
(10, 1),
(10, 2),
(11, 1),
(11, 2),
(12, 1),
(12, 2),
(13, 1),
(13, 2),
(13, 3);
SET FOREIGN_KEY_CHECKS=1;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
