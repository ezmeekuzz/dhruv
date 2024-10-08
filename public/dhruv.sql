-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Aug 04, 2024 at 11:34 AM
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
-- Database: `dhruv`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_listing_agents`
--

CREATE TABLE `additional_listing_agents` (
  `additional_listing_agent_id` int(11) NOT NULL,
  `listing_agent_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `additional_listing_agents`
--

INSERT INTO `additional_listing_agents` (`additional_listing_agent_id`, `listing_agent_id`, `property_id`) VALUES
(112, 3, 86);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int(11) NOT NULL,
  `state_id` int(11) NOT NULL,
  `cityname` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `state_id`, `cityname`) VALUES
(19819, 73, 'Auburn 1'),
(19823, 73, 'Birmingham'),
(19824, 74, 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `investment_highlights`
--

CREATE TABLE `investment_highlights` (
  `investment_highlight_id` int(11) NOT NULL,
  `title` varchar(110) NOT NULL,
  `content` longtext NOT NULL,
  `property_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investment_highlights`
--

INSERT INTO `investment_highlights` (`investment_highlight_id`, `title`, `content`, `property_id`) VALUES
(154, 'CENTRAL HUB', 'jhghjj', 86);

-- --------------------------------------------------------

--
-- Table structure for table `listing_agents`
--

CREATE TABLE `listing_agents` (
  `listing_agent_id` int(11) NOT NULL,
  `fullname` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `licenseno` varchar(30) NOT NULL,
  `phonenumber` varchar(20) DEFAULT NULL,
  `mobilenumber` varchar(20) DEFAULT NULL,
  `position` varchar(50) NOT NULL,
  `profileimage` varchar(110) NOT NULL,
  `url` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listing_agents`
--

INSERT INTO `listing_agents` (`listing_agent_id`, `fullname`, `email`, `licenseno`, `phonenumber`, `mobilenumber`, `position`, `profileimage`, `url`) VALUES
(2, 'Rustom Codilan', 'rustomcodilan@gmail.com', '325234234', '09975304890', '09975304890', 'Kawatan sa Divisoria', 'uploads/profile-image/1721061134_e0398bae9cb11ffa09a8.png', 'https://www.matthews.com/'),
(3, 'Michelle Rose Lacre Codilan', 'rustomlacrecodilan@gmail.com', '324352345', '09975304890', '09975304890', 'Kawatan sa Manok', 'uploads/profile-image/1721060961_82aa4c258f22432af4ee.png', 'https://www.matthews.com/');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int(11) NOT NULL,
  `fname` varchar(50) NOT NULL,
  `lname` varchar(50) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `phonenumber` varchar(15) NOT NULL,
  `link` varchar(110) NOT NULL,
  `property` varchar(110) NOT NULL,
  `note` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `fname`, `lname`, `emailaddress`, `phonenumber`, `link`, `property`, `note`) VALUES
(4, 'Rustom', 'Codilan', 'rustomcodilan@gmail.com', '', 'http://localhost:8080//westgate-office', 'Westgate Office', 'I want this property!');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int(11) NOT NULL,
  `property_name` varchar(200) NOT NULL,
  `slug` varchar(250) NOT NULL,
  `real_estate_type` varchar(30) NOT NULL,
  `property_type_id` int(11) NOT NULL,
  `listing_agent_id` int(11) NOT NULL,
  `price` double(16,2) NOT NULL,
  `price_per_sf` double(16,2) NOT NULL,
  `state_id` int(11) NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode` varchar(10) NOT NULL,
  `caprate` varchar(5) NOT NULL,
  `tenancy` varchar(30) NOT NULL,
  `buildingsize` varchar(30) NOT NULL,
  `yearbuilt` year(4) NOT NULL,
  `location` varchar(250) NOT NULL,
  `askingcaprate` varchar(5) NOT NULL,
  `noi` double(16,2) NOT NULL,
  `leasestructure` varchar(50) NOT NULL,
  `occupancy` int(11) NOT NULL,
  `backgroundimage` varchar(110) NOT NULL,
  `offering_memorandum` varchar(110) NOT NULL,
  `publishstatus` varchar(20) NOT NULL,
  `dateadded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `property_name`, `slug`, `real_estate_type`, `property_type_id`, `listing_agent_id`, `price`, `price_per_sf`, `state_id`, `city_id`, `zipcode`, `caprate`, `tenancy`, `buildingsize`, `yearbuilt`, `location`, `askingcaprate`, `noi`, `leasestructure`, `occupancy`, `backgroundimage`, `offering_memorandum`, `publishstatus`, `dateadded`) VALUES
(86, 'Empress Cape of May', 'empress-cape-of-may', 'Commercial', 3, 2, 9000000.00, 150.00, 73, 19823, '9000', '9000', 'Single Tenant', '47,089 SF', '2008', '5749 Westgate Drive, Orlando, FL 32835', '9000', 1453431.00, 'NNN', 100, 'uploads/1722742501_4632064b05fe8fc08aec.png', 'uploads/offering-memorandum/1722742501_5eaac8acdff705107bc8.pdf', 'Draft', '2024-08-04');

-- --------------------------------------------------------

--
-- Table structure for table `property_galleries`
--

CREATE TABLE `property_galleries` (
  `property_gallery_id` int(11) NOT NULL,
  `property_id` int(11) NOT NULL,
  `location` varchar(110) NOT NULL,
  `file_name` varchar(110) NOT NULL,
  `original_name` varchar(110) NOT NULL,
  `order_sequence` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_galleries`
--

INSERT INTO `property_galleries` (`property_gallery_id`, `property_id`, `location`, `file_name`, `original_name`, `order_sequence`) VALUES
(430, 86, 'uploads/property-gallery/1722762386_558bd03a30f8f17d5738.png', '1722762386_558bd03a30f8f17d5738.png', '1722762215_90d0cc5fbb4357bc5167.png', 1),
(431, 86, 'uploads/property-gallery/1722762386_b62e014edc7c010f4721.png', '1722762386_b62e014edc7c010f4721.png', '1722762215_33cac52064655fc6e4ca.png', 2),
(432, 86, 'uploads/property-gallery/1722762386_f97362566b7265efc96a.png', '1722762386_f97362566b7265efc96a.png', '1722762215_1df7c9ac7cdab32f4bac.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

CREATE TABLE `property_types` (
  `property_type_id` int(11) NOT NULL,
  `property_type` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`property_type_id`, `property_type`) VALUES
(1, 'Apartments'),
(2, 'Health Care'),
(3, 'Hospitality'),
(4, 'Industrial'),
(5, 'Land'),
(6, 'Manufactured Housing'),
(8, 'Mixed-Use'),
(9, 'Office'),
(10, 'Self Storage'),
(11, 'Shopping Centers'),
(12, 'Automotive'),
(13, 'Bank'),
(14, 'Convenience Store/Ga'),
(15, 'Dollar Store'),
(16, 'Drug Store'),
(17, 'Education'),
(18, 'Grocery Store'),
(19, 'Mass Merchant'),
(20, 'Lifestyle'),
(21, 'Restaurant'),
(22, 'Other');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int(11) NOT NULL,
  `state_code` varchar(50) NOT NULL,
  `state_name` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_code`, `state_name`) VALUES
(73, 'AL', 'Alabama'),
(74, 'Testing', 'Testing');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `subscriber_id` int(11) NOT NULL,
  `emailaddress` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`subscriber_id`, `emailaddress`) VALUES
(3, 'rustomcodilan@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(20) NOT NULL,
  `emailaddress` varchar(100) NOT NULL,
  `password` varchar(50) NOT NULL,
  `usertype` varchar(20) NOT NULL,
  `encryptedpass` varchar(110) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `emailaddress`, `password`, `usertype`, `encryptedpass`) VALUES
(4, 'Rustom', 'Codilan', 'admin', 'rustomcodilan@gmail.com', 'mis137', 'Administrator', '$2y$10$la4Hqt2.M8tQRBbqdiTStOn.3bJTOacYnjHbA802m.UP9oGKxMQS6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `additional_listing_agents`
--
ALTER TABLE `additional_listing_agents`
  ADD PRIMARY KEY (`additional_listing_agent_id`),
  ADD KEY `listing_agent_id` (`listing_agent_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`city_id`),
  ADD KEY `state_id` (`state_id`);

--
-- Indexes for table `investment_highlights`
--
ALTER TABLE `investment_highlights`
  ADD PRIMARY KEY (`investment_highlight_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `listing_agents`
--
ALTER TABLE `listing_agents`
  ADD PRIMARY KEY (`listing_agent_id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`message_id`);

--
-- Indexes for table `properties`
--
ALTER TABLE `properties`
  ADD PRIMARY KEY (`property_id`),
  ADD KEY `property_type_id` (`property_type_id`),
  ADD KEY `state_id` (`state_id`),
  ADD KEY `city_id` (`city_id`),
  ADD KEY `listing_agent_id` (`listing_agent_id`);

--
-- Indexes for table `property_galleries`
--
ALTER TABLE `property_galleries`
  ADD PRIMARY KEY (`property_gallery_id`),
  ADD KEY `property_id` (`property_id`);

--
-- Indexes for table `property_types`
--
ALTER TABLE `property_types`
  ADD PRIMARY KEY (`property_type_id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`state_id`);

--
-- Indexes for table `subscribers`
--
ALTER TABLE `subscribers`
  ADD PRIMARY KEY (`subscriber_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `additional_listing_agents`
--
ALTER TABLE `additional_listing_agents`
  MODIFY `additional_listing_agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=113;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19825;

--
-- AUTO_INCREMENT for table `investment_highlights`
--
ALTER TABLE `investment_highlights`
  MODIFY `investment_highlight_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=155;

--
-- AUTO_INCREMENT for table `listing_agents`
--
ALTER TABLE `listing_agents`
  MODIFY `listing_agent_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `property_galleries`
--
ALTER TABLE `property_galleries`
  MODIFY `property_gallery_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=433;

--
-- AUTO_INCREMENT for table `property_types`
--
ALTER TABLE `property_types`
  MODIFY `property_type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `subscriber_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `additional_listing_agents`
--
ALTER TABLE `additional_listing_agents`
  ADD CONSTRAINT `additional_listing_agents_ibfk_1` FOREIGN KEY (`listing_agent_id`) REFERENCES `listing_agents` (`listing_agent_id`),
  ADD CONSTRAINT `additional_listing_agents_ibfk_2` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_ibfk_1` FOREIGN KEY (`state_id`) REFERENCES `states` (`state_id`);

--
-- Constraints for table `investment_highlights`
--
ALTER TABLE `investment_highlights`
  ADD CONSTRAINT `investment_highlights_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);

--
-- Constraints for table `properties`
--
ALTER TABLE `properties`
  ADD CONSTRAINT `properties_ibfk_1` FOREIGN KEY (`property_type_id`) REFERENCES `property_types` (`property_type_id`),
  ADD CONSTRAINT `properties_ibfk_2` FOREIGN KEY (`state_id`) REFERENCES `states` (`state_id`),
  ADD CONSTRAINT `properties_ibfk_3` FOREIGN KEY (`city_id`) REFERENCES `cities` (`city_id`),
  ADD CONSTRAINT `properties_ibfk_4` FOREIGN KEY (`listing_agent_id`) REFERENCES `listing_agents` (`listing_agent_id`);

--
-- Constraints for table `property_galleries`
--
ALTER TABLE `property_galleries`
  ADD CONSTRAINT `property_galleries_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
