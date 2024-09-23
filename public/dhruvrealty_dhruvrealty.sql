-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 14, 2024 at 04:58 PM
-- Server version: 8.0.39
-- PHP Version: 8.3.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `dhruvrealty_dhruvrealty`
--

-- --------------------------------------------------------

--
-- Table structure for table `additional_listing_agents`
--

CREATE TABLE `additional_listing_agents` (
  `additional_listing_agent_id` int NOT NULL,
  `listing_agent_id` int NOT NULL,
  `property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `city_id` int NOT NULL,
  `state_id` int NOT NULL,
  `cityname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`city_id`, `state_id`, `cityname`) VALUES
(19823, 73, 'Birmingham'),
(19825, 75, 'Tampa'),
(19826, 75, 'Sarasota'),
(19827, 75, 'New Port Richey');

-- --------------------------------------------------------

--
-- Table structure for table `investment_highlights`
--

CREATE TABLE `investment_highlights` (
  `investment_highlight_id` int NOT NULL,
  `title` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `content` longtext COLLATE utf8mb4_general_ci NOT NULL,
  `property_id` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `investment_highlights`
--

INSERT INTO `investment_highlights` (`investment_highlight_id`, `title`, `content`, `property_id`) VALUES
(664, '', '', 94),
(677, 'Prime Location Anchored by Winn-Dixie', 'A 100% occupied shopping Center attached to Winn-dixie with consistent cashflow. ', 90),
(678, 'Below market rate rents', 'Add-value to the property by renewing leases ', 90),
(679, 'Diversified Tenant Mix', 'This property offers a fully diversified tenant mix with everything from a dollar tree to Winn-dixie liquor and office suites. \r\n\r\n\r\n* The Owner has ownership interest in Dhruv Realty. ', 90),
(680, 'NNN Lease Structure', 'Triple Net (NNN) lease ensures minimal landlord responsibilities and stable returns. CAM is collected from the tenants and includes the property tax, insurance and maintenance of the grounds. ', 89),
(681, 'Prime Location', 'Directly across from Busch Gardens, which sees over 4 million visitors annually. Less than 1 mile to USF and student living facilities. ', 89),
(682, 'High Traffic', 'Situated in a high-traffic area with an average of 100,000 vehicles passing by daily.', 89),
(683, 'Diverse Consumer Base', 'The combination of tourists, students, and local residents ensures a consistent and diverse customer base for tenants.', 89),
(684, 'Stable Income', 'Generates a Net Operating Income (NOI) of $264,000. With a true (NNN) lease structure. ', 89),
(685, '*Ownership Interest', 'The owner has ownership interest in Dhruv Realty', 89),
(686, '', '', 93);

-- --------------------------------------------------------

--
-- Table structure for table `listing_agents`
--

CREATE TABLE `listing_agents` (
  `listing_agent_id` int NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `licenseno` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `phonenumber` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `mobilenumber` varchar(20) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `position` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `profileimage` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `url` varchar(110) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `listing_agents`
--

INSERT INTO `listing_agents` (`listing_agent_id`, `fullname`, `email`, `licenseno`, `phonenumber`, `mobilenumber`, `position`, `profileimage`, `url`) VALUES
(2, 'Rustom Codilan', 'rustomcodilan@gmail.com', '325234234', '09975304890', '09975304890', 'Kawatan sa Divisoria', 'uploads/profile-image/1721061134_e0398bae9cb11ffa09a8.png', 'https://www.matthews.com/'),
(5, 'Joe Caldarelli', 'Joe@dhruvcommercial.com', 'BK3386144 (FL)', '(352) 773-0153', '(352) 293-5754', 'Principal Broker', 'uploads/profile-image/1723094036_f1dddebf72733baa9476.jpg', 'https://dhruv-realty.com/agents/joe-caldarelli/');

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `message_id` int NOT NULL,
  `fname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `emailaddress` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phonenumber` varchar(15) COLLATE utf8mb4_general_ci NOT NULL,
  `link` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `property` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `note` longtext COLLATE utf8mb4_general_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`message_id`, `fname`, `lname`, `emailaddress`, `phonenumber`, `link`, `property`, `note`) VALUES
(6, 'joe', 'caldarelli', 'joecaldarelli@yahoo.com', '352-293-5754', 'https://app.dhruv-realty.com//congress-crossings', 'Congress Crossings', 'hi testing'),
(7, 'rajesh', 'patel', 'patel555@aol.com', '4079281435', 'https://app.dhruv-realty.com//busch-andamp-30th-retail', 'Busch & 30th Retail', 'need moreinfo about lease n rent increase'),
(8, 'joseph', 'ghally', 'josephghally@gmail.com', '7274883122', 'https://app.dhruv-realty.com//busch-andamp-30th-retail', 'Busch & 30th Retail', '');

-- --------------------------------------------------------

--
-- Table structure for table `om_consents`
--

CREATE TABLE `om_consents` (
  `om_consent_id` int NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `phone` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `property_id` int NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `om_consents`
--

INSERT INTO `om_consents` (`om_consent_id`, `fullname`, `email`, `phone`, `property_id`, `date`) VALUES
(18, 'Marie', 'marie.araix@gmail.com', '09084770200', 89, '2024-08-10'),
(25, 'casey dorner', 'cdorner@eisre.com', '4074044017', 89, '2024-08-12'),
(26, 'Mohammad Mustafa', 'mustafa@nationrs.com', '8133856021', 89, '2024-08-12'),
(28, 'Stablewood acquisitions', 'acquisitions-team@stablewoodproperties.com', '7082323525', 89, '2024-08-13'),
(29, 'Mohammad J Mustafa', 'mustafa@nationrs.com', '8133856021', 89, '2024-08-13'),
(30, 'Conner Elliott', 'celliott@icorprealty.com', '9043865090', 89, '2024-08-13'),
(31, 'joseph ghally', 'josephghally@gmail.com', '7274883708', 89, '2024-08-14'),
(33, 'Meilyn Marino', 'mm@meilynmarino.com', '404-432-8477', 89, '2024-08-15'),
(34, 'Alex Lucke', 'Alexlucke@kwcommercial.com', '7274102896', 89, '2024-08-16'),
(35, 'Alex Lucke', 'AlexLucke@kwcommercial.com', '7274102896', 90, '2024-08-16'),
(36, 'Charles C. Goldman', 'success1968@hotmail.com', '9178802554', 89, '2024-08-16'),
(37, 'Alex Adorno', 'alexadorno@keyes.com', '7729852577', 90, '2024-08-16'),
(38, 'Adam Nelson', 'adamnelsonrealestate@gmail.com', '2016650778', 90, '2024-08-21'),
(39, 'Adam Nelson', 'AdamNelsonRealEstate@gmail.com', '2016650778', 89, '2024-08-21'),
(40, 'William Soled', 'williamsoled@cohencommercial.com', '9542926644', 89, '2024-08-21'),
(41, 'William Soled', 'williamsoled@cohencommercial.com', '9542926644', 90, '2024-08-21'),
(42, 'Peter Katsarelis', 'Peter@bibrokerage.com', '8139927653', 89, '2024-08-22'),
(43, 'Peter Katsarelis', 'Peter@bibrokerage.com', '8139927653', 89, '2024-08-22'),
(44, 'adam', 'adamnelsonrealestate@gmail.com', '2016650778', 90, '2024-08-22'),
(45, 'Cade Southerland', 'Cade.southerland@matthews.com', '6029464842', 89, '2024-08-23'),
(46, 'Jon Wilsonholme', 'jw@westwoodnetlease.com', '3144954195', 89, '2024-08-23'),
(47, 'Marc Pfleger', 'mpfleger@cap-realty.com', '727-262-5998', 89, '2024-08-27'),
(48, 'Marc Pfleger', 'mpfleger@cap-realty.com', '727-262-5998', 90, '2024-08-27'),
(49, 'Ronald D Haddad', 'r1042@aol.com', '3472483770', 89, '2024-08-28'),
(54, 'rao', 'lakshman_y@hotmail.com', '2108134873', 89, '2024-08-29'),
(55, 'Bobby Tyrone Gross', 'bobby.gross@marcusmillichap.com', '4078646969', 89, '2024-08-29'),
(56, 'Raj Patel', 'patel555@aol.com', '4079281435', 89, '2024-08-30'),
(57, 'Alex Adorno', 'alexadorno@keyes.com', '7729852577', 90, '2024-09-03'),
(58, 'joe', 'Joecaldarelli@yahoo.com', '3522935754', 90, '2024-09-03'),
(59, 'Jonathan Cheung', 'jonathan@baycommercialinvestments.com', '6466413009', 89, '2024-09-03'),
(60, 'Peter Katsarelis', 'peter@bibrokerage.com', '8139927653', 90, '2024-09-05'),
(61, 'Nick Caldarelli', 'nick.caldarelli@gmail.com', '3526782700', 93, '2024-09-05'),
(62, 'Cecilia', 'cissacamargo@eliteinternational.com', '9542602778', 89, '2024-09-05'),
(63, 'Peter Katsarelis', 'Peter@bibrokerage.com', '8139927653', 90, '2024-09-05'),
(64, 'Peter', 'peter@bibrokerage.com', '8139927653', 90, '2024-09-06'),
(65, 'Peter Liberatore', 'Pliberatore@allycapitalgroup.com', '7162069111', 89, '2024-09-06'),
(66, 'Carla Bailey', 'CarlaSellingFL@gmail.com', '304-669-5250', 89, '2024-09-09'),
(67, 'Tyler Hicks', 'tyler.hicks@franklinst.com', '3525365754', 89, '2024-09-10');

-- --------------------------------------------------------

--
-- Table structure for table `properties`
--

CREATE TABLE `properties` (
  `property_id` int NOT NULL,
  `property_name` varchar(200) COLLATE utf8mb4_general_ci NOT NULL,
  `slug` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `real_estate_type` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `property_type_id` int NOT NULL,
  `listing_agent_id` int NOT NULL,
  `price` double(16,2) NOT NULL,
  `price_per_sf` double(16,2) NOT NULL,
  `state_id` int NOT NULL,
  `city_id` int NOT NULL,
  `zipcode` varchar(10) COLLATE utf8mb4_general_ci NOT NULL,
  `caprate` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `tenancy` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `buildingsize` varchar(30) COLLATE utf8mb4_general_ci NOT NULL,
  `yearbuilt` year NOT NULL,
  `location` varchar(250) COLLATE utf8mb4_general_ci NOT NULL,
  `askingcaprate` varchar(5) COLLATE utf8mb4_general_ci NOT NULL,
  `noi` double(16,2) NOT NULL,
  `leasestructure` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `occupancy` int NOT NULL,
  `backgroundimage` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `offering_memorandum` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `publishstatus` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `dateadded` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `properties`
--

INSERT INTO `properties` (`property_id`, `property_name`, `slug`, `real_estate_type`, `property_type_id`, `listing_agent_id`, `price`, `price_per_sf`, `state_id`, `city_id`, `zipcode`, `caprate`, `tenancy`, `buildingsize`, `yearbuilt`, `location`, `askingcaprate`, `noi`, `leasestructure`, `occupancy`, `backgroundimage`, `offering_memorandum`, `publishstatus`, `dateadded`) VALUES
(89, 'Busch & 30th Retail', 'busch-andamp-30th-retail', 'Commercial', 23, 5, 4073523.00, 509.00, 75, 19825, '33612', '6.5', 'Multi-Tenant', '8120 SF', '2018', '2920 E Busch Blvd', '6.5', 264779.00, 'NNN', 100, 'uploads/1724943548_7bc053b613b1f0f3959b.jpg', 'uploads/offering-memorandum/1723742569_695ab1b7b9f5eb3e0e58.pdf', 'Published', '2024-08-08'),
(90, 'Congress Crossings', 'congress-crossings', 'Commercial', 23, 5, 5430000.00, 162.00, 75, 19827, '34653', '8', 'Multi-Tenant', '32,897', '1989', '6432 Massachusetts Ave, New Port Richey, FL 34653', '8', 427000.00, 'NNN', 100, 'uploads/1725579744_eca435d59baf8a6acdab.jpg', 'uploads/offering-memorandum/1724867467_b04a32c3530ab3b17386.pdf', 'Published', '2024-08-09'),
(93, 'Pompano Plaza', 'pompano-plaza', 'Commercial', 23, 5, 3700000.00, 0.00, 75, 19826, '34234', '7.0', 'Multi-Tenant', '14,555', '2000', '3082 17th Street, Sarasota FL, 34234', '7.0', 0.00, 'NNN', 80, 'uploads/1725579985_a2d5527781c00e3e4130.png', '', 'Published', '2024-09-05'),
(94, 'Vanderbilt ', 'vanderbilt-', 'Commercial', 23, 5, 6350000.00, 0.00, 75, 19827, '34652', '7.0', 'Multi-Tenant', '54000', '2016', '6437 US HWY 19', '7.0', 0.00, 'NNN', 30, 'uploads/1725579116_0fce7853fea346615c16.png', '', 'Published', '2024-09-05');

-- --------------------------------------------------------

--
-- Table structure for table `property_galleries`
--

CREATE TABLE `property_galleries` (
  `property_gallery_id` int NOT NULL,
  `property_id` int NOT NULL,
  `location` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `file_name` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `original_name` varchar(110) COLLATE utf8mb4_general_ci NOT NULL,
  `order_sequence` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_galleries`
--

INSERT INTO `property_galleries` (`property_gallery_id`, `property_id`, `location`, `file_name`, `original_name`, `order_sequence`) VALUES
(597, 89, 'uploads/property-gallery/1723233283_768554f769b2abad0665.jpeg', '1723233283_768554f769b2abad0665.jpeg', 'IMG_2389.jpeg', 8),
(598, 89, 'uploads/property-gallery/1723233283_a532d248aa75e79649d6.jpeg', '1723233283_a532d248aa75e79649d6.jpeg', 'IMG_2388.jpeg', 9),
(616, 90, 'uploads/property-gallery/1723238714_6d93b470846fca986e6b.png', '1723238714_6d93b470846fca986e6b.png', 'Screenshot 2024-08-09 at 5.23.53 PM.png', 5),
(617, 90, 'uploads/property-gallery/1723238714_63930b023cd087a84657.png', '1723238714_63930b023cd087a84657.png', 'Screenshot 2024-08-09 at 5.24.44 PM.png', 4),
(618, 89, 'uploads/property-gallery/1723482540_0d357acf145a86af51ca.jpg', '1723482540_0d357acf145a86af51ca.jpg', 'Busch Gardens Sign_.jpg', 2),
(619, 89, 'uploads/property-gallery/1723482540_0a852da05c3faed5744e.jpg', '1723482540_0a852da05c3faed5744e.jpg', 'Busch-blvd.jpg', 1),
(620, 89, 'uploads/property-gallery/1723482540_dff34c8f6b665240b1cb.png', '1723482540_dff34c8f6b665240b1cb.png', 'Buschclose_.png', 3),
(621, 89, 'uploads/property-gallery/1723482540_6aa969b2d2557607c600.png', '1723482540_6aa969b2d2557607c600.png', 'BuschFar_.png', 4),
(622, 89, 'uploads/property-gallery/1723482540_62a99e9d8651b343e7b6.jpg', '1723482540_62a99e9d8651b343e7b6.jpg', 'parkinglotbusch_.jpg', 7),
(623, 89, 'uploads/property-gallery/1723482540_6d545a373ede683def47.jpg', '1723482540_6d545a373ede683def47.jpg', 'Sidebusch_.jpg', 5),
(624, 89, 'uploads/property-gallery/1723482540_43bca39b65b6600a5636.jpg', '1723482540_43bca39b65b6600a5636.jpg', 'Sidwaysfrontt_.jpg', 6),
(625, 90, 'uploads/property-gallery/1723483751_e857892ebfd62f560ff3.jpg', '1723483751_e857892ebfd62f560ff3.jpg', 'Congress_.jpg', 3),
(626, 90, 'uploads/property-gallery/1723483751_ae67b782905f17b48255.jpg', '1723483751_ae67b782905f17b48255.jpg', 'CongressCross.jpg', 2),
(627, 90, 'uploads/property-gallery/1723483751_40d2a10fe3539c31e06a.jpg', '1723483751_40d2a10fe3539c31e06a.jpg', 'Dollartree.jpg', 6),
(628, 90, 'uploads/property-gallery/1723483751_6fb48e794ccc870dbee5.jpg', '1723483751_6fb48e794ccc870dbee5.jpg', 'Winndixie _62186945.jpg', 1),
(675, 94, 'uploads/property-gallery/1725578574_4e5d53a2212547740669.png', '1725578574_4e5d53a2212547740669.png', 'Screenshot 2024-09-05 at 4.05.00 PM.png', 1),
(676, 94, 'uploads/property-gallery/1725578574_e09f36618f339c6e6719.jpg', '1725578574_e09f36618f339c6e6719.jpg', '4.jpg', 4),
(677, 94, 'uploads/property-gallery/1725578574_2f8336b8de2c2b52ea60.jpg', '1725578574_2f8336b8de2c2b52ea60.jpg', '3.jpg', 2),
(678, 94, 'uploads/property-gallery/1725578574_5a8bb974bbe96d6be2f1.png', '1725578574_5a8bb974bbe96d6be2f1.png', '2.png', 3),
(682, 93, 'uploads/property-gallery/1725579955_b66b666615e3083b48f2.png', '1725579955_b66b666615e3083b48f2.png', 'Screenshot 2024-09-05 at 4.03.56 PM.png', 1),
(683, 93, 'uploads/property-gallery/1725579959_19a0a5181e4c12a5a0af.png', '1725579959_19a0a5181e4c12a5a0af.png', '2.png', 2),
(684, 93, 'uploads/property-gallery/1725579967_81fbed36d416047bdee3.png', '1725579967_81fbed36d416047bdee3.png', '1.png', 3);

-- --------------------------------------------------------

--
-- Table structure for table `property_types`
--

CREATE TABLE `property_types` (
  `property_type_id` int NOT NULL,
  `property_type` varchar(110) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `property_types`
--

INSERT INTO `property_types` (`property_type_id`, `property_type`) VALUES
(1, 'Apartments'),
(2, 'Health Care'),
(3, 'Hotel'),
(5, 'Vacant Land'),
(9, 'Office'),
(11, 'Shopping Centers'),
(14, 'Convenience Store/Ga'),
(17, 'Education'),
(22, 'Other'),
(23, 'Retail'),
(24, 'Lease');

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `state_id` int NOT NULL,
  `state_code` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `state_name` varchar(50) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`state_id`, `state_code`, `state_name`) VALUES
(73, 'AL', 'Alabama'),
(75, 'FL', 'Florida');

-- --------------------------------------------------------

--
-- Table structure for table `subscribers`
--

CREATE TABLE `subscribers` (
  `subscriber_id` int NOT NULL,
  `emailaddress` varchar(110) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `subscribers`
--

INSERT INTO `subscribers` (`subscriber_id`, `emailaddress`) VALUES
(4, 'joecaldarelli@yahoo.com'),
(5, 'tkalas@msn.com'),
(6, 'nickrx@yahoo.com');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int NOT NULL,
  `firstname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `lastname` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `username` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `emailaddress` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `usertype` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `encryptedpass` varchar(110) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `firstname`, `lastname`, `username`, `emailaddress`, `password`, `usertype`, `encryptedpass`) VALUES
(4, 'Rustom', 'Codilan', 'admin', 'rustomcodilan@gmail.com', 'mis137', 'Administrator', '$2y$10$la4Hqt2.M8tQRBbqdiTStOn.3bJTOacYnjHbA802m.UP9oGKxMQS6'),
(5, 'Joe ', 'Caldarelli', 'Dhruv', 'joe@dhruvcommercial.com', 'Dhruv352$', 'Administrator', '$2y$10$HFbFWG1c3wDypcIDHMuS.OQagDrS0V68B.V2OyILD7Wdq6Q4Z5doO'),
(6, 'Nick', 'Caldarelli', 'Nick', 'Nick@dhruvcommercial.com', 'Dhruv352$', 'Administrator', '$2y$10$88c6ElUNMytBgAmhHQ63CuhWWn8xiyeugJkDzH2Z.9m4MfGYiY1xO');

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
-- Indexes for table `om_consents`
--
ALTER TABLE `om_consents`
  ADD PRIMARY KEY (`om_consent_id`),
  ADD KEY `property_id` (`property_id`);

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
  MODIFY `additional_listing_agent_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=230;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `city_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19828;

--
-- AUTO_INCREMENT for table `investment_highlights`
--
ALTER TABLE `investment_highlights`
  MODIFY `investment_highlight_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=687;

--
-- AUTO_INCREMENT for table `listing_agents`
--
ALTER TABLE `listing_agents`
  MODIFY `listing_agent_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `message_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `om_consents`
--
ALTER TABLE `om_consents`
  MODIFY `om_consent_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;

--
-- AUTO_INCREMENT for table `properties`
--
ALTER TABLE `properties`
  MODIFY `property_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=96;

--
-- AUTO_INCREMENT for table `property_galleries`
--
ALTER TABLE `property_galleries`
  MODIFY `property_gallery_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=685;

--
-- AUTO_INCREMENT for table `property_types`
--
ALTER TABLE `property_types`
  MODIFY `property_type_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `state_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `subscribers`
--
ALTER TABLE `subscribers`
  MODIFY `subscriber_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

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
-- Constraints for table `om_consents`
--
ALTER TABLE `om_consents`
  ADD CONSTRAINT `om_consents_ibfk_1` FOREIGN KEY (`property_id`) REFERENCES `properties` (`property_id`) ON DELETE RESTRICT ON UPDATE RESTRICT;

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
