-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 10, 2024 at 10:24 AM
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
-- Database: `barangay9`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_credentials`
--

CREATE TABLE `admin_credentials` (
  `admin_id` varchar(10) NOT NULL DEFAULT '',
  `admin_name` varchar(100) NOT NULL,
  `admin_role` varchar(20) NOT NULL,
  `admin_username` varchar(50) NOT NULL,
  `admin_password` varchar(50) NOT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_credentials`
--

INSERT INTO `admin_credentials` (`admin_id`, `admin_name`, `admin_role`, `admin_username`, `admin_password`, `last_update`) VALUES
('BRGY9Z201', 'Maria Alma', 'Barangay Secretary', 'admin1', 'admin1', '2024-06-03'),
('BRGY9Z202', 'John Doe', 'Barangay Captain', 'admin1', 'admin1', '2024-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `document_requests`
--

CREATE TABLE `document_requests` (
  `user_id` int(8) UNSIGNED DEFAULT NULL,
  `request_reference` varchar(10) NOT NULL,
  `document` char(50) NOT NULL,
  `request_purpose` varchar(500) NOT NULL,
  `date_request` date NOT NULL,
  `time_request` time NOT NULL,
  `date_release` date DEFAULT NULL,
  `request_status` char(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `document_requests`
--

INSERT INTO `document_requests` (`user_id`, `request_reference`, `document`, `request_purpose`, `date_request`, `time_request`, `date_release`, `request_status`) VALUES
(1, '3MFZkb7MyD', 'Barangay ID', 'employment purpose', '2024-06-03', '05:51:00', NULL, 'pending'),
(1, '8AK6DuFUnW', 'Barangay ID', 'Employment requirement', '2024-06-03', '10:50:00', '2024-06-05', 'completed'),
(1, '8k7Sq2yjzc', 'Certificate of Indigency', 'Application for financial aid', '2024-06-03', '10:51:00', '2024-06-05', 'approved'),
(1, 'T0lMfvVZrE', 'Certificate of Residency', 'Enrollment at Pamantasan ng Lungsod ng Maynila', '2024-06-03', '10:51:00', NULL, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `masterlist`
--

CREATE TABLE `masterlist` (
  `user_id` int(8) UNSIGNED NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `masterlist`
--

INSERT INTO `masterlist` (`user_id`, `first_name`, `middle_name`, `last_name`) VALUES
(1, 'John', 'Demetrio', 'Doe');

-- --------------------------------------------------------

--
-- Table structure for table `user_attachments`
--

CREATE TABLE `user_attachments` (
  `user_id` int(8) UNSIGNED DEFAULT NULL,
  `formal_picture` blob NOT NULL,
  `id_type` char(18) NOT NULL,
  `id_card` blob DEFAULT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_attachments`
--

INSERT INTO `user_attachments` (`user_id`, `formal_picture`, `id_type`, `id_card`, `last_update`) VALUES
(1, 0x75706c6f6164732f363635636633353137353332312e6a7067, 'driver\'s license', 0x75706c6f6164732f363635636633353137353332612e6a7067, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_contact_details`
--

CREATE TABLE `user_contact_details` (
  `user_id` int(8) UNSIGNED DEFAULT NULL,
  `contact_number` varchar(15) NOT NULL,
  `email_address` varchar(500) NOT NULL,
  `home_address` varchar(500) NOT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_contact_details`
--

INSERT INTO `user_contact_details` (`user_id`, `contact_number`, `email_address`, `home_address`, `last_update`) VALUES
(1, '+639375982737', 'johndoe.1993@gmail.com', '01234 Anystreet, Anytown', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_contact_person`
--

CREATE TABLE `user_contact_person` (
  `user_id` int(8) UNSIGNED NOT NULL,
  `contact_name` varchar(100) NOT NULL,
  `contact_relationship` varchar(50) NOT NULL,
  `contact_phone` varchar(15) NOT NULL,
  `contact_address` varchar(500) NOT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_contact_person`
--

INSERT INTO `user_contact_person` (`user_id`, `contact_name`, `contact_relationship`, `contact_phone`, `contact_address`, `last_update`) VALUES
(1, 'Maria Alma', 'Mother', '+638375982737', '01234 Anystreet, Anytown', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `user_credentials`
--

CREATE TABLE `user_credentials` (
  `user_id` int(8) UNSIGNED DEFAULT NULL,
  `user_username` varchar(100) NOT NULL,
  `user_password` varchar(100) NOT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_credentials`
--

INSERT INTO `user_credentials` (`user_id`, `user_username`, `user_password`, `last_update`) VALUES
(1, 'johndoe.1993@gmail.com', 'does', '2024-06-03');

-- --------------------------------------------------------

--
-- Table structure for table `user_personal_details`
--

CREATE TABLE `user_personal_details` (
  `user_id` int(8) UNSIGNED DEFAULT NULL,
  `gender` varchar(8) NOT NULL,
  `birthdate` date NOT NULL,
  `residency` char(12) NOT NULL,
  `resident_years` int(4) UNSIGNED NOT NULL,
  `last_update` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_personal_details`
--

INSERT INTO `user_personal_details` (`user_id`, `gender`, `birthdate`, `residency`, `resident_years`, `last_update`) VALUES
(1, 'male', '1993-09-05', 'home owner', 12, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_credentials`
--
ALTER TABLE `admin_credentials`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD PRIMARY KEY (`request_reference`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `masterlist`
--
ALTER TABLE `masterlist`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `user_attachments`
--
ALTER TABLE `user_attachments`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_contact_details`
--
ALTER TABLE `user_contact_details`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_contact_person`
--
ALTER TABLE `user_contact_person`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `user_personal_details`
--
ALTER TABLE `user_personal_details`
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `masterlist`
--
ALTER TABLE `masterlist`
  MODIFY `user_id` int(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `document_requests`
--
ALTER TABLE `document_requests`
  ADD CONSTRAINT `document_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `masterlist` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_attachments`
--
ALTER TABLE `user_attachments`
  ADD CONSTRAINT `user_attachments_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `masterlist` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_contact_details`
--
ALTER TABLE `user_contact_details`
  ADD CONSTRAINT `user_contact_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `masterlist` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_contact_person`
--
ALTER TABLE `user_contact_person`
  ADD CONSTRAINT `user_contact_person_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `masterlist` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_credentials`
--
ALTER TABLE `user_credentials`
  ADD CONSTRAINT `user_credentials_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `masterlist` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `user_personal_details`
--
ALTER TABLE `user_personal_details`
  ADD CONSTRAINT `user_personal_details_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `masterlist` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
