-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 06:42 PM
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
-- Database: `meat_based_product`
--

-- --------------------------------------------------------

--
-- Table structure for table `audit_log`
--

CREATE TABLE `audit_log` (
  `Log_ID` int(11) NOT NULL,
  `User_ID` int(11) DEFAULT NULL,
  `Action` varchar(255) NOT NULL,
  `Table_Affected` varchar(50) NOT NULL,
  `Record_ID` int(11) DEFAULT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cattle`
--

CREATE TABLE `cattle` (
  `Cattle_ID` int(11) NOT NULL,
  `Breed` varchar(50) NOT NULL,
  `Birthdate` date NOT NULL,
  `Health_Status` varchar(100) NOT NULL DEFAULT 'Healthy',
  `Farm_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cattle`
--

INSERT INTO `cattle` (`Cattle_ID`, `Breed`, `Birthdate`, `Health_Status`, `Farm_ID`) VALUES
(1, 'Angus', '2020-03-15', 'Healthy', 1),
(2, 'Holstein', '2021-06-25', 'Healthy', 2),
(3, 'Jersey', '2020-11-05', 'Sick', 3);

-- --------------------------------------------------------

--
-- Table structure for table `cattle_health`
--

CREATE TABLE `cattle_health` (
  `Health_ID` int(11) NOT NULL,
  `Cattle_ID` int(11) NOT NULL,
  `Date` date NOT NULL,
  `Health_Issue` varchar(255) NOT NULL,
  `Treatment_Type` varchar(100) NOT NULL,
  `Treatment_Dosage` varchar(100) NOT NULL,
  `Treatment_Frequency` varchar(50) NOT NULL,
  `Vaccination_Type` varchar(100) DEFAULT NULL,
  `Vaccination_Date` date DEFAULT NULL,
  `Cost` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cattle_health`
--

INSERT INTO `cattle_health` (`Health_ID`, `Cattle_ID`, `Date`, `Health_Issue`, `Treatment_Type`, `Treatment_Dosage`, `Treatment_Frequency`, `Vaccination_Type`, `Vaccination_Date`, `Cost`) VALUES
(1, 1, '2023-05-01', 'Foot and Mouth', 'Antibiotics', '50mg', 'Once a day', 'Flu', '2023-05-02', 20.00),
(2, 2, '2023-07-15', 'None', 'None', 'None', 'N/A', 'Rabies', '2023-07-16', 0.00),
(3, 3, '2023-08-20', 'Lung Infection', 'Antibiotics', '100mg', 'Twice a day', 'None', '2023-08-22', 30.00);

-- --------------------------------------------------------

--
-- Table structure for table `delivery`
--

CREATE TABLE `delivery` (
  `Delivery_ID` int(11) NOT NULL,
  `Transport_ID` int(11) NOT NULL,
  `Store_ID` int(11) NOT NULL,
  `Delivery_Date` date NOT NULL,
  `Received_By` varchar(100) NOT NULL,
  `Delivery_Status` varchar(50) NOT NULL DEFAULT 'Pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `delivery`
--

INSERT INTO `delivery` (`Delivery_ID`, `Transport_ID`, `Store_ID`, `Delivery_Date`, `Received_By`, `Delivery_Status`) VALUES
(1, 1, 1, '2023-06-07', 'John Smith', 'Completed'),
(2, 2, 2, '2023-07-14', 'Sarah Johnson', 'Completed'),
(3, 3, 3, '2023-08-22', 'Michael Brown', 'Completed');

-- --------------------------------------------------------

--
-- Table structure for table `diet_chart`
--

CREATE TABLE `diet_chart` (
  `Food_ID` int(11) NOT NULL,
  `Cattle_ID` int(11) NOT NULL,
  `Type_of_Food` varchar(100) NOT NULL,
  `Quantity` float NOT NULL,
  `Date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diet_chart`
--

INSERT INTO `diet_chart` (`Food_ID`, `Cattle_ID`, `Type_of_Food`, `Quantity`, `Date`) VALUES
(1, 1, 'Grass', 10, '2023-05-02'),
(2, 2, 'Corn', 15, '2023-07-17'),
(3, 3, 'Hay', 12, '2023-08-23');

-- --------------------------------------------------------

--
-- Table structure for table `farm`
--

CREATE TABLE `farm` (
  `Farm_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(50) NOT NULL,
  `ZIP` varchar(20) NOT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm`
--

INSERT INTO `farm` (`Farm_ID`, `Name`, `Street`, `City`, `State`, `ZIP`, `Latitude`, `Longitude`) VALUES
(1, 'Greenfield Farm BD', '23 Kazi Nazrul Ave', 'Dhaka', 'Dhaka Division', '1205', 23.74646600, 90.37601500),
(2, 'Sunny Acres BD', '45 Station Road', 'Chattogram', 'Chattogram Division', '4000', 22.35685100, 91.78318200),
(3, 'Riverbend Farms BD', '89 Khalpar Lane', 'Sylhet', 'Sylhet Division', '3100', 24.89493000, 91.86870600);

-- --------------------------------------------------------

--
-- Table structure for table `farm_contactinfo`
--

CREATE TABLE `farm_contactinfo` (
  `Farm_ID` int(11) NOT NULL,
  `Phone` varchar(20) NOT NULL,
  `Email` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `farm_contactinfo`
--

INSERT INTO `farm_contactinfo` (`Farm_ID`, `Phone`, `Email`) VALUES
(1, '123-456-7890', 'contact@greenfield.com'),
(2, '987-654-3210', 'info@sunnyacres.com'),
(3, '555-123-4567', 'support@riverbendfarms.com');

-- --------------------------------------------------------

--
-- Table structure for table `meat_batch`
--

CREATE TABLE `meat_batch` (
  `Batch_ID` int(11) NOT NULL,
  `Date_Processed` date NOT NULL,
  `Quantity` int(11) NOT NULL,
  `Grade_ID` int(11) NOT NULL,
  `Cattle_ID` int(11) NOT NULL,
  `Weight` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meat_batch`
--

INSERT INTO `meat_batch` (`Batch_ID`, `Date_Processed`, `Quantity`, `Grade_ID`, `Cattle_ID`, `Weight`) VALUES
(1, '2023-06-05', 50, 1, 1, 120.50),
(2, '2023-07-12', 40, 2, 2, 100.75),
(3, '2023-08-20', 30, 3, 3, 95.20);

-- --------------------------------------------------------

--
-- Table structure for table `meat_product_grade`
--

CREATE TABLE `meat_product_grade` (
  `Grade_ID` int(11) NOT NULL,
  `Description` text NOT NULL,
  `Quality_Score` decimal(3,2) NOT NULL,
  `Average_Weight` decimal(5,2) NOT NULL,
  `Texture_Quality` varchar(50) NOT NULL,
  `Date_of_Grading` date NOT NULL,
  `Product_Type_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meat_product_grade`
--

INSERT INTO `meat_product_grade` (`Grade_ID`, `Description`, `Quality_Score`, `Average_Weight`, `Texture_Quality`, `Date_of_Grading`, `Product_Type_ID`) VALUES
(1, 'Grade A beef, well marbled with excellent tenderness', 9.50, 150.00, 'Tender', '2025-05-01', 1),
(2, 'Grade B pork, lean with a good balance of fat', 8.00, 120.00, 'Medium', '2025-05-02', 2),
(3, 'Grade A chicken, free-range and hormone-free', 9.00, 3.50, 'Tender', '2025-05-03', 3);

-- --------------------------------------------------------

--
-- Table structure for table `meat_product_type`
--

CREATE TABLE `meat_product_type` (
  `Product_Type_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Description` text NOT NULL,
  `Cattle_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `meat_product_type`
--

INSERT INTO `meat_product_type` (`Product_Type_ID`, `Name`, `Description`, `Cattle_ID`) VALUES
(1, 'Beef', 'High quality beef from mature cattle', 1),
(2, 'Pork', 'Tender pork from young pigs', 2),
(3, 'Chicken', 'Fresh chicken from healthy poultry', 3);

-- --------------------------------------------------------
--
-- Table structure for table `package`
--

CREATE TABLE `package` (
  `Package_ID` int(11) NOT NULL,
  `Processed_Batch_ID` int(11) NOT NULL,
  `Package_Type` varchar(100) NOT NULL,
  `Weight` float NOT NULL,
  `Date_Packaged` date NOT NULL,
  `ZIP` varchar(20) NOT NULL,
  `Storage_Temperature` float DEFAULT NULL,
  `Expiration_Date` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `package`
--

INSERT INTO `package` (`Package_ID`, `Processed_Batch_ID`, `Package_Type`, `Weight`, `Date_Packaged`, `ZIP`, `Storage_Temperature`, `Expiration_Date`) VALUES
(1, 1, 'Vacuum Sealed', 50.5, '2023-06-06', '94501', 4, '2023-07-06'),
(2, 2, 'Frozen', 40, '2023-07-13', '75001', -18, '2023-10-13'),
(3, 3, 'Chilled', 30, '2023-08-21', '33301', 2, '2023-08-28'),
(5, 1, 'Frozen', 20, '2025-04-08', '85104', NULL, NULL),
(6, 3, 'Chilled', 89, '2025-02-10', '60138', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `processed_meat_batch`
--

CREATE TABLE `processed_meat_batch` (
  `Processed_Batch_ID` int(11) NOT NULL,
  `Batch_ID` int(11) NOT NULL,
  `House_ID` int(11) NOT NULL,
  `Date_Processed` date NOT NULL,
  `Final_Weight` float NOT NULL,
  `Quality` varchar(100) NOT NULL,
  `Processing_Notes` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `processed_meat_batch`
--

INSERT INTO `processed_meat_batch` (`Processed_Batch_ID`, `Batch_ID`, `House_ID`, `Date_Processed`, `Final_Weight`, `Quality`, `Processing_Notes`) VALUES
(1, 1, 1, '2023-06-06', 50.5, 'High', 'Excellent processing conditions'),
(2, 2, 2, '2023-07-13', 40, 'Medium', 'Minor issues with temperature control'),
(3, 3, 3, '2023-08-21', 30, 'High', 'Perfect conditions maintained');

-- --------------------------------------------------------

--
-- Table structure for table `retail_store`
--

CREATE TABLE `retail_store` (
  `Store_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Street` varchar(255) NOT NULL,
  `City` varchar(100) NOT NULL,
  `State` varchar(50) NOT NULL,
  `ZIP` varchar(20) NOT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  `Store_Type` varchar(50) DEFAULT NULL,
  `Stock_Value` decimal(12,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `retail_store`
--

INSERT INTO `retail_store` (`Store_ID`, `Name`, `Street`, `City`, `State`, `ZIP`, `Latitude`, `Longitude`, `Store_Type`, `Stock_Value`) VALUES
(1, 'Dhaka Central Slaughterhouse', '12 Gulshan Ave', 'Dhaka', 'Dhaka Division', '1212', 23.78088750, 90.41657410, 'Supermarket', 125000.00),
(2, 'Chattogram Meat Processing', '55 Agrabad C/A', 'Chattogram', 'Chattogram Division', '4100', 22.34753700, 91.81233200, 'Convenience', 48000.50),
(3, 'Sylhet East End Slaughterhouse', '77 Zindabazar Rd', 'Sylhet', 'Sylhet Division', '3100', 24.89983700, 91.86910800, 'Wholesale', 198000.75);

-- --------------------------------------------------------

--
-- Table structure for table `sensor_data`
--

CREATE TABLE `sensor_data` (
  `Sensor_Data_ID` int(11) NOT NULL,
  `Sensor_ID` int(11) NOT NULL,
  `Temperature` float DEFAULT NULL,
  `Humidity` float DEFAULT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL,
  `Timestamp` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_data`
--

INSERT INTO `sensor_data` (`Sensor_Data_ID`, `Sensor_ID`, `Temperature`, `Humidity`, `Latitude`, `Longitude`, `Timestamp`) VALUES
(1, 1, 25.5, 60, 23.81030000, 90.41250000, '2023-06-07 08:00:00'),
(2, 2, 27.3, 65, 22.35690000, 91.78320000, '2023-07-15 09:00:00'),
(3, 3, 23.8, 58, 24.89490000, 91.86870000, '2023-08-22 10:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `sensor_device`
--

CREATE TABLE `sensor_device` (
  `Sensor_ID` int(11) NOT NULL,
  `Sensor_Type` varchar(100) NOT NULL,
  `Installation_Date` date NOT NULL,
  `Transport_ID` int(11) NOT NULL,
  `Status` varchar(50) NOT NULL DEFAULT 'Active',
  `Last_Calibration` date NOT NULL,
  `Sensor_Quality` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sensor_device`
--

INSERT INTO `sensor_device` (`Sensor_ID`, `Sensor_Type`, `Installation_Date`, `Transport_ID`, `Status`, `Last_Calibration`, `Sensor_Quality`) VALUES
(1, 'Temperature', '2023-06-01', 1, 'Active', '2023-05-15', 'Good'),
(2, 'Humidity', '2023-07-10', 2, 'Active', '2023-06-20', 'Fair'),
(3, 'GPS', '2023-08-15', 3, 'Active', '2023-07-10', 'Good');

-- --------------------------------------------------------

--
-- Table structure for table `slaughtering_house`
--

CREATE TABLE `slaughtering_house` (
  `House_ID` int(11) NOT NULL,
  `Name` varchar(100) NOT NULL,
  `Location` varchar(255) NOT NULL,
  `Capacity` int(11) NOT NULL,
  `Health_Inspection_Report` varchar(50) NOT NULL,
  `Processing_Time` time NOT NULL,
  `Last_Inspection_Date` date NOT NULL,
  `Latitude` decimal(10,8) DEFAULT NULL,
  `Longitude` decimal(11,8) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `slaughtering_house`
--

INSERT INTO `slaughtering_house` (`House_ID`, `Name`, `Location`, `Capacity`, `Health_Inspection_Report`, `Processing_Time`, `Last_Inspection_Date`, `Latitude`, `Longitude`) VALUES
(1, 'Dhaka Central Slaughterhouse', '120 Tejgaon Industrial Area, Dhaka', 200, 'Passed', '08:00:00', '2023-05-15', 23.76293600, 90.39380100),
(2, 'Chattogram Meat Processing', '77 Agrabad, Chattogram', 150, 'Passed', '09:00:00', '2023-06-20', 22.33922000, 91.83126800),
(3, 'Sylhet East End Slaughterhouse', '45 Zindabazar, Sylhet', 100, 'Failed', '10:00:00', '2023-07-10', 24.89171500, 91.88339500);

-- --------------------------------------------------------

--
-- Table structure for table `transport`
--

CREATE TABLE `transport` (
  `Transport_ID` int(11) NOT NULL,
  `Vehicle_Type` varchar(100) NOT NULL,
  `License_Plate` varchar(50) NOT NULL,
  `Transport_Date` date NOT NULL,
  `Transportation_Duration` time NOT NULL,
  `Departure_Location` varchar(255) NOT NULL,
  `Destination` varchar(255) NOT NULL,
  `Driver_Name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport`
--

INSERT INTO `transport` (`Transport_ID`, `Vehicle_Type`, `License_Plate`, `Transport_Date`, `Transportation_Duration`, `Departure_Location`, `Destination`, `Driver_Name`) VALUES
(1, 'Truck', 'DHK-1234', '2023-06-07', '02:00:00', 'Greenfield Farm BD', 'Dhaka Central Slaughterhouse', 'Hasan Ahmed'),
(2, 'Refrigerated Truck', 'CTG-5678', '2023-07-14', '01:30:00', 'Sunny Acres BD', 'Chattogram Meat Processing', 'Rehana Sultana'),
(3, 'Van', 'SYL-9876', '2023-08-22', '03:00:00', 'Riverbend Farms BD', 'Sylhet East End Slaughterhouse', 'Nayeem Islam');

-- --------------------------------------------------------

--
-- Table structure for table `transport_package`
--

CREATE TABLE `transport_package` (
  `Transport_ID` int(11) NOT NULL,
  `Package_ID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transport_package`
--

INSERT INTO `transport_package` (`Transport_ID`, `Package_ID`) VALUES
(1, 1),
(2, 2),
(3, 3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(20) NOT NULL DEFAULT 'user',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'admin', 'admin@gmail.com', '$2y$10$z4tSigMSBnF5r7XltoBwQeUDThnz7wk0FpDtynsryT3akeZsa/lhW', 'admin', '2025-04-13 12:33:18'),
(2, 'admin2', 'admin2@gmail.com', '$2y$10$w2xOBqE1ht4reorJhfo5CeG2hBXnElbJamEMJY8FwUFKyVysltHaS', 'admin', '2025-04-13 12:41:34'),
(3, 'admin3', 'admin3@gmail.com', '$2y$10$5QFAwqy.MIxYVLxmoaQc4ey88KUXjaKQnYBCbF/zcFb8EpKGx.ay6', 'user', '2025-04-13 14:56:28');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD PRIMARY KEY (`Log_ID`),
  ADD KEY `User_ID` (`User_ID`);

--
-- Indexes for table `cattle`
--
ALTER TABLE `cattle`
  ADD PRIMARY KEY (`Cattle_ID`),
  ADD KEY `Farm_ID` (`Farm_ID`);

--
-- Indexes for table `cattle_health`
--
ALTER TABLE `cattle_health`
  ADD PRIMARY KEY (`Health_ID`),
  ADD KEY `Cattle_ID` (`Cattle_ID`);

--
-- Indexes for table `delivery`
--
ALTER TABLE `delivery`
  ADD PRIMARY KEY (`Delivery_ID`),
  ADD KEY `Transport_ID` (`Transport_ID`),
  ADD KEY `Store_ID` (`Store_ID`);

--
-- Indexes for table `diet_chart`
--
ALTER TABLE `diet_chart`
  ADD PRIMARY KEY (`Food_ID`),
  ADD KEY `Cattle_ID` (`Cattle_ID`);

--
-- Indexes for table `farm`
--
ALTER TABLE `farm`
  ADD PRIMARY KEY (`Farm_ID`);

--
-- Indexes for table `farm_contactinfo`
--
ALTER TABLE `farm_contactinfo`
  ADD KEY `Farm_ID` (`Farm_ID`);

--
-- Indexes for table `meat_batch`
--
ALTER TABLE `meat_batch`
  ADD PRIMARY KEY (`Batch_ID`),
  ADD KEY `Grade_ID` (`Grade_ID`),
  ADD KEY `Cattle_ID` (`Cattle_ID`);

--
-- Indexes for table `meat_product_grade`
--
ALTER TABLE `meat_product_grade`
  ADD PRIMARY KEY (`Grade_ID`),
  ADD KEY `Product_Type_ID` (`Product_Type_ID`);

--
-- Indexes for table `meat_product_type`
--
ALTER TABLE `meat_product_type`
  ADD PRIMARY KEY (`Product_Type_ID`),
  ADD KEY `Cattle_ID` (`Cattle_ID`);

--

-- Indexes for table `package`
--
ALTER TABLE `package`
  ADD PRIMARY KEY (`Package_ID`),
  ADD KEY `Processed_Batch_ID` (`Processed_Batch_ID`);

--
-- Indexes for table `processed_meat_batch`
--
ALTER TABLE `processed_meat_batch`
  ADD PRIMARY KEY (`Processed_Batch_ID`),
  ADD KEY `Batch_ID` (`Batch_ID`),
  ADD KEY `House_ID` (`House_ID`);

--
-- Indexes for table `retail_store`
--
ALTER TABLE `retail_store`
  ADD PRIMARY KEY (`Store_ID`);

--
-- Indexes for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD PRIMARY KEY (`Sensor_Data_ID`),
  ADD KEY `Sensor_ID` (`Sensor_ID`);

--
-- Indexes for table `sensor_device`
--
ALTER TABLE `sensor_device`
  ADD PRIMARY KEY (`Sensor_ID`),
  ADD KEY `Transport_ID` (`Transport_ID`);

--
-- Indexes for table `slaughtering_house`
--
ALTER TABLE `slaughtering_house`
  ADD PRIMARY KEY (`House_ID`);

--
-- Indexes for table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`Transport_ID`);

--
-- Indexes for table `transport_package`
--
ALTER TABLE `transport_package`
  ADD PRIMARY KEY (`Transport_ID`,`Package_ID`),
  ADD KEY `Package_ID` (`Package_ID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `audit_log`
--
ALTER TABLE `audit_log`
  MODIFY `Log_ID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cattle`
--
ALTER TABLE `cattle`
  MODIFY `Cattle_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `cattle_health`
--
ALTER TABLE `cattle_health`
  MODIFY `Health_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `delivery`
--
ALTER TABLE `delivery`
  MODIFY `Delivery_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `diet_chart`
--
ALTER TABLE `diet_chart`
  MODIFY `Food_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `farm`
--
ALTER TABLE `farm`
  MODIFY `Farm_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meat_batch`
--
ALTER TABLE `meat_batch`
  MODIFY `Batch_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meat_product_grade`
--
ALTER TABLE `meat_product_grade`
  MODIFY `Grade_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `meat_product_type`
--
ALTER TABLE `meat_product_type`
  MODIFY `Product_Type_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `package`
--
ALTER TABLE `package`
  MODIFY `Package_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `processed_meat_batch`
--
ALTER TABLE `processed_meat_batch`
  MODIFY `Processed_Batch_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `retail_store`
--
ALTER TABLE `retail_store`
  MODIFY `Store_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `sensor_data`
--
ALTER TABLE `sensor_data`
  MODIFY `Sensor_Data_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `sensor_device`
--
ALTER TABLE `sensor_device`
  MODIFY `Sensor_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `slaughtering_house`
--
ALTER TABLE `slaughtering_house`
  MODIFY `House_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transport`
--
ALTER TABLE `transport`
  MODIFY `Transport_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `audit_log`
--
ALTER TABLE `audit_log`
  ADD CONSTRAINT `audit_log_ibfk_1` FOREIGN KEY (`User_ID`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `cattle`
--
ALTER TABLE `cattle`
  ADD CONSTRAINT `cattle_ibfk_1` FOREIGN KEY (`Farm_ID`) REFERENCES `farm` (`Farm_ID`);

--
-- Constraints for table `cattle_health`
--
ALTER TABLE `cattle_health`
  ADD CONSTRAINT `cattle_health_ibfk_1` FOREIGN KEY (`Cattle_ID`) REFERENCES `cattle` (`Cattle_ID`);

--
-- Constraints for table `delivery`
--
ALTER TABLE `delivery`
  ADD CONSTRAINT `delivery_ibfk_1` FOREIGN KEY (`Transport_ID`) REFERENCES `transport` (`Transport_ID`),
  ADD CONSTRAINT `delivery_ibfk_2` FOREIGN KEY (`Store_ID`) REFERENCES `retail_store` (`Store_ID`);

--
-- Constraints for table `diet_chart`
--
ALTER TABLE `diet_chart`
  ADD CONSTRAINT `diet_chart_ibfk_1` FOREIGN KEY (`Cattle_ID`) REFERENCES `cattle` (`Cattle_ID`);

--
-- Constraints for table `farm_contactinfo`
--
ALTER TABLE `farm_contactinfo`
  ADD CONSTRAINT `farm_contactinfo_ibfk_1` FOREIGN KEY (`Farm_ID`) REFERENCES `farm` (`Farm_ID`);

--
-- Constraints for table `meat_batch`
--
ALTER TABLE `meat_batch`
  ADD CONSTRAINT `meat_batch_ibfk_1` FOREIGN KEY (`Grade_ID`) REFERENCES `meat_product_grade` (`Grade_ID`),
  ADD CONSTRAINT `meat_batch_ibfk_2` FOREIGN KEY (`Cattle_ID`) REFERENCES `cattle` (`Cattle_ID`);

--
-- Constraints for table `meat_product_grade`
--
ALTER TABLE `meat_product_grade`
  ADD CONSTRAINT `meat_product_grade_ibfk_1` FOREIGN KEY (`Product_Type_ID`) REFERENCES `meat_product_type` (`Product_Type_ID`);

--
-- Constraints for table `package`
--
ALTER TABLE `package`
  ADD CONSTRAINT `package_ibfk_1` FOREIGN KEY (`Processed_Batch_ID`) REFERENCES `processed_meat_batch` (`Processed_Batch_ID`);

--
-- Constraints for table `processed_meat_batch`
--
ALTER TABLE `processed_meat_batch`
  ADD CONSTRAINT `processed_meat_batch_ibfk_1` FOREIGN KEY (`Batch_ID`) REFERENCES `meat_batch` (`Batch_ID`),
  ADD CONSTRAINT `processed_meat_batch_ibfk_2` FOREIGN KEY (`House_ID`) REFERENCES `slaughtering_house` (`House_ID`);

--
-- Constraints for table `sensor_data`
--
ALTER TABLE `sensor_data`
  ADD CONSTRAINT `sensor_data_ibfk_1` FOREIGN KEY (`Sensor_ID`) REFERENCES `sensor_device` (`Sensor_ID`);

--
-- Constraints for table `sensor_device`
--
ALTER TABLE `sensor_device`
  ADD CONSTRAINT `sensor_device_ibfk_1` FOREIGN KEY (`Transport_ID`) REFERENCES `transport` (`Transport_ID`);

--
-- Constraints for table `transport_package`
--
ALTER TABLE `transport_package`
  ADD CONSTRAINT `transport_package_ibfk_1` FOREIGN KEY (`Transport_ID`) REFERENCES `transport` (`Transport_ID`),
  ADD CONSTRAINT `transport_package_ibfk_2` FOREIGN KEY (`Package_ID`) REFERENCES `package` (`Package_ID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
