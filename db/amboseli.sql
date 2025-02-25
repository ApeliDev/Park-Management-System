-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 03, 2024 at 05:33 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `amboseli`
--

-- --------------------------------------------------------

--
-- Table structure for table `bookings`
--

CREATE TABLE `bookings` (
  `booking_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(150) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `visit_date` date NOT NULL,
  `number_of_people` int(11) NOT NULL,
  `transaction_code` varchar(50) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `bookings`
--

INSERT INTO `bookings` (`booking_id`, `first_name`, `last_name`, `email`, `phone`, `visit_date`, `number_of_people`, `transaction_code`, `ticket_number`, `created_at`, `updated_at`) VALUES
(2, 'Apeli', 'tonny', 'livingstoneapeli@gmail.com', '0703416091', '2025-01-03', 3, '0', 'AMNP-674C7A102BE31', '2024-12-01 15:00:32', '2024-12-01 15:00:32'),
(3, 'Tonny', 'Apeli', 'livingstoneapeli@gmail.com', '0703416091', '2024-12-26', 5, '0', 'AMNP-674C7BA2C0FF8', '2024-12-01 15:07:14', '2024-12-01 15:07:14'),
(4, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', '2024-12-27', 2, '0', 'AMNP-674C8848DF539', '2024-12-01 16:01:12', '2024-12-01 16:01:12'),
(5, 'Tedd', 'Deo', 'marshtedd9@gmail.com', '0703416091', '2024-12-28', 5, '0', 'AMNP-674DF8093A0DC', '2024-12-02 18:10:17', '2024-12-02 18:10:17');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `attempt_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `attempt_time` timestamp NOT NULL DEFAULT current_timestamp(),
  `ip_address` varchar(45) DEFAULT NULL,
  `status` enum('success','failure') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `park_gallery`
--

CREATE TABLE `park_gallery` (
  `id` int(11) NOT NULL,
  `image_path` varchar(255) NOT NULL,
  `caption` varchar(255) DEFAULT NULL,
  `uploaded_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `park_gallery`
--

INSERT INTO `park_gallery` (`id`, `image_path`, `caption`, `uploaded_at`) VALUES
(1, 'uploads/gallery/8f885e2f-d506-429c-a693-25dc1c1d00e0.jpeg', 'lions', '2024-12-03 02:57:48'),
(2, 'uploads/gallery/8af135e5-0162-48c2-9a11-73c12d1918ca.jpeg', '', '2024-12-03 02:58:02'),
(5, 'uploads/gallery/97dc5c97-aff9-4d55-b70b-6ea6d123ae5c.jpeg', '', '2024-12-03 02:58:44'),
(6, 'uploads/gallery/af063d1b-ea7f-4668-89e2-eda6faa5a1da.jpeg', '', '2024-12-03 02:59:39');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `reset_token` varchar(64) NOT NULL,
  `reset_expires` datetime NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `password_resets`
--

INSERT INTO `password_resets` (`id`, `user_id`, `reset_token`, `reset_expires`, `created_at`) VALUES
(5, 12, 'cdb35ee7a575c0459a8dbeeaf22ecd4e71f91934a36e37cc34f9b0fb2e4ae623', '2024-12-02 20:05:38', '2024-12-02 18:05:38');

-- --------------------------------------------------------

--
-- Table structure for table `support_inquiries`
--

CREATE TABLE `support_inquiries` (
  `id` int(11) NOT NULL,
  `user_name` varchar(100) NOT NULL,
  `user_email` varchar(100) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `reply` text DEFAULT NULL,
  `status` enum('Pending','Replied','Resolved') NOT NULL DEFAULT 'Pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `support_inquiries`
--

INSERT INTO `support_inquiries` (`id`, `user_name`, `user_email`, `subject`, `message`, `reply`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Livingstone Apeli', 'livingstoneapeli@gmail.com', 'Payment Problem', 'Hello please assist me with processing of my payment that I made yesterday but no reflection was made.', 'Please share the transaction code with us so that we can help you further.', 'Replied', '2024-12-03 01:39:28', '2024-12-03 02:02:53'),
(2, 'Tedd Deo', 'marshtedd9@gmail.com', 'Booking Issue', 'I have a problem weth booking and I don\'t have the payment methods provided below kindly help.', 'Which payment method are you able to use currently? Kindly provide the details to assist us process your booking.', 'Replied', '2024-12-03 02:27:10', '2024-12-03 02:28:45');

-- --------------------------------------------------------

--
-- Table structure for table `tours`
--

CREATE TABLE `tours` (
  `tour_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `capacity` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tours`
--

INSERT INTO `tours` (`tour_id`, `name`, `description`, `date`, `time`, `price`, `capacity`, `created_at`, `updated_at`, `image_path`) VALUES
(4, 'gttt', 'tttt', '2024-12-18', '07:15:00', 788.00, 8, '2024-12-03 04:14:48', '2024-12-03 04:14:48', 'uploads/tours/amboseli_674e85b8de52d0.23315261.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `transaction_codes`
--

CREATE TABLE `transaction_codes` (
  `id` int(11) NOT NULL,
  `transaction_code` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transaction_codes`
--

INSERT INTO `transaction_codes` (`id`, `transaction_code`, `created_at`) VALUES
(1, 'TXN12345ABC', '2024-12-01 13:52:53'),
(2, 'TXN67890XYZ', '2024-12-01 13:52:53'),
(3, 'TXN54321DEF', '2024-12-01 13:52:53');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin','staff') NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone_number` varchar(15) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `role`, `email`, `phone_number`, `created_at`, `updated_at`) VALUES
(8, 'apeli', '$2y$10$8XHox.gBDgdhrTcS7JxSgOFdrDRhOsNYJgkhFMFFTvbh4YvimqDF2', 'admin', 'info@apelisolutions.com', '0703416091', '2024-12-02 09:02:21', '2024-12-02 09:02:21'),
(10, 'Tonny', '$2y$10$ILT.dZhUMyB2oI62bY7KoOzmN8gE1rVvqp4zQqHTOrxeXWHQogB/C', 'admin', 'livingstoneapeli@gmail.com', '0703416091', '2024-12-02 09:04:14', '2024-12-02 21:19:59'),
(12, 'Midina', '$2y$10$g/3C8bnuOzYjW2AdDGjrUOnpGZRdZB.05Cjyy/cw.gz9iAozkzRS2', 'staff', 'dibamidina@gmail.com', '0740562961', '2024-12-02 18:03:36', '2024-12-02 18:03:36'),
(13, 'Diba', '$2y$10$qTECgvXqkdu3sUIY2b9H..Hgoy93UdW7oRvYMIuAx/aZAiCSTPKsW', 'admin', '22/07414@students.ksau.ac.ke', '0703416091', '2024-12-02 18:06:37', '2024-12-02 18:06:37'),
(15, 'tedd', '$2y$10$aJbQFuwvHpWU4.1BQ3wn1OfRAXJ9uz3RcjZRgKCBsg.jMgKQqFMVy', 'staff', 'marshtedd9@gmail.com', '0741312650', '2024-12-02 18:24:45', '2024-12-02 18:24:45');

-- --------------------------------------------------------

--
-- Table structure for table `visitors`
--

CREATE TABLE `visitors` (
  `visitor_id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phone` varchar(15) NOT NULL,
  `ticket_number` varchar(50) NOT NULL,
  `status` enum('checked_in','checked_out') DEFAULT 'checked_in',
  `checked_in_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `checked_out_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `visitors`
--

INSERT INTO `visitors` (`visitor_id`, `first_name`, `last_name`, `email`, `phone`, `ticket_number`, `status`, `checked_in_at`, `checked_out_at`) VALUES
(1, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:22', '2024-12-01 22:29:52'),
(2, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:25', '2024-12-01 22:29:56'),
(3, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:26', '2024-12-01 22:29:57'),
(4, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:26', '2024-12-01 22:33:09'),
(5, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:27', '2024-12-01 22:33:10'),
(6, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:27', '2024-12-01 22:33:11'),
(7, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:27', '2024-12-01 22:33:12'),
(8, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:07:28', '2024-12-01 22:30:55'),
(9, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:33:39', '2024-12-01 23:27:20'),
(10, 'Midina', 'Diba', 'dibamidina@gmail.com', '740562961', 'AMNP-674C8848DF539', 'checked_out', '2024-12-01 22:34:28', '2024-12-01 23:44:40'),
(11, 'Livingstone', 'Apeli', 'livingstoneapeli@gmail.com', '0703416091', 'AMNP-674CE8959ECA0', 'checked_out', '2024-12-01 22:52:05', '2024-12-01 23:43:59'),
(12, 'Apeli', 'Tonny', 'livingstoneapeli@gmail.com', '0703416091', 'AMNP-674CEB1F12869', 'checked_out', '2024-12-01 21:02:55', '2024-12-01 23:41:41'),
(13, 'Tedd', 'Deo', 'marshtedd9@gmail.com', '0703416091', 'AMNP-674DF8093A0DC', 'checked_out', '2024-12-02 18:13:51', '2024-12-02 18:14:09');

-- --------------------------------------------------------

--
-- Table structure for table `wildlife`
--

CREATE TABLE `wildlife` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `species` varchar(255) NOT NULL,
  `habitat` varchar(255) NOT NULL,
  `status` enum('Endangered','Vulnerable','Least Concern') NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `wildlife`
--

INSERT INTO `wildlife` (`id`, `name`, `species`, `habitat`, `status`, `title`, `description`, `image`, `created_at`) VALUES
(2, 'hhn', 'hnyhh', 'Forest', 'Endangered', 'tyy', 'tyy', '1733195354_294a5044-9e9b-49cc-b0a0-4755be661997.jpeg', '2024-12-03 03:09:14');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `bookings`
--
ALTER TABLE `bookings`
  ADD PRIMARY KEY (`booking_id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`attempt_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `park_gallery`
--
ALTER TABLE `park_gallery`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `support_inquiries`
--
ALTER TABLE `support_inquiries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tours`
--
ALTER TABLE `tours`
  ADD PRIMARY KEY (`tour_id`);

--
-- Indexes for table `transaction_codes`
--
ALTER TABLE `transaction_codes`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaction_code` (`transaction_code`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `visitors`
--
ALTER TABLE `visitors`
  ADD PRIMARY KEY (`visitor_id`);

--
-- Indexes for table `wildlife`
--
ALTER TABLE `wildlife`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `bookings`
--
ALTER TABLE `bookings`
  MODIFY `booking_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `attempt_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `park_gallery`
--
ALTER TABLE `park_gallery`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `password_resets`
--
ALTER TABLE `password_resets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `support_inquiries`
--
ALTER TABLE `support_inquiries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tours`
--
ALTER TABLE `tours`
  MODIFY `tour_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `transaction_codes`
--
ALTER TABLE `transaction_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `visitors`
--
ALTER TABLE `visitors`
  MODIFY `visitor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `wildlife`
--
ALTER TABLE `wildlife`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD CONSTRAINT `login_attempts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD CONSTRAINT `password_resets_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
