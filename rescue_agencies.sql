-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Oct 05, 2024 at 07:16 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `rescue_agencies`
--

-- --------------------------------------------------------

--
-- Table structure for table `agencies`
--

CREATE TABLE `agencies` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `contact_number` varchar(20) DEFAULT NULL,
  `expertise` text DEFAULT NULL,
  `resources` text DEFAULT NULL,
  `last_activity` timestamp NOT NULL DEFAULT current_timestamp(),
  `latitude` decimal(10,8) NOT NULL,
  `longitude` decimal(11,8) NOT NULL,
  `type` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `agencies`
--

INSERT INTO `agencies` (`id`, `name`, `email`, `password`, `contact_number`, `expertise`, `resources`, `last_activity`, `latitude`, `longitude`, `type`) VALUES
(13, 'Agency 01', 'agencyone@example.com', '$2y$10$BtWqVlMjxy4QAlj1usNoUeC.rU8y08gYUnZ4/E0q1Jd9.WXcjdYxe', '7412589630', 'Search and Rescue', 'trucks, Boats, First Aid Kits', '2024-09-28 15:49:58', 22.56851776, 88.37020397, 'Government'),
(14, 'Agency 02', 'agencytwo@example.com', '$2y$10$uFN8PlgeM.Q.rtbELXbMYu8ePChOB.fOoZ.Jil2.jQuLhcoWP760.', '9632587410', 'Medical Assistance', 'Ambulances, Medical Supplies', '2024-09-28 15:52:30', 26.45189609, 80.33512115, 'Private'),
(15, 'Agency 03', 'agencythree@example.com', '$2y$10$uSErUXs9b7QnuHHLlFocLuTVHiIXPuBOFaxRBNQtFQ2/zQlKAGzDu', '8521479630', 'Disaster Relief', 'Food Supplies, Water Purification Systems', '2024-09-28 15:53:57', 24.57669907, 73.69766235, 'NGO'),
(16, 'Agency 04', 'agencyfour@example.com', '$2y$10$HKbFanUPn8H88XpSJWXwpOQGiMXaKFk2xZvInmhJJcRO0NjCMqIs6', '7541269530', 'Fire Control', 'Fire Trucks, Personnel', '2024-09-28 15:55:21', 17.42681841, 78.48855972, 'Private'),
(17, 'Agency 05', 'agencyfive@example.com', '$2y$10$KJig7GnkANCh2xWzafN95O/LqsBApzZzuAtNQcJacktMP/gghoDrW', '6541239870', 'Community Support', 'Shelters, Food Packs', '2024-09-28 15:56:38', 10.80031156, 78.69026184, 'NGO');

-- --------------------------------------------------------

--
-- Table structure for table `alerts`
--

CREATE TABLE `alerts` (
  `id` int(11) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `title` varchar(255) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `status` enum('open','closed') DEFAULT 'open',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `alerts`
--

INSERT INTO `alerts` (`id`, `agency_id`, `title`, `message`, `status`, `timestamp`) VALUES
(6, 17, 'Severe Weather Alert', 'A severe thunderstorm warning has been issued for the area. Stay indoors and avoid travel', 'open', '2024-09-28 16:02:09'),
(7, 16, 'Flood Alert', 'Flooding is expected due to heavy rains. Evacuate low-lying areas immediately', 'open', '2024-09-28 16:18:25'),
(8, 13, 'red alert', 'kovai\r\n', 'open', '2024-09-29 06:14:47');

-- --------------------------------------------------------

--
-- Table structure for table `incidents`
--

CREATE TABLE `incidents` (
  `incident_id` int(11) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `incident_title` varchar(255) DEFAULT NULL,
  `incident_description` text DEFAULT NULL,
  `incident_type` enum('Fire','Flood','Earthquake','Accident','Other') DEFAULT NULL,
  `incident_date` datetime DEFAULT NULL,
  `status` enum('Reported','In Progress','Resolved') DEFAULT 'Reported',
  `location_latitude` decimal(9,6) DEFAULT NULL,
  `location_longitude` decimal(9,6) DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `in_progress_timestamp` datetime DEFAULT NULL,
  `resolved_timestamp` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `incidents`
--

INSERT INTO `incidents` (`incident_id`, `agency_id`, `incident_title`, `incident_description`, `incident_type`, `incident_date`, `status`, `location_latitude`, `location_longitude`, `timestamp`, `in_progress_timestamp`, `resolved_timestamp`) VALUES
(10, 13, 'Flood in Coastal Area', 'Severe flooding has affected the coastal region due to heavy rains', 'Flood', '2024-09-01 06:56:00', 'Resolved', 17.298199, 83.276367, '2024-09-28 16:24:14', NULL, NULL),
(12, 14, 'Earthquake Report', 'A 6.0 magnitude earthquake was felt in the northern region', 'Earthquake', '2024-09-10 12:35:00', 'Resolved', 23.723754, 86.450958, '2024-09-28 17:03:35', NULL, NULL),
(13, 16, 'Traffic Accident', 'A multi-vehicle accident occurred on the highway. Several injuries reported.', 'Accident', '2024-09-28 22:46:00', 'Resolved', 12.148340, 78.130615, '2024-09-28 17:16:49', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_agency_id` int(11) DEFAULT NULL,
  `receiver_agency_id` int(11) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_agency_id`, `receiver_agency_id`, `message`, `timestamp`) VALUES
(11, 17, 13, 'have your receive alert', '2024-09-28 16:20:02'),
(12, 13, 17, 'yes received', '2024-09-28 16:20:27'),
(13, 16, 14, 'have your receive message', '2024-09-28 16:21:06'),
(14, 14, 16, 'yes received', '2024-09-28 16:21:24'),
(15, 15, 13, 'i didn\'t receive', '2024-09-28 16:21:42'),
(16, 15, 14, 'i didn\'t receive', '2024-09-28 16:21:46'),
(17, 15, 15, 'i didn\'t receive', '2024-09-28 16:21:51'),
(18, 15, 16, 'i didn\'t receive', '2024-09-28 16:21:57'),
(19, 15, 17, 'i didn\'t receive', '2024-09-28 16:22:01'),
(20, 13, 17, 'hi', '2024-09-29 06:15:05');

-- --------------------------------------------------------

--
-- Table structure for table `resources`
--

CREATE TABLE `resources` (
  `id` int(11) NOT NULL,
  `agency_id` int(11) DEFAULT NULL,
  `resource_name` varchar(255) NOT NULL,
  `quantity` int(11) NOT NULL,
  `unit` varchar(50) NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resources`
--

INSERT INTO `resources` (`id`, `agency_id`, `resource_name`, `quantity`, `unit`, `timestamp`) VALUES
(4, 13, 'Medical Kits', 225, '10', '2024-09-28 17:50:46'),
(5, 14, 'Tents', 31, '10', '2024-09-28 17:51:14'),
(6, 15, 'Generators', 10, '1', '2024-09-28 17:52:01'),
(7, 17, ' Oxygen Cylinders', 62, '5', '2024-09-28 17:53:09');

-- --------------------------------------------------------

--
-- Table structure for table `resource_allocations`
--

CREATE TABLE `resource_allocations` (
  `id` int(11) NOT NULL,
  `resource_id` int(11) DEFAULT NULL,
  `allocating_agency_id` int(11) DEFAULT NULL,
  `receiving_agency_id` int(11) DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `status` enum('in_progress','completed') DEFAULT 'in_progress',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_allocations`
--

INSERT INTO `resource_allocations` (`id`, `resource_id`, `allocating_agency_id`, `receiving_agency_id`, `quantity`, `status`, `timestamp`) VALUES
(6, 5, 14, 17, 5, 'in_progress', '2024-09-28 17:54:40'),
(7, 7, 17, 13, 15, 'in_progress', '2024-09-28 17:58:41'),
(8, 7, 17, 14, 10, 'in_progress', '2024-09-28 17:58:41'),
(9, 7, 17, 15, 7, 'in_progress', '2024-09-28 17:58:41'),
(10, 5, 14, 13, 10, 'in_progress', '2024-09-28 17:59:11'),
(11, 5, 14, 15, 4, 'in_progress', '2024-09-28 17:59:11'),
(12, 4, 13, 14, 10, 'in_progress', '2024-09-28 17:59:30'),
(13, 4, 13, 15, 15, 'in_progress', '2024-09-28 17:59:30'),
(14, 7, 17, 13, 1, 'in_progress', '2024-09-28 18:01:27'),
(15, 7, 17, 14, 5, 'in_progress', '2024-09-28 18:01:27');

-- --------------------------------------------------------

--
-- Table structure for table `resource_requests`
--

CREATE TABLE `resource_requests` (
  `id` int(11) NOT NULL,
  `requesting_agency_id` int(11) DEFAULT NULL,
  `resource_name` varchar(255) NOT NULL,
  `quantity_needed` int(11) NOT NULL,
  `status` enum('pending','fulfilled','cancelled') DEFAULT 'pending',
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `resource_requests`
--

INSERT INTO `resource_requests` (`id`, `requesting_agency_id`, `resource_name`, `quantity_needed`, `status`, `timestamp`) VALUES
(7, 17, 'Tents', 5, 'fulfilled', '2024-09-28 17:54:21'),
(8, 14, 'Medical Kits', 10, 'fulfilled', '2024-09-28 17:55:40'),
(9, 14, 'Generators', 2, 'fulfilled', '2024-09-28 17:55:48'),
(10, 14, ' Oxygen Cylinders', 10, 'fulfilled', '2024-09-28 17:55:57'),
(11, 13, 'Tents', 10, 'fulfilled', '2024-09-28 17:56:11'),
(12, 13, 'Generators', 2, 'fulfilled', '2024-09-28 17:56:21'),
(13, 13, ' Oxygen Cylinders', 15, 'fulfilled', '2024-09-28 17:56:30'),
(14, 15, 'Medical Kits', 15, 'fulfilled', '2024-09-28 17:56:47'),
(15, 15, 'Tents', 4, 'fulfilled', '2024-09-28 17:56:57'),
(16, 15, ' Oxygen Cylinders', 7, 'fulfilled', '2024-09-28 17:57:08');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `agencies`
--
ALTER TABLE `agencies`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `alerts`
--
ALTER TABLE `alerts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indexes for table `incidents`
--
ALTER TABLE `incidents`
  ADD PRIMARY KEY (`incident_id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sender_agency_id` (`sender_agency_id`),
  ADD KEY `receiver_agency_id` (`receiver_agency_id`);

--
-- Indexes for table `resources`
--
ALTER TABLE `resources`
  ADD PRIMARY KEY (`id`),
  ADD KEY `agency_id` (`agency_id`);

--
-- Indexes for table `resource_allocations`
--
ALTER TABLE `resource_allocations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `resource_id` (`resource_id`),
  ADD KEY `allocating_agency_id` (`allocating_agency_id`),
  ADD KEY `receiving_agency_id` (`receiving_agency_id`);

--
-- Indexes for table `resource_requests`
--
ALTER TABLE `resource_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `requesting_agency_id` (`requesting_agency_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `agencies`
--
ALTER TABLE `agencies`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `alerts`
--
ALTER TABLE `alerts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `incidents`
--
ALTER TABLE `incidents`
  MODIFY `incident_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `resources`
--
ALTER TABLE `resources`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `resource_allocations`
--
ALTER TABLE `resource_allocations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `resource_requests`
--
ALTER TABLE `resource_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts`
--
ALTER TABLE `alerts`
  ADD CONSTRAINT `alerts_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`);

--
-- Constraints for table `incidents`
--
ALTER TABLE `incidents`
  ADD CONSTRAINT `incidents_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`);

--
-- Constraints for table `messages`
--
ALTER TABLE `messages`
  ADD CONSTRAINT `messages_ibfk_1` FOREIGN KEY (`sender_agency_id`) REFERENCES `agencies` (`id`),
  ADD CONSTRAINT `messages_ibfk_2` FOREIGN KEY (`receiver_agency_id`) REFERENCES `agencies` (`id`);

--
-- Constraints for table `resources`
--
ALTER TABLE `resources`
  ADD CONSTRAINT `resources_ibfk_1` FOREIGN KEY (`agency_id`) REFERENCES `agencies` (`id`);

--
-- Constraints for table `resource_allocations`
--
ALTER TABLE `resource_allocations`
  ADD CONSTRAINT `resource_allocations_ibfk_1` FOREIGN KEY (`resource_id`) REFERENCES `resources` (`id`),
  ADD CONSTRAINT `resource_allocations_ibfk_2` FOREIGN KEY (`allocating_agency_id`) REFERENCES `agencies` (`id`),
  ADD CONSTRAINT `resource_allocations_ibfk_3` FOREIGN KEY (`receiving_agency_id`) REFERENCES `agencies` (`id`);

--
-- Constraints for table `resource_requests`
--
ALTER TABLE `resource_requests`
  ADD CONSTRAINT `resource_requests_ibfk_1` FOREIGN KEY (`requesting_agency_id`) REFERENCES `agencies` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
