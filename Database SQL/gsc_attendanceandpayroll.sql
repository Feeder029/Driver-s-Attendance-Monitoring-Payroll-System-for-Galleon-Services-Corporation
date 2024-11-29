-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 01, 2024 at 06:04 AM
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
-- Database: `gsc_attendanceandpayrolls`
--

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `ACC_ID` int(10) NOT NULL,
  `ACC_AcountStatID` int(10) NOT NULL,
  `ACC_Username` varchar(30) NOT NULL,
  `ACC_Password` varchar(30) NOT NULL,
  `ACC_ProfilePicture` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account_status`
--

CREATE TABLE `account_status` (
  `ACCS_ID` int(10) NOT NULL,
  `ACCS_Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_information`
--

CREATE TABLE `admin_information` (
  `AI_ID` int(10) NOT NULL,
  `AI_AccountID` int(10) NOT NULL,
  `AI_AdminPositionID` int(10) NOT NULL,
  `AI_AdminNameID` int(10) NOT NULL,
  `AI_Contact` varchar(30) NOT NULL,
  `AI_Email` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_name`
--

CREATE TABLE `admin_name` (
  `AN_ID` int(10) NOT NULL,
  `AN_FName` varchar(30) NOT NULL,
  `AN_MName` varchar(30) NOT NULL,
  `AN_LName` varchar(30) NOT NULL,
  `AN_Suffix` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `admin_role`
--

CREATE TABLE `admin_role` (
  `ARL_ID` int(10) NOT NULL,
  `ARL_Role` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `allowance`
--

CREATE TABLE `allowance` (
  `ALW_ID` int(10) NOT NULL,
  `ALW_Amount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `ATT_ID` int(10) NOT NULL,
  `ATT_DriverID` int(10) NOT NULL,
  `ATT_DeliveryID` int(10) NOT NULL,
  `ATT_Date` date NOT NULL,
  `ATT_TimeIn` time NOT NULL,
  `ATT_TimeOut` time NOT NULL,
  `ATT_Status` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attendance_summary`
--

CREATE TABLE `attendance_summary` (
  `ASUM_ID` int(10) NOT NULL,
  `ASUM_DriverID` int(10) NOT NULL,
  `ASUM_NormalDay` int(10) NOT NULL,
  `ASUM_SpecialHoliday` int(10) NOT NULL,
  `ASUM_RegularHoliday` int(10) NOT NULL,
  `ASUM_OverallAttendance` int(10) NOT NULL,
  `ASUM_DateStart` date NOT NULL,
  `ASUM_DateEnd` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `basic_pay`
--

CREATE TABLE `basic_pay` (
  `BP_ID` int(10) NOT NULL,
  `BP_HubRateID` int(10) NOT NULL,
  `BP_AttendanceSumID` int(10) NOT NULL,
  `BP_AllowanceID` int(10) NOT NULL,
  `BP_TotalAmount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contribution`
--

CREATE TABLE `contribution` (
  `CON_ID` int(10) NOT NULL,
  `CON_GovInfoID` int(10) NOT NULL,
  `CON_PagibigContribution` double(10,2) NOT NULL,
  `CON_PhilHealthContribution` double(10,2) NOT NULL,
  `CON_SSSContribution` double(10,2) NOT NULL,
  `CON_TotalAmount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_information`
--

CREATE TABLE `delivery_information` (
  `DEL_ID` int(10) NOT NULL,
  `DEL_ParcelCarried` int(10) NOT NULL,
  `DEL_ParcelDelivered` int(10) NOT NULL,
  `DEL_ParcelReturned` int(10) NOT NULL,
  `DEL_RemittanceReciept` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_address`
--

CREATE TABLE `driver_address` (
  `DA_ID` int(10) NOT NULL,
  `DA_HouseNo` varchar(30) NOT NULL,
  `DA_LotNo` varchar(30) NOT NULL,
  `DA_Street` varchar(30) NOT NULL,
  `DA_Barangay` varchar(30) NOT NULL,
  `DA_City` varchar(30) NOT NULL,
  `DA_Province` varchar(30) NOT NULL,
  `DA_ZipCode` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_information`
--

CREATE TABLE `driver_information` (
  `DI_ID` int(10) NOT NULL,
  `DI_AccountID` int(10) NOT NULL,
  `DI_NameID` int(10) NOT NULL,
  `DI_AddressID` int(10) NOT NULL,
  `DI_UnitTypeID` int(10) NOT NULL,
  `DI_HubAssignedID` int(10) NOT NULL,
  `DI_GovInfoID` int(10) NOT NULL,
  `DI_Age` int(10) NOT NULL,
  `DI_ContactNo` varchar(30) NOT NULL,
  `DI_Gender` varchar(30) NOT NULL,
  `DI_DOB` date NOT NULL,
  `DI_Email` varchar(30) NOT NULL,
  `DI_LicenseImg` longblob NOT NULL,
  `DI_BrgyClearanceImg` longblob NOT NULL,
  `DI_PoliceClearanceImg` longblob NOT NULL,
  `DI_NBIClearanceImg` longblob NOT NULL,
  `Gcash_No` varchar(30) NOT NULL,
  `GCash_Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_name`
--

CREATE TABLE `driver_name` (
  `DN_ID` int(10) NOT NULL,
  `DN_FName` varchar(30) NOT NULL,
  `DN_MName` varchar(30) NOT NULL,
  `DN_LName` varchar(30) NOT NULL,
  `DN_Suffix` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_unit_type`
--

CREATE TABLE `driver_unit_type` (
  `DUT_ID` int(10) NOT NULL,
  `DUT_UnitType` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `driver_vehicle`
--

CREATE TABLE `driver_vehicle` (
  `DV_ID` int(10) NOT NULL,
  `DV_DriverID` int(30) NOT NULL,
  `DV_VehiclePlate` varchar(30) NOT NULL,
  `DV_ORImg` longblob NOT NULL,
  `DV_CRImg` longblob NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `government_information`
--

CREATE TABLE `government_information` (
  `GOV_ID` int(10) NOT NULL,
  `GOV_PhilHealthNo` varchar(30) NOT NULL,
  `GOV_SSSNo` varchar(30) NOT NULL,
  `GOV_PagibigNo` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hub_address`
--

CREATE TABLE `hub_address` (
  `HADD_ID` int(10) NOT NULL,
  `HADD_Barangay` varchar(30) NOT NULL,
  `HADD_City` varchar(30) NOT NULL,
  `HADD_Province` varchar(30) NOT NULL,
  `HADD_ZipCode` int(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hub_assigned`
--

CREATE TABLE `hub_assigned` (
  `HASS_ID` int(10) NOT NULL,
  `HASS_AddressID` int(10) NOT NULL,
  `HASS_Name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hub_rate`
--

CREATE TABLE `hub_rate` (
  `HUBR_ID` int(10) NOT NULL,
  `HUBR_HubID` int(10) NOT NULL,
  `HUBR_Rate` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pagibig`
--

CREATE TABLE `pagibig` (
  `PBIG_No` varchar(30) NOT NULL,
  `PBIG_Start` double(10,2) NOT NULL,
  `PBIG_End` double(10,2) NOT NULL,
  `PBIG_ERPercent` decimal(10,2) NOT NULL,
  `PBIG_EEPercent` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payroll`
--

CREATE TABLE `payroll` (
  `PAY_ID` int(10) NOT NULL,
  `PAY_DriverID` int(10) NOT NULL,
  `PAY_BasicPayID` int(10) NOT NULL,
  `PAY_ContributionID` int(10) NOT NULL,
  `PAY_TotalAmount` double(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `philhealth`
--

CREATE TABLE `philhealth` (
  `PHI_No` varchar(30) NOT NULL,
  `PHI_Period` varchar(30) NOT NULL,
  `PHI_ERPercent` decimal(10,2) NOT NULL,
  `PHI_EEPercent` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sss`
--

CREATE TABLE `sss` (
  `SSS_No` varchar(30) NOT NULL,
  `SSS_Period` varchar(30) NOT NULL,
  `SSS_ERPercent` decimal(10,2) NOT NULL,
  `SSS_EEPercent` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`ACC_ID`);

--
-- Indexes for table `account_status`
--
ALTER TABLE `account_status`
  ADD PRIMARY KEY (`ACCS_ID`);

--
-- Indexes for table `admin_information`
--
ALTER TABLE `admin_information`
  ADD PRIMARY KEY (`AI_ID`);

--
-- Indexes for table `admin_name`
--
ALTER TABLE `admin_name`
  ADD PRIMARY KEY (`AN_ID`);

--
-- Indexes for table `admin_role`
--
ALTER TABLE `admin_role`
  ADD PRIMARY KEY (`ARL_ID`);

--
-- Indexes for table `allowance`
--
ALTER TABLE `allowance`
  ADD PRIMARY KEY (`ALW_ID`);

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`ATT_ID`);

--
-- Indexes for table `attendance_summary`
--
ALTER TABLE `attendance_summary`
  ADD PRIMARY KEY (`ASUM_ID`);

--
-- Indexes for table `contribution`
--
ALTER TABLE `contribution`
  ADD PRIMARY KEY (`CON_ID`);

--
-- Indexes for table `delivery_information`
--
ALTER TABLE `delivery_information`
  ADD PRIMARY KEY (`DEL_ID`);

--
-- Indexes for table `driver_address`
--
ALTER TABLE `driver_address`
  ADD PRIMARY KEY (`DA_ID`);

--
-- Indexes for table `driver_information`
--
ALTER TABLE `driver_information`
  ADD PRIMARY KEY (`DI_ID`);

--
-- Indexes for table `driver_name`
--
ALTER TABLE `driver_name`
  ADD PRIMARY KEY (`DN_ID`);

--
-- Indexes for table `driver_unit_type`
--
ALTER TABLE `driver_unit_type`
  ADD PRIMARY KEY (`DUT_ID`);

--
-- Indexes for table `driver_vehicle`
--
ALTER TABLE `driver_vehicle`
  ADD PRIMARY KEY (`DV_ID`);

--
-- Indexes for table `government_information`
--
ALTER TABLE `government_information`
  ADD PRIMARY KEY (`GOV_ID`);

--
-- Indexes for table `hub_address`
--
ALTER TABLE `hub_address`
  ADD PRIMARY KEY (`HADD_ID`);

--
-- Indexes for table `hub_assigned`
--
ALTER TABLE `hub_assigned`
  ADD PRIMARY KEY (`HASS_ID`);

--
-- Indexes for table `hub_rate`
--
ALTER TABLE `hub_rate`
  ADD PRIMARY KEY (`HUBR_ID`);

--
-- Indexes for table `payroll`
--
ALTER TABLE `payroll`
  ADD PRIMARY KEY (`PAY_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `ACC_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account_status`
--
ALTER TABLE `account_status`
  MODIFY `ACCS_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_information`
--
ALTER TABLE `admin_information`
  MODIFY `AI_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_name`
--
ALTER TABLE `admin_name`
  MODIFY `AN_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `admin_role`
--
ALTER TABLE `admin_role`
  MODIFY `ARL_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `allowance`
--
ALTER TABLE `allowance`
  MODIFY `ALW_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `ATT_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attendance_summary`
--
ALTER TABLE `attendance_summary`
  MODIFY `ASUM_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contribution`
--
ALTER TABLE `contribution`
  MODIFY `CON_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_information`
--
ALTER TABLE `delivery_information`
  MODIFY `DEL_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_address`
--
ALTER TABLE `driver_address`
  MODIFY `DA_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_name`
--
ALTER TABLE `driver_name`
  MODIFY `DN_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_unit_type`
--
ALTER TABLE `driver_unit_type`
  MODIFY `DUT_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `driver_vehicle`
--
ALTER TABLE `driver_vehicle`
  MODIFY `DV_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `government_information`
--
ALTER TABLE `government_information`
  MODIFY `GOV_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hub_address`
--
ALTER TABLE `hub_address`
  MODIFY `HADD_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hub_assigned`
--
ALTER TABLE `hub_assigned`
  MODIFY `HASS_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hub_rate`
--
ALTER TABLE `hub_rate`
  MODIFY `HUBR_ID` int(10) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payroll`
--
ALTER TABLE `payroll`
  MODIFY `PAY_ID` int(10) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
