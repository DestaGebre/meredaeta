-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Dec 09, 2018 at 07:47 AM
-- Server version: 5.7.9
-- PHP Version: 5.6.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `tplfparty`
--

-- --------------------------------------------------------

--
-- Table structure for table `approved_hitsuys`
--

DROP TABLE IF EXISTS `approved_hitsuys`;
CREATE TABLE IF NOT EXISTS `approved_hitsuys` (
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `membershipDate` date NOT NULL,
  `membershipType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zoneworedaCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `grossSalary` decimal(10,2) NOT NULL,
  `netSalary` decimal(10,2) NOT NULL,
  `assignedWudabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedWahio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedAssoc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `wahioposition` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ተራ ኣባል',
  `meseratawiposition` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ተራ ኣባል',
  `fileNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `memberType` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ተራ ኣባል',
  `approved_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT '1',
  `isReported` tinyint(1) NOT NULL,
  `hasRequested` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `approved_hitsuys`
--

INSERT INTO `approved_hitsuys` (`hitsuyID`, `membershipDate`, `membershipType`, `zoneworedaCode`, `grossSalary`, `netSalary`, `assignedWudabe`, `assignedWahio`, `assignedAssoc`, `wahioposition`, `meseratawiposition`, `fileNumber`, `memberType`, `approved_status`, `isReported`, `hasRequested`, `isApproved`, `created_at`, `updated_at`) VALUES
('0202002/002/10', '2011-03-02', 'ተጋዳላይ', '0202', '5000.00', '4300.00', '00102', '2', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '2342/234', 'ላዕለዋይ ኣመራርሓ', '1', 1, 1, 1, '2018-11-11 14:26:40', '2018-11-11 14:26:40'),
('0101001/001/10', '2011-02-21', 'ተጋዳላይ', '0101', '5000.00', '4300.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '234/2343', 'ላዕለዋይ ኣመራርሓ', '1', 1, 1, 1, '2018-10-31 12:55:19', '2018-10-31 12:55:19'),
('0202002/001/10', '2011-03-05', 'ተጋዳላይ', '0202', '4461.00', '4100.00', '00102', '2', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '012', 'ማእኸላይ ኣመራርሓ', '1', 1, 1, 1, '2018-11-14 20:04:08', '2018-11-14 20:04:08'),
('0101001/006/11', '2011-03-05', 'ሲቪል', '0101', '10000.00', '7000.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '0003', 'ታሕተዋይ ኣመራርሓ', '1', 1, 1, 1, '2018-11-14 20:11:04', '2018-11-14 20:11:04'),
('0101001/007/11', '2011-03-05', 'ሲቪል', '0101', '10000.00', '7800.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '001', 'ጀማሪ ኣመራርሓ', '1', 1, 1, 1, '2018-11-14 20:14:29', '2018-11-14 20:14:29'),
('020304/001/11', '2011-04-05', 'ሲቪል', '0101', '3425.00', '3165.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '324/11', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:22:48', '2018-11-15 17:18:22'),
('0101001/003/11', '2011-03-03', 'ተጋዳላይ', '0101', '4829.00', '3001.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '004', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-14 20:26:08', '2018-11-14 20:26:08'),
('0101001/012/11', '2010-08-22', 'ሲቪል', '0101', '5000.00', '4500.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '002', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:28:50', '2018-11-14 20:28:50'),
('0101001/014/11', '2011-03-05', 'ሲቪል', '0101', '10000.00', '7222.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '12565', 'ተራ ኣባል', '1', 1, 1, 0, '2018-11-14 20:47:28', '2018-11-14 20:47:28'),
('0101001/016/11', '2011-03-03', 'ሲቪል', '0101', '5000.00', '4550.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '01', 'ተራ ኣባል', '1', 0, 0, 1, '2018-11-14 20:51:06', '2018-11-14 20:51:06'),
('0101001/017/11', '2011-03-05', 'ሲቪል', '0101', '5000.00', '4000.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '324/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:53:30', '2018-11-14 20:53:30'),
('050607/001/11', '2011-03-05', 'ሲቪል', '0506', '9000.00', '6500.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '313/515', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:54:23', '2018-11-14 20:54:23'),
('0101001/018/11', '2011-03-05', 'ሲቪል', '0101', '5000.00', '4300.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '324/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:54:27', '2018-11-14 20:54:27'),
('050608/005/11', '2011-03-02', 'ሲቪል', '0506', '5000.00', '4500.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '02222', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:54:59', '2018-11-14 20:54:59'),
('050608/001/11', '2011-03-05', 'ሲቪል', '0506', '4563.00', '3245.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '12/36', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:56:19', '2018-11-14 20:56:19'),
('0101001/015/11', '2011-03-03', 'ሲቪል', '0101', '5000.00', '4500.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '002/54/011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:56:25', '2018-11-14 20:56:25'),
('020303/001/11', '2011-03-05', 'ተጋዳላይ', '0203', '5000.00', '4300.00', '0012', '3', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '324/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:56:32', '2018-11-14 20:56:32'),
('0101001/013/11', '2011-03-04', 'ተጋዳላይ', '0101', '10000.00', '9000.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '02', 'ተራ ኣባል', '1', 1, 0, 1, '2018-11-14 20:57:35', '2018-11-14 20:57:35'),
('020304/002/11', '2011-03-05', 'ሲቪል', '0203', '4629.00', '4300.00', '0112', '4', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '022', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 20:59:12', '2018-11-14 20:59:12'),
('0101001/011/11', '2011-03-21', 'ሲቪል', '0101', '8950.00', '7800.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '0009', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:02:02', '2018-11-14 21:02:02'),
('050607/004/11', '2011-02-02', 'ሲቪል', '0506', '3000.00', '2500.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '1333', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:06:10', '2018-11-14 21:06:10'),
('0101001/020/11', '1982-02-21', 'ተጋዳላይ', '0101', '4200.00', '4100.00', '00101', '1', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '005', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:09:18', '2018-11-14 21:09:18'),
('050608/002/11', '2011-03-29', 'ሲቪል', '0506', '4461.00', '4160.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '8889/2', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:09:55', '2018-11-14 21:09:55'),
('0101001/022/11', '2011-03-05', 'ተጋዳላይ', '0101', '5304.00', '4800.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '035', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-14 21:10:48', '2018-11-14 21:10:48'),
('0101001/019/11', '2011-03-05', 'ሲቪል', '0101', '2197.00', '1800.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '12/7/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:11:31', '2018-11-14 21:11:31'),
('050608/006/11', '2011-03-03', 'ሲቪል', '0506', '2514.00', '2128.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '0012', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:12:06', '2018-11-14 21:12:06'),
('050608/008/11', '2011-10-15', 'ሲቪል', '0506', '2298.00', '2137.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '05/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:13:01', '2018-11-14 21:13:01'),
('050607/006/11', '2011-03-05', 'ተጋዳላይ', '0506', '6000.00', '4560.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '00215', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:13:03', '2018-11-14 21:13:03'),
('0202002/004/11', '2011-04-05', 'ተጋዳላይ', '0202', '8888.00', '7585.00', '00102', '2', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '001', 'ሰብ ሞያ', '1', 0, 0, 0, '2018-11-14 21:13:32', '2018-11-14 21:13:32'),
('0101001/008/11', '1972-04-23', 'ሲቪል', '0101', '52009.00', '4675.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '2323', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:16:20', '2018-11-14 21:16:20'),
('020303/003/11', '2011-03-03', 'ተጋዳላይ', '0203', '3100.00', '2300.00', '0012', '3', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '2112', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:16:32', '2018-11-14 21:16:32'),
('050607/008/11', '1996-01-02', 'ተጋዳላይ', '0506', '4878.00', '4037.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '09', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:16:37', '2018-11-14 21:16:37'),
('0101001/010/11', '2011-03-05', 'ሲቪል', '0101', '4321.00', '3211.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '2132', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:16:40', '2018-11-14 21:16:40'),
('020303/005/11', '2011-03-12', 'ተጋዳላይ', '0203', '3425.00', '3185.00', '0012', '3', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '001', 'ሰብ ሞያ', 'ዝተሰናበተ', 0, 0, 0, '2018-11-14 21:17:13', '2018-11-15 16:43:13'),
('050608/003/11', '2011-03-05', 'ተጋዳላይ', '0506', '5000.00', '4300.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '454/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:17:41', '2018-11-14 21:17:41'),
('0202002/005/11', '2009-02-05', 'ሲቪል', '0202', '2298.00', '2100.00', '00102', '2', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '006', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:19:32', '2018-11-14 21:19:32'),
('050607/009/11', '2011-03-03', 'ሲቪል', '0506', '3001.00', '2541.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '008', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:23:09', '2018-11-14 21:23:09'),
('050607/005/11', '2011-03-12', 'ሲቪል', '0506', '2900.00', '2530.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '001', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:26:49', '2018-11-14 21:26:49'),
('050607/002/11', '2011-03-05', 'ሲቪል', '0101', '5000.00', '4300.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '233/2011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:27:22', '2018-11-15 16:19:51'),
('0101001/021/11', '2011-03-20', 'ሲቪል', '0506', '5678.00', '4978.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '004', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-14 21:29:24', '2018-11-15 16:15:39'),
('050607/010/11', '2011-03-05', 'ሲቪል', '0506', '18000.00', '1200.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '0012', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-14 21:32:11', '2018-11-14 21:32:11'),
('050608/009/11', '2011-03-04', 'ሲቪል', '0506', '2514.00', '2008.00', '0013', '5', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '01011', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 16:18:37', '2018-11-15 16:18:37'),
('0101001/024/11', '2011-03-02', 'ሲቪል', '0202', '2000.00', '1800.00', '00102', '2', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '333/2', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-15 16:22:44', '2018-11-15 17:21:59'),
('020304/003/11', '2011-03-06', 'ሲቪል', '0101', '5000.00', '4400.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '2353/4', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 16:23:15', '2018-11-15 16:51:36'),
('050608/010/11', '2011-03-06', 'ተጋዳላይ', '0506', '5000.00', '4300.00', '0013', '5', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '3242/324', 'ተራ ኣባል', '1', 0, 0, 0, '2018-11-15 16:25:59', '2018-11-15 16:25:59'),
('020303/004/11', '2009-04-02', 'ተጋዳላይ', '0203', '4556.00', '4025.00', '0012', '3', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '009', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 16:31:00', '2018-11-15 16:31:00'),
('0101001/026/11', '2011-03-06', 'ሲቪል', '0101', '5665.00', '5100.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '213/226', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 16:39:37', '2018-11-15 16:39:37'),
('0101001/028/11', '2011-03-02', 'ሲቪል', '0101', '0.00', '0.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '444/1', 'ተራ ኣባል', 'ዝተባረረ', 1, 1, 1, '2018-11-15 17:06:22', '2018-11-15 20:42:25'),
('0101001/030/11', '2010-03-02', 'ሲቪል', '0101', '4444.00', '3560.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '001', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-15 17:12:44', '2018-11-15 17:12:44'),
('0101001/027/11', '2011-03-11', 'ሲቪል', '0101', '4578.00', '4233.00', '00101', '1', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '007', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-15 17:19:27', '2018-11-15 17:19:27'),
('0101001/005/11', '2011-03-06', 'ሲቪል', '0101', '4804.00', '3764.00', '00101', '1', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '000124', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 19:38:15', '2018-11-15 19:38:15'),
('0101001/033/11', '2011-03-01', 'ተጋዳላይ', '0101', '4461.00', '4000.00', '00101', '1', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '01', 'ተራ ኣባል', '1', 1, 1, 1, '2018-11-15 20:37:05', '2018-11-15 20:37:05'),
('0202002/003/11', '2011-03-07', 'ሲቪል', '0202', '5765.00', '5100.00', '00102', '2', 'ደቂ ኣንስትዮ', 'ተራ ኣባል', 'ተራ ኣባል', '213/226', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 20:41:00', '2018-11-15 20:41:00'),
('0101001/034/11', '2011-03-05', 'ሲቪል', '0101', '4000.00', '2000.00', '00101', '1', 'መናእሰይ', 'ተራ ኣባል', 'ተራ ኣባል', '01111', 'ሰብ ሞያ', '1', 1, 1, 1, '2018-11-15 20:49:22', '2018-11-15 20:49:22');

-- --------------------------------------------------------

--
-- Table structure for table `career_informations`
--

DROP TABLE IF EXISTS `career_informations`;
CREATE TABLE IF NOT EXISTS `career_informations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exprienceType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `career` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `institute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `career_informations_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `career_informations`
--

INSERT INTO `career_informations` (`id`, `hitsuyID`, `exprienceType`, `career`, `position`, `institute`, `address`, `startDate`, `endDate`, `created_at`, `updated_at`) VALUES
(7, '050607/004/11', 'ሞያዊ', 'prsenel', 'ኤክስፐርት', 'tplf', 'adwa', '2011-03-06', NULL, '2018-11-15 16:49:51', '2018-12-02 16:14:35'),
(4, '0101001/024/11', 'ፖለቲካዊ', 'mgt', 'manager', 'ዓዲግራት ፖሊ', 'ዓዲግራት', '2011-03-06', NULL, '2018-11-15 16:37:42', '2018-11-15 16:59:30'),
(14, '0202002/001/10', 'ሞያዊ', 'finance', 'chsher', 'tplf', 'korm', '2011-05-01', NULL, '2018-11-15 17:25:48', '2018-11-15 17:25:48'),
(9, '0202002/002/10', 'ሞያዊ', 'law', 'moya', 'manifakcherig', 'rama', '2010-03-04', NULL, '2018-11-15 16:52:09', '2018-11-15 16:52:09'),
(10, '020304/001/11', 'ፖለቲካዊ', '3', 'persnal', 'phaynanS', 'maychw', '2011-03-06', NULL, '2018-11-15 16:57:47', '2018-11-15 16:57:47'),
(11, '020304/001/11', 'ሞያዊ', '3', 'mthbbri', 'faynnes', 'almat', '1972-04-09', NULL, '2018-11-15 16:57:57', '2018-11-15 16:57:57'),
(12, '020304/001/11', 'ሞያዊ', 'ኪአላ', 'ፐርሰናል', 'ትምህርቲ', '0914205363', '2011-12-01', NULL, '2018-11-15 17:02:55', '2018-11-15 17:14:40'),
(15, '0101001/007/11', 'ሞያዊ', 'ምሁር', 'personel', 'tplf', 'mekelle', '2011-03-06', NULL, '2018-11-15 19:35:45', '2018-11-15 19:35:45');

-- --------------------------------------------------------

--
-- Table structure for table `core_degeftis`
--

DROP TABLE IF EXISTS `core_degeftis`;
CREATE TABLE IF NOT EXISTS `core_degeftis` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gfname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthPlace` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `occupation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `coreDegafiregDate` date NOT NULL,
  `proposerMem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `degaficonfirmedWidabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedWidabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `participatedCommittee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `degafiparticipationinCommittee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tell` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `poBox` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `bosSubmittedTsebtsab` tinyint(1) NOT NULL,
  `widabeacceptedDegafi` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `core_degeftis`
--

INSERT INTO `core_degeftis` (`id`, `name`, `fname`, `gfname`, `gender`, `birthPlace`, `dob`, `position`, `occupation`, `coreDegafiregDate`, `proposerMem`, `degaficonfirmedWidabe`, `assignedWidabe`, `participatedCommittee`, `degafiparticipationinCommittee`, `address`, `tell`, `poBox`, `fileNumber`, `email`, `bosSubmittedTsebtsab`, `widabeacceptedDegafi`, `created_at`, `updated_at`) VALUES
(1, 'ንግስቲ', 'ንጋቱ', 'ኣለሙ', 'ተባ', 'ኣላማጣ', '1980-01-01', 'ዲግሪን ሊዕሊኡን', 'ፀሓፊት', '2006-02-02', 'ዮርዳኖስ', 'ኣለሙ', 'ኣሞራ', 'ናይ ኣመራርሓ ኮሚቴ', 'ኣቦ ወንበር', 'ኩሓ', '0931489012', '2304', '02/2011', 'nIGSTI@GMILE.com', 1, 1, '2018-11-15 16:31:20', '2018-11-15 16:31:20'),
(2, 'abeba', 'slomon', 'berhe', 'ኣን', 'mekel', '2001-03-02', 'ዲግሪን ሊዕሊኡን', 'ngaday', '2011-03-06', 'haben', 'abe', 'mekel', 'ሓገዝን ንኡስ ፋይናንስን ንኡስ ኮሚቴ', 'ኣባል', 'hadent', '0344421055', '002', '0001', 'habengebre21@gmail.com', 1, 1, '2018-11-15 16:32:09', '2018-11-15 16:32:09'),
(3, 'haylu', 'desta', 'belay', 'ተባ', 'samre', '1997-03-03', 'ዲፕሎማ', 'ngaday', '2001-01-01', 'abadit', 'haben', 'negado', 'ውዳበ ንኡስ ኮሚቴ', 'ኣባል', 'hadent', '0914200036', '002', '022', 'habengebre21@gmail.com', 1, 1, '2018-11-15 16:37:26', '2018-11-15 16:37:26'),
(4, 'brhane', 'berhe', 'abay', 'ተባ', 'axum', '1999-03-05', 'ዲግሪን ሊዕሊኡን', 'bb', '2011-03-11', 'hagos', 'vvvv', 'hfydtdd', 'ውዳበ ንኡስ ኮሚቴ', 'ፀሓፊ', 'axum', '0925448961', '025441', '00115', 'brhaneberhe@gmail.com', 1, 1, '2018-11-15 16:58:48', '2018-11-15 16:58:48'),
(5, 'dfghfh', 'gdgffg', 'ghfjhn', 'ተባ', 'gfhjgjg', '1981-03-14', 'ዲፕሎማ', 'degree', '2011-03-02', 'mercy', 'asfghg', 'as', 'ውዳበ ንኡስ ኮሚቴ', 'ኣቦ ወንበር', 'adigrat', '0914241414', '321', '0001', 'hmercy05@gmail.com', 0, 0, '2018-11-15 21:19:08', '2018-11-15 21:19:08');

-- --------------------------------------------------------

--
-- Table structure for table `data1s`
--

DROP TABLE IF EXISTS `data1s`;
CREATE TABLE IF NOT EXISTS `data1s` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `salary` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `dismisses`
--

DROP TABLE IF EXISTS `dismisses`;
CREATE TABLE IF NOT EXISTS `dismisses` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dismissReason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `detailReason` text COLLATE utf8_unicode_ci NOT NULL,
  `proposedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approvedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dismissDate` date NOT NULL,
  `isReported` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dismisses_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `dismisses`
--

INSERT INTO `dismisses` (`id`, `hitsuyID`, `dismissReason`, `detailReason`, `proposedBy`, `approvedBy`, `dismissDate`, `isReported`, `isApproved`, `created_at`, `updated_at`) VALUES
(3, '020303/005/11', 'ናይ ውልቀ ሰብ ሕቶ', 'alksdjfalsdjf', '', 'Joh', '2011-03-06', 0, 0, '2018-11-15 16:43:13', '2018-11-27 13:31:43');

-- --------------------------------------------------------

--
-- Table structure for table `donors`
--

DROP TABLE IF EXISTS `donors`;
CREATE TABLE IF NOT EXISTS `donors` (
  `donorId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donorType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donorName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `occupationArea` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`donorId`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `donors`
--

INSERT INTO `donors` (`donorId`, `donorType`, `donorName`, `occupationArea`, `address`, `created_at`, `updated_at`) VALUES
('donor/0001/11', 'ካሊእ', 'ገብረ ገብሩ', 'ኢንቨስትመት', 'መቐለ', '2018-11-25 13:46:57', '2018-11-25 13:47:23');

-- --------------------------------------------------------

--
-- Table structure for table `educations`
--

DROP TABLE IF EXISTS `educations`;
CREATE TABLE IF NOT EXISTS `educations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `educationType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `educationLevel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `institute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `graduationDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `educations_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `education_informations`
--

DROP TABLE IF EXISTS `education_informations`;
CREATE TABLE IF NOT EXISTS `education_informations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `educationType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `educationLevel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `institute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `graduationDate` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `education_informations_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=78 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `education_informations`
--

INSERT INTO `education_informations` (`id`, `hitsuyID`, `educationType`, `educationLevel`, `institute`, `graduationDate`, `created_at`, `updated_at`) VALUES
(8, '0202002/002/10', 'CS', 'knistr', 'mu', '2010', '2018-11-15 16:16:22', '2018-12-02 16:07:23'),
(11, '0101001/014/11', 'ጅኦግራፊ', 'degree', 'kaLfornya unversty', '2011', '2018-11-15 16:27:57', '2018-11-15 19:35:17'),
(10, '0101001/001/10', 'ማናጅመንት', 'degiri', 'ሚኒልየም', '2011', '2018-11-15 16:23:03', '2018-11-15 19:35:55'),
(12, '0101001/024/11', 'm.t', 'ድግሪ', 'ዓዲግራት ፖሊ', '2010', '2018-11-15 16:28:47', '2018-11-15 16:52:35'),
(14, '0101001/001/10', 'ict', 'መማሰተር', 'mit', '2011', '2018-11-15 16:31:09', '2018-11-15 17:19:06'),
(15, '020304/003/11', 'Management ', 'Master', 'Sheba university ', '2009', '2018-11-15 16:31:47', '2018-11-15 16:38:02'),
(29, '0202002/002/10', 'QS', 'dger', 'uiversty', '2008', '2018-11-15 16:44:34', '2018-12-02 16:09:24'),
(16, '0202002/002/10', 'ኣይቲ', 'dgree', 'axum universtiy', '2004', '2018-11-15 16:41:20', '2018-12-02 16:10:18'),
(17, '0202002/002/10', 'ICT', 'deploma', 'MU', '2009', '2018-11-15 16:41:22', '2018-11-15 16:41:22'),
(18, '0202002/002/10', 'ICT', 'deploma', 'MU', '2009', '2018-11-15 16:41:23', '2018-11-15 16:41:23'),
(19, '0202002/002/10', 'it', 'dgree', 'axum universtiy', '2004', '2018-11-15 16:41:35', '2018-11-15 16:41:35'),
(20, '0202002/002/10', 'it', 'dgree', 'axum universtiy', '2004', '2018-11-15 16:41:37', '2018-11-15 16:41:37'),
(21, '0202002/002/10', 'accounting', 'diploma', 'MLC', '2010', '2018-11-15 16:42:03', '2018-11-15 16:42:03'),
(22, '0202002/002/10', 'computer', 'degree', 'mit', '2005', '2018-11-15 16:42:12', '2018-11-15 16:42:12'),
(23, '0202002/002/10', 'IS', 'dger', 'uiversty', '2008', '2018-11-15 16:42:20', '2018-11-15 16:42:20'),
(24, '0202002/002/10', 'accounting', 'diploma', 'MLC', '2010', '2018-11-15 16:42:21', '2018-11-15 16:42:21'),
(25, '0202002/002/10', 'computer', 'degree', 'mit', '2005', '2018-11-15 16:42:26', '2018-11-15 16:42:26'),
(26, '0202002/002/10', 'managment', 'digri', 'mekelle', '2011', '2018-11-15 16:42:57', '2018-11-15 16:42:57'),
(27, '0202002/001/10', 'cs', 'degree', 'mu', '2011', '2018-11-15 16:43:04', '2018-11-15 16:43:04'),
(28, '0202002/002/10', 'managment', 'digri', 'mekelle', '2011', '2018-11-15 16:43:08', '2018-11-15 16:43:08'),
(49, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:52:40', '2018-11-15 16:52:40'),
(30, '0202002/002/10', 'መናጅመንት', 'ዲግሪ', 'መቀለ ዩኒቨርስቲ', '2010', '2018-11-15 16:44:58', '2018-11-15 16:44:58'),
(31, '0101001/001/10', 'managment', 'digri', 'mekelle', '2011', '2018-11-15 16:45:24', '2018-11-15 16:45:24'),
(32, '0202002/002/10', 'law', 'digri', 'admas ', '2005', '2018-11-15 16:45:27', '2018-11-15 16:45:27'),
(33, '0101001/001/10', 'software e', 'Msc', 'MLC', '2010', '2018-11-15 16:45:56', '2018-11-15 16:45:56'),
(34, '0202002/002/10', 'managment', 'diploma', 'axum tvet', '1998', '2018-11-15 16:46:14', '2018-11-15 16:46:14'),
(36, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:12', '2018-11-15 16:47:12'),
(37, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:19', '2018-11-15 16:47:19'),
(38, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:20', '2018-11-15 16:47:20'),
(39, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:33', '2018-11-15 16:47:33'),
(40, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:34', '2018-11-15 16:47:34'),
(41, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:34', '2018-11-15 16:47:34'),
(42, '0202002/002/10', 'ኣይቲ', 'ዲፕሎማ', 'ሚሊንየም', '2011', '2018-11-15 16:47:34', '2018-11-15 16:47:34'),
(43, '0202002/002/10', 'manajment', 'dgri', 'shba', '2006', '2018-11-15 16:47:36', '2018-11-15 16:47:36'),
(44, '0202002/002/10', 'Accounting', 'msc', 'sheba', '2009', '2018-11-15 16:47:50', '2018-11-15 16:47:50'),
(45, '0202002/002/10', 'IS', 'deger', 'MU', '2008', '2018-11-15 16:49:12', '2018-11-15 16:49:12'),
(46, '0202002/002/10', 'ኢኮኖሚክስ', 'ማስተር', 'መቀለ ዩንቨርስቲ', '2010', '2018-11-15 16:51:14', '2018-11-15 16:51:14'),
(47, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:51:59', '2018-11-15 16:51:59'),
(48, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:52:12', '2018-11-15 16:52:12'),
(50, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:52:49', '2018-11-15 16:52:49'),
(51, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:52:50', '2018-11-15 16:52:50'),
(52, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:53:01', '2018-11-15 16:53:01'),
(53, '020304/001/11', 'mangmt', 'digre', 'niwmlinm', '2006', '2018-11-15 16:53:19', '2018-11-15 16:53:19'),
(59, '0202002/002/10', 'computer', 'degree', 'hadush', '2005', '2018-11-15 17:06:04', '2018-11-15 17:06:04'),
(54, '0202002/002/10', 'bb', 'msc', 'mlc', '2006', '2018-11-15 16:57:53', '2018-11-15 16:57:53'),
(57, '0202002/002/10', 'mgt', 'msc', 'aa', '2010', '2018-11-15 17:01:09', '2018-11-15 17:01:09'),
(60, '0202002/004/11', 'computer', 'phd', 'mit', '2007', '2018-11-15 17:07:49', '2018-11-15 17:10:52'),
(61, '0202002/002/10', 'mgt', 'phd', 'adigrat unve', '2010', '2018-11-15 17:08:57', '2018-11-15 17:08:57'),
(62, '0101001/030/11', 'm.m', 'degree', 'mu', '2004', '2018-11-15 17:15:39', '2018-11-15 17:15:39'),
(63, '0101001/030/11', 'm.m', 'degree', 'mu', '2004', '2018-11-15 17:15:40', '2018-11-15 17:15:40'),
(64, '0101001/030/11', 'm.m', 'degree', 'mu', '2004', '2018-11-15 17:15:46', '2018-11-15 17:15:46'),
(76, '0101001/014/11', 'maths', 'ms', 'meklle', '2010', '2018-11-15 19:47:54', '2018-11-15 19:47:54'),
(65, '0101001/006/11', 'ኣካዉንቲግ', 'ዲግሪ', 'ሸባ', '2005', '2018-11-15 17:18:06', '2018-11-15 17:18:06'),
(66, '0202002/001/10', 'accounting', 'deploma', 'mekelle', '2010', '2018-11-15 17:22:34', '2018-11-15 17:22:34'),
(67, '0101001/014/11', 'history', 'dgree', 'welketa university', '2001', '2018-11-15 19:35:31', '2018-11-15 19:35:31'),
(68, '0101001/014/11', 'maths', 'ms', 'meklle', '2010', '2018-11-15 19:40:26', '2018-11-15 19:40:26'),
(69, '0101001/014/11', 'maths', 'ms', 'meklle', '2010', '2018-11-15 19:40:26', '2018-11-15 19:40:26'),
(70, '0101001/014/11', 'ጂኦጘራፊ', 'phd', 'ካሊፎርንያ ዩንቨርስቲ', '2011', '2018-11-15 19:40:36', '2018-11-15 19:40:36'),
(71, '0101001/014/11', 'ጂኦጘራፊ', 'phd', 'ካሊፎርንያ ዩንቨርስቲ', '2011', '2018-11-15 19:40:38', '2018-11-15 19:40:38'),
(72, '0101001/014/11', 'ጂኦጘራፊ', 'phd', 'ካሊፎርንያ ዩንቨርስቲ', '2011', '2018-11-15 19:40:39', '2018-11-15 19:40:39'),
(73, '0101001/014/11', 'maths', 'ms', 'meklle', '2010', '2018-11-15 19:41:08', '2018-11-15 19:41:08'),
(74, '0101001/014/11', 'maths', 'ms', 'meklle', '2010', '2018-11-15 19:41:08', '2018-11-15 19:41:08'),
(75, '0101001/014/11', 'maths', 'ms', 'meklle', '2010', '2018-11-15 19:41:28', '2018-11-15 19:41:28');

-- --------------------------------------------------------

--
-- Table structure for table `experts`
--

DROP TABLE IF EXISTS `experts`;
CREATE TABLE IF NOT EXISTS `experts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer5` text COLLATE utf8_unicode_ci NOT NULL,
  `answer6` text COLLATE utf8_unicode_ci NOT NULL,
  `answer7` text COLLATE utf8_unicode_ci NOT NULL,
  `answer8` text COLLATE utf8_unicode_ci NOT NULL,
  `answer9` text COLLATE utf8_unicode_ci NOT NULL,
  `answer10` text COLLATE utf8_unicode_ci NOT NULL,
  `result1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `experts_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `experts`
--

INSERT INTO `experts` (`id`, `hitsuyID`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `answer7`, `answer8`, `answer9`, `answer10`, `result1`, `result2`, `result3`, `result4`, `result5`, `result6`, `result7`, `result8`, `remark`, `created_at`, `updated_at`) VALUES
(6, '0101001/005/11', 'fjsd,hvkjfh.lg', 'fghsdhgsohgoij', 'jhiogjreigjepoj', 'hhiojokopk', 'gfjhgohgoooooooooooooooo', 'jljkjlkjlkjl', 'kjjj;ofkop', 'kji54pjpj', 'dvjfguerhgjpg;er lnrihji', 'hgfiuehrgeoig  rghoehgeojpo', '10', '9', '8', '9', '3', '5', '4', '8', 'fhihhiurhgiero jkorgnghio5', '2018-11-15 20:58:59', '2018-11-15 20:58:59'),
(9, '0101001/020/11', 'fhgkdgfhfiw rgjlngjlgjnjpo;e iugpej g;egepgup ltp', 'gfuggig', 'tututuik', 'hgghukh', 'gkghoergioeugpo', 'fyitiuyi', 'wrgttdhry', 'rgrth', 'gfwfguhfo', 'jrhkgjehhi', '6', '2', '7', '4', '5', '2', '6', '12', 'fgguih', '2018-11-15 21:02:17', '2018-11-15 21:02:17'),
(10, '020304/001/11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2018-11-29 14:49:39', '2018-11-29 14:49:39');

-- --------------------------------------------------------

--
-- Table structure for table `first_instant_leaders`
--

DROP TABLE IF EXISTS `first_instant_leaders`;
CREATE TABLE IF NOT EXISTS `first_instant_leaders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer5` text COLLATE utf8_unicode_ci NOT NULL,
  `answer6` text COLLATE utf8_unicode_ci NOT NULL,
  `answer7` text COLLATE utf8_unicode_ci NOT NULL,
  `answer8` text COLLATE utf8_unicode_ci NOT NULL,
  `answer9` text COLLATE utf8_unicode_ci NOT NULL,
  `answer10` text COLLATE utf8_unicode_ci NOT NULL,
  `answer11` text COLLATE utf8_unicode_ci NOT NULL,
  `answer12` text COLLATE utf8_unicode_ci NOT NULL,
  `result1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result10` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `first_instant_leaders_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `first_instant_leaders`
--

INSERT INTO `first_instant_leaders` (`id`, `hitsuyID`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `answer7`, `answer8`, `answer9`, `answer10`, `answer11`, `answer12`, `result1`, `result2`, `result3`, `result4`, `result5`, `result6`, `result7`, `result8`, `result9`, `result10`, `remark`, `created_at`, `updated_at`) VALUES
(1, '0101001/007/11', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2018-11-29 14:35:35', '2018-11-29 14:35:35');

-- --------------------------------------------------------

--
-- Table structure for table `gifts`
--

DROP TABLE IF EXISTS `gifts`;
CREATE TABLE IF NOT EXISTS `gifts` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `donorId` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `giftType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `giftName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `valuation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `donationDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `gifts_donorid_foreign` (`donorId`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `gifts`
--

INSERT INTO `gifts` (`id`, `donorId`, `giftType`, `purpose`, `giftName`, `valuation`, `status`, `donationDate`, `created_at`, `updated_at`) VALUES
(1, 'donor/0001/11', 'ተሽከርከርቲ', 'sdfl;s', 'f;dslk', '234234', 'ዝተወሃበ', '2011-03-07', '2018-11-16 12:00:23', '2018-11-25 13:42:09');

-- --------------------------------------------------------

--
-- Table structure for table `hitsuys`
--

DROP TABLE IF EXISTS `hitsuys`;
CREATE TABLE IF NOT EXISTS `hitsuys` (
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gfname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `gender` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birthPlace` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dob` date NOT NULL,
  `occupation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sme` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `regDate` date NOT NULL,
  `proposerWidabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proposerWahio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proposerMem` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `fileNumber` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `region` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tabiaID` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tell` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isRequested` tinyint(1) NOT NULL,
  `hasPermission` tinyint(1) NOT NULL,
  `isWilling` tinyint(1) NOT NULL,
  `isReportedWahioHalafi` tinyint(1) NOT NULL,
  `isReportedWahioMem` tinyint(1) NOT NULL,
  `hitsuy_status` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'ሕፁይ',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `hitsuys`
--

INSERT INTO `hitsuys` (`hitsuyID`, `name`, `fname`, `gfname`, `gender`, `birthPlace`, `dob`, `occupation`, `position`, `sme`, `regDate`, `proposerWidabe`, `proposerWahio`, `proposerMem`, `fileNumber`, `region`, `tabiaID`, `address`, `tell`, `email`, `isRequested`, `hasPermission`, `isWilling`, `isReportedWahioHalafi`, `isReportedWahioMem`, `hitsuy_status`, `created_at`, `updated_at`) VALUES
('0202002/002/10', 'መሰረት', 'ኣለም', 'ፍስሃ', 'ኣን', 'ተምቤን', '1990-10-22', 'ገባር', 'ሰራሕተኛ', '', '2010-01-10', '00102', '2', 'በሪሁ', '12245/09', 'ትግራይ', '002', '', '0913103291', 'temsm@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2017-11-09 04:54:40', '2018-11-11 14:26:40'),
('0202002/001/10', 'ሳራ', 'ገዛኢ', 'ኣረጋዊ', 'ኣን', 'ተምቤን', '1990-10-22', 'መምህር', 'ሰራሕተኛ', '', '2010-01-10', '00102', '2', 'በሪሁ', '12245/09', 'ትግራይ', '002', '', '0912103291', 'temsm@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2017-11-09 04:53:30', '2018-11-14 20:04:08'),
('0101001/002/10', 'ሃና', 'ኣለም', 'በርሀ', 'ተባ', 'መቐለ', '1993-10-22', 'ተምሃራይ', 'ሰራሕተኛ', '', '2010-01-12', '00101', '1', 'በሪሁ', '1455/09', 'ትግራይ', '001', '', '0913103291', 'tems@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2017-11-09 04:51:59', '2018-11-14 20:06:57'),
('0101001/001/10', 'ተመስገን', 'ሓጎስ', 'በርሀ', 'ተባ', 'መቐለ', '1990-10-22', 'ምሁር', 'ሰራሕተኛ', '', '2009-10-12', '00101', '1', 'በሪሁ', '1222/09', 'ትግራይ', '001', '', '0913103291', 'tewdrosw@tplf.com', 1, 1, 1, 1, 1, 'ኣባል', '2017-11-09 04:50:48', '2018-10-31 12:55:19'),
('0101001/003/11', 'ከበደ', 'ኣበበ', 'በለው', 'ተባ', 'መቐለ', '1988-03-05', 'ነጋዲይ', 'ኣመሓዳሪ', NULL, '2018-01-02', '00101', '1', 'ሰመረ ገብረ', '12245/09', 'ትግራይ', '001', '', '0914000000', 'a@b.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-10-14 07:46:24', '2018-11-14 20:26:08'),
('0101001/004/11', 'ንግስቲ', 'ፀሃየ', 'ግደይ', 'ኣን', 'መቐለ', '1978-02-02', 'ገባር', 'ሓረስታይ', NULL, '2011-02-02', '00101', '1', 'ሰላም', '02/2011', 'ትግራይ', '001', '', '0931489012', 'nIGSTI@GMILE.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 19:58:56', '2018-11-14 20:43:19'),
('050608/001/11', 'ዮርዳ', 'ግደይ', 'ኣባይ', 'ኣን', 'ዓድዋ', '1978-02-02', 'ምሁር', 'ፀሓፊት', NULL, '2011-03-02', '0013', '5', 'ንግስቲ', '03/2011', 'ትግራይ', '08', '', '0938161338', 'yordanos.tsehaye@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:01:35', '2018-11-15 20:11:39'),
('0101001/005/11', 'ምሒራ', 'ገብሩ', 'ኣፅብሃ', 'ኣን', 'መቐለ', '1978-02-02', 'ምሁር', 'ካሸር', NULL, '2010-10-03', '00101', '1', 'ዮርዳ', '04/2011', 'ትግራይ', '001', '', '0938161338', 'nIGSTI@GMILE.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:05:22', '2018-11-15 19:38:15'),
('0101001/006/11', 'abebe', 'beso', 'bela', 'ተባ', 'mekele', '1999-04-01', 'ገባር', 'wdabe', NULL, '2011-03-06', '00101', '1', 'snkey', '0001', 'ትግራይ', '001', '', '090909090', 'abebe@gmail.com', 1, 0, 0, 1, 0, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:06:32', '2018-11-14 20:17:12'),
('0101001/007/11', 'tesfay', 'gebru', 'abebe', 'ተባ', 'mekele', '1981-10-06', 'ምሁር', 'personel', NULL, '2011-03-05', '00101', '1', 'meaza', '001', 'ትግራይ', '001', '', '0344414745', 'tesfay@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:10:09', '2018-11-14 20:14:29'),
('0101001/008/11', 'ኣበበ', 'ታደሰ', 'ደስታ', 'ተባ', 'መቐለ', '1985-02-08', 'መምህር', 'ግልጋሎት', 'ጀማሪ', '2010-02-01', '00101', '1', 'ዉዳበ ሓላፊ', '02', 'ትግራይ', '001', '', '0938797379', 'Nigist.nigatu@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:15:12', '2018-11-14 21:16:20'),
('0101001/033/11', 'ደደደ', 'በበበ', 'ፈፈፈ', 'ተባ', 'መከ', '1981-03-01', 'ገባር', 'ደፈ', NULL, '1991-03-02', '00101', '1', 'በ', '01', 'ትግራይ', '001', '', '0914851098', 'teki12e@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-15 20:35:35', '2018-11-15 20:37:05'),
('0101001/009/11', 'GOITMOM', 'NGASI', 'SHIFRAW', 'ተባ', 'SHRARO', '2001-03-01', 'ምሁር', 'PPERSNL', NULL, '2011-03-03', '00101', '1', 'KIDAN', '0006', 'ትግራይ', '001', '', '09456565', 'hmercy05@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:17:20', '2018-11-14 21:37:41'),
('020304/001/11', 'hailu', 'degefa', 'tegen', 'ተባ', 'korem', '1986-12-12', 'ምሁር', 'personnel', NULL, '2011-04-05', '0112', '4', 'haftu moges', '324/11', 'ትግራይ', '04', '', '0931569386', 'hailu.degefa2123@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:19:51', '2018-11-14 20:22:48'),
('0101001/010/11', 'selam', 'berhe', 'sahle', 'ኣን', 'adwa', '1986-03-02', 'ምሁር', 'persenel', NULL, '2011-03-04', '00101', '1', 'sara', '2112', 'ትግራይ', '001', '', '0914522636', 'rahwa@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:20:52', '2018-11-14 21:16:56'),
('0202002/003/11', 'fantu', 'meresa', 'kiros', 'ኣን', 'maychw', '1970-01-01', 'ምሁር', 'memhr', NULL, '2011-03-02', '00102', '2', 'etensh', '232/20', 'ትግራይ', '002', '', '0914166616', 'fantaneshmeresa@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:21:29', '2018-11-15 20:41:00'),
('050608/002/11', 'ለታይ', 'መስፍን', 'ኣረጋዊ', 'ኣን', 'ዓዲግራት', '1986-09-05', 'ምሁር', 'ፐርሰንየል', NULL, '2011-03-05', '0013', '5', 'ሰላም', '0014', 'ትግራይ', '08', '', '0914522328', 'letaymesfin@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:22:36', '2018-11-14 21:09:55'),
('0101001/011/11', 'a', 'b', 'c', 'ተባ', 'adi', '2004-03-07', 'መምህር', 'abal', NULL, '2011-03-05', '00101', '1', 'abebe', '000114', 'ትግራይ', '001', '', '0914151920', 'hatekel@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:23:41', '2018-11-14 21:02:02'),
('0101001/012/11', 'desalegn', 'abebe', 'shayne', 'ተባ', 'samre', '1984-02-12', 'ምሁር', 'personel', NULL, '2010-08-22', '00101', '1', 'tesfay', '002', 'ትግራይ', '001', '', '0914002123', 'desalegn@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:26:11', '2018-11-14 20:28:50'),
('0101001/013/11', 'ሀሀ', 'ጀጀ', 'ለለ', 'ተባ', 'መከ', '2011-03-04', 'ገባር', 'ኢለላ', NULL, '2011-03-10', '00101', '1', 'በ', '0914851098', 'ትግራይ', '001', '', '09148510980914851098', 'teki12e@gmail.com', 0, 1, 0, 0, 0, 'ኣባል', '2018-11-14 20:26:37', '2018-11-14 20:57:35'),
('0101001/014/11', 'muse', 'seum', 'tsegay', 'ተባ', 'meklle', '1985-03-06', 'ደኣንት', 'wedab', 'ጀማሪ', '2011-03-06', '00101', '1', 'heneta', '04', 'ትግራይ', '001', '', '0101010103', 'muse@gmail.cosinkeym', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:27:34', '2018-11-14 20:47:28'),
('050608/003/11', 'brhane', 'aregawi', 'bahta', 'ተባ', 'weree', '1986-07-07', 'ምሁር', 'personal', NULL, '2011-04-04', '0013', '5', 'selam', '0021', 'ትግራይ', '08', '', '0936876005', 'brhaneare13@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:28:14', '2018-11-14 21:17:41'),
('0101001/015/11', 'solomon', 'hagose', 'semere', 'ተባ', 'rama', '1983-03-30', 'ምሁር', 'persneal', NULL, '2011-03-03', '00101', '1', 'kiros', '003/54/011', 'ትግራይ', '001', '', '0914241992', 'solomon@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:29:02', '2018-11-14 20:57:56'),
('050608/004/11', 'KIDANU', 'BERHE', 'GTACHW', 'ተባ', 'adwa', '2000-03-07', 'ሸቃላይ', 'gbar', NULL, '2015-03-07', '0013', ' 5', 'bahta', '0008', 'ትግራይ', '08', '', '0922343556', 'hsghghgfgh@gmial.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:43:40', '2018-11-14 21:16:25'),
('0101001/016/11', 'hh', 'll', 'mm', 'ተባ', 'mk', '1972-04-02', 'ገባር', 'p', NULL, '2011-03-03', '00101', '1', 'boss', '01', 'ትግራይ', '001', '', '0914851098', 'teki12e@gmail.com', 0, 1, 0, 0, 0, 'ኣባል', '2018-11-14 20:49:04', '2018-11-14 20:51:06'),
('050608/005/11', 'Selam', 'Desalegn', 'Meresa', 'ኣን', 'Aksum', '1985-10-13', 'ምሁር', 'Persenel', NULL, '2011-03-13', '0014', '6', 'Brhane', '02222', 'ትግራይ', '08', '', '0919547542', 'selamdesalegn@gmail.com', 1, 1, 1, 0, 0, 'ኣባል', '2018-11-14 20:49:08', '2018-11-14 20:54:59'),
('0101001/017/11', 'Semer', 'Hafetu', 'Berhe', 'ተባ', 'Adigreat', '1971-03-13', 'ምሁር', 'Amahadari', NULL, '2011-03-05', '00101', '1', 'Aberehet', '2323/2', 'ትግራይ', '001', '', '0914005231', 'addder@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:49:52', '2018-11-14 20:53:30'),
('020303/001/11', 'Semere', 'Haftu', 'Berhe', 'ተባ', 'Adigrat', '1992-04-13', 'ምሁር', 'ኣመሓዳሪ', NULL, '2011-01-05', '0012', '3', 'Gezae', '2323/2011', 'ትግራይ', '03', '', '0914000000', 'semere@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 20:50:08', '2018-11-14 20:58:36'),
('050607/001/11', 'le', 'be', 'gi', 'ኣን', 'erop', '1992-03-02', 'ምሁር', 'amehadari', NULL, '2011-03-12', '0013', '5', 'aregawi', '00', 'ትግራይ', '07', '', '091434466757', 'hmercy05@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:50:36', '2018-11-14 20:54:23'),
('0101001/018/11', 'semere', 'haftu', 'berhe', 'ተባ', 'Adigrat', '1980-04-13', 'ምሁር', 'ኣመሓዳሪ', NULL, '2011-01-05', '00101', '1', 'gezae', '2323/22', 'ትግራይ', '001', '', '0914693798', 'semerehaftu@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:51:24', '2018-11-14 20:54:27'),
('020304/002/11', 'haben', 'gebre', 'abrha', 'ተባ', 'samre', '1976-05-02', 'ምሁር', 'data', NULL, '2011-03-11', '0112', '4', 'free', '022', 'ትግራይ', '04', '', '0938148107', 'habengebre21@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:51:53', '2018-11-14 20:59:12'),
('0101001/019/11', 'ኪሮስ', 'ሓዱሽ', 'ሓጎስ', 'ተባ', 'ሓድነት', '2011-03-02', 'ምሁር', 'ውዳበ', NULL, '2011-03-09', '00101', '1', 'ሃና', '120/7/2011', 'ትግራይ', '001', '', '0914205630', 'saba@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:54:17', '2018-11-14 21:11:31'),
('020303/002/11', 'tsehaynsh', 'kahsay', 'welidgrma', 'ኣን', 'axum', '2001-03-02', 'ምሁር', 'amahdr', NULL, '2011-03-05', '0012', '3', 'selam', '1/22', 'ትግራይ', '03', '', '0914387311', 'tsehaynash@gaimii.com', 0, 0, 0, 0, 0, 'ሕፁይነት ተናዊሑ', '2018-11-14 20:54:25', '2018-11-14 21:15:44'),
('020303/003/11', 'tsehaynsh', 'kahsay', 'welidgrma', 'ኣን', 'axum', '2001-03-02', 'ምሁር', 'amahdr', NULL, '2011-03-05', '0012', '3', 'selam', '1/22', 'ትግራይ', '03', '', '0914387311', 'tsehaynash@gaimii.com', 0, 0, 0, 0, 0, 'ኣባል', '2018-11-14 20:54:27', '2018-11-14 21:16:32'),
('050608/006/11', 'brhane', 'berhe', 'abay', 'ተባ', 'axum', '1986-03-04', 'ምሁር', 'personel', NULL, '2011-03-03', '0014', '6', 'hagos', '02021', 'ትግራይ', '08', '', '0914577543', 'brhaneberhe@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:54:32', '2018-11-14 21:12:06'),
('020303/004/11', 'selam', 'kebede', 'abebe', 'ኣን', 'ofla', '1998-05-06', 'ምሁር', 'personl', NULL, '2009-04-02', '0012', '3', 'mola', '009', 'ትግራይ', '03', '', '0914523212', 'seam@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:59:06', '2018-11-15 16:31:00'),
('020303/005/11', 'ፋንታየ', 'ኣባዲ', 'ደስታ', 'ኣን', 'ኮረም', '1975-02-22', 'መምህር', 'መምህር', NULL, '2011-02-21', '0012', ' ', 'ዉዳበ', '005', 'ትግራይ', '03', '', '0914525351', 'Nigist.nigatu@gmail.com', 1, 1, 1, 1, 1, 'ዝተሰናበተ', '2018-11-14 20:59:12', '2018-11-15 16:43:13'),
('050607/002/11', 'ሰናይት', 'ግደይ', 'ኣፅብሃ', 'ተባ', 'ዓድዋ', '1988-02-03', 'ምሁር', 'ፀሓፊት', NULL, '2010-05-05', '0013', '5', 'ዮርዳኖስ', '06/2011', 'ትግራይ', '07', '', '0938161338', 'nIGSTI@GMILE.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 20:59:54', '2018-11-14 21:27:22'),
('050607/007/11', 'amare', 'kidu', 'tesfay', 'ተባ', 'adwa', '2001-03-01', 'ገባር', 'farmer', NULL, '2019-03-08', '0013', '5', 'hailu', '003', 'ትግራይ', '07', '', '0914173729', 'yohans@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-14 21:09:59', '2018-11-14 21:09:59'),
('050607/003/11', 'abraha', 'nega', 'hailay', 'ኣን', 'axum', '1980-03-05', 'ገባር', 'wahyo', NULL, '2011-03-05', '0013', '5', 'hagos', '02', 'ትግራይ', '07', '', '0937035575', 'gebre1315@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-14 21:02:10', '2018-11-14 21:02:10'),
('0101001/026/11', 'aregawi', 'gebru', 'desta', 'ተባ', 'hawziyn', '1982-11-03', 'ምሁር', 'persenal', NULL, '2011-03-06', '00101', '1', 'Gidey', '324/456', 'ትግራይ', '001', '', '0933097875', 'aregawigebru@gmail.com', 1, 1, 1, 1, 0, 'ኣባል', '2018-11-15 16:34:01', '2018-11-15 16:39:37'),
('050607/004/11', 'Feven', 'Hagos', 'Teklu', 'ኣን', 'Adwa', '1985-10-07', 'መምህር', 'Memhr', NULL, '2011-02-02', '0013', '5', 'Tekle', '1333', 'ትግራይ', '07', '', '0914543432', 'fevenhagos@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-14 21:04:37', '2018-11-14 21:20:25'),
('0101001/020/11', 'ስንቀይ', 'ግርማይ', 'ደስታ', 'ኣን', 'መቐለ', '1974-05-01', 'ምሁር', 'ፐርሰኔል', NULL, '1982-02-22', '00101', '1', 'ዉዳበ', '005', 'ትግራይ', '001', '', '0914525351', 'Nigist.nigatu@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:05:07', '2018-11-14 21:09:18'),
('050607/005/11', 'haben', 'berhe', 'abadi', 'ተባ', 'adwa', '1974-02-07', 'ምሁር', 'finance', NULL, '2011-03-18', '0013', '5', 'brhane', '000125', 'ትግራይ', '07', '', '09448961', 'habenberhe@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:05:16', '2018-11-14 21:26:49'),
('050607/006/11', 'welay', 'meresa', 'mkonen', 'ተባ', 'axum', '1989-03-02', 'ምሁር', 'prsenel', NULL, '2011-03-05', '0013', '5', 'wersa', '0215', 'ትግራይ', '07', '', '0914505005', 'mkljgf@gimail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:05:59', '2018-11-14 21:13:03'),
('0101001/021/11', 'ሓዳስ', 'ብርሃነ', 'ሓጎስ', 'ኣን', 'መሳኑ', '2011-03-04', 'ምሁር', 'ውዳበ', NULL, '2011-03-16', '00101', '1', 'ብርሃን', '120/7/2011', 'ትግራይ', '001', '', '0914563040', 'saba@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:06:16', '2018-11-14 21:29:24'),
('0202002/004/11', 'hailu', 'degefa', 'tesfaye', 'ተባ', 'korem', '2011-01-01', 'ምሁር', 'personal', NULL, '2011-04-08', '00102', '2', 'molla', '001', 'ትግራይ', '002', '', '0931569386', 'hailu@gmail.com', 0, 0, 0, 0, 0, 'ኣባል', '2018-11-14 21:09:28', '2018-11-14 21:13:32'),
('0101001/023/11', 'ገነት', 'ግደይ', 'ለማ', 'ኣን', 'ውቅሮ', '2011-03-05', 'ገባር', 'ሐረስታይ', NULL, '2011-03-07', '00101', '1', 'ሳባ', '103/8/2011', 'ትግራይ', '001', '', '0919500240', 'g/herhags@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-14 21:29:08', '2018-11-14 21:29:08'),
('050608/008/11', 'ዮርዳኖስ', 'ፀሃየ', 'ዋሲሁን', 'ኣን', 'ዓድዋ', '1980-01-01', 'ምሁር', 'ፐርሰኔል', NULL, '2011-10-15', '0014', '6', 'ንግስቲ', '05/2011', 'ትግራይ', '08', '', '0931489012', 'yordanos.tsehaye@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:11:49', '2018-11-14 21:13:01'),
('0101001/022/11', 'kibrom', 'abrham', 'hafte', 'ተባ', 'wukro', '2011-03-05', 'ሸቃላይ', 'wdabe', NULL, '2011-03-10', '00101', '1', 'gbrehiwot', '0029', 'ትግራይ', '001', '', '0914165484', 'kiflom@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:08:00', '2018-11-14 21:10:48'),
('050608/007/11', 'werttgty', 'nmbcx', 'hnbgfd', 'ተባ', 'mekelle', '1890-03-10', 'ሸቃላይ', 'mmhdar', NULL, '2011-03-05', '0014', '6', 'dsaf', '00125', 'ትግራይ', '08', '', '0912567854', 'fdhrwsag@gimail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተናዊሑ', '2018-11-14 21:08:56', '2018-11-14 21:15:35'),
('050608/009/11', 'lemlem', 'berhe', 'giday', 'ኣን', 'adwa', '1984-07-12', 'ምሁር', 'amehadari', NULL, '2004-04-27', '0014', '6', 'aregawi', '001/213', 'ትግራይ', '08', '', '0914893881', 'lemlemberhe12@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:12:31', '2018-11-15 16:18:37'),
('050607/008/11', 'ወልደማርያም', 'ገዋህድ', 'ደስታ', 'ተባ', 'ዓድዋ', '1888-03-11', 'ምሁር', 'ፐርሰኔል', NULL, '1996-02-01', '0013', '5', 'ዉዳበ', '09', 'ትግራይ', '07', '', '0914585952', 'weldemaryam.gwahid@gmail.com', 0, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:13:35', '2018-11-14 21:16:37'),
('0202002/005/11', 'ንግስቲ', 'ንጋቱ', 'ኣለሙ', 'ኣን', 'ኮረም', '1984-04-29', 'ምሁር', 'ፐርሰኔል', NULL, '2009-05-01', '00102', '2', 'ዉዳበ', '006', 'ትግራይ', '002', '', '0938797379', 'Nigist.nigatu@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:16:36', '2018-11-14 21:19:32'),
('050607/009/11', 'ትራሓስ', 'በረሀ', 'ሓጎስ', 'ኣን', 'ዓድዋ', '1995-05-05', 'ምሁር', 'ዉዳበ', NULL, '2011-03-03', '0013', '5', 'ወሉ', '008', 'ትግራይ', '07', '', '0914780341', 'weldemaryam.gwahid@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:21:42', '2018-11-14 21:23:09'),
('050607/010/11', 'መሰለ', 'ረዘነ', 'በረሀ', 'ተባ', 'መቀለ', '2002-02-04', 'ገባር', 'ተራ', NULL, '2011-03-05', '0013', ' ', 'ተካ', '0012', 'ትግራይ', '07', '', '-', 'gdaymesfn@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:25:00', '2018-11-14 21:32:11'),
('050608/010/11', 'milat', 'gebre', 'berhe', 'ኣን', 'adwa', '1992-03-08', 'ተምሃራይ', 'abal', NULL, '2009-03-04', '0014', ' ', 'tesfay', '234', 'ትግራይ', '08', '', '0914344560', 'lemlemberhe@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-14 21:33:01', '2018-11-15 16:25:59'),
('050607/011/11', 'ክፍለ', 'ኪደ', 'ዘርኡ', 'ተባ', 'ዓድዋ', '2001-03-01', 'ገባር', 'ገባር', NULL, '2019-03-08', '0013', '5', 'ሓጎስ ኪዳኑ', '003', 'ትግራይ', '07', '', '0914173726', 'yohans@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-14 21:39:59', '2018-11-14 21:39:59'),
('050607/012/11', 'helen', 'teklay', 'dawit', 'ኣን', 'adwa', '1989-03-11', 'ደኣንት', 'prodacts', NULL, '2011-03-11', '0013', '5', 'brhnae', '00123', 'ትግራይ', '07', '', '0925487862', 'helen@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተናዊሑ', '2018-11-14 21:41:09', '2018-11-14 21:41:46'),
('0101001/025/11', 'alme', 'baher', 'belata', 'ተባ', 'ainalm', '1984-03-04', 'ገባር', 'wedab', NULL, '2011-03-06', '00101', ' ', 'heneta', '002', 'ትግራይ', '001', '', '0303030303', 'muse@gmail.cosinkeym', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-15 16:27:26', '2018-11-15 16:27:26'),
('0101001/024/11', 'ሰላም', 'መስፍን', 'አረጋዊ', 'ኣን', 'ዓዲገራት', '1990-08-12', 'ተምሃራይ', 'የለን', NULL, '2011-02-09', '00101', '1', 'ትርሓስ', '333/2', 'ትግራይ', '001', '', '0914522328', '', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-15 16:14:24', '2018-11-15 16:22:44'),
('020304/003/11', 'Hagose', 'Alem', 'Gedeye', 'ተባ', 'Adigreat', '1961-03-19', 'ምሁር', 'Amahadari', NULL, '2011-03-06', '0112', '4', 'Aberehet', '2353/4', 'ትግራይ', '04', '', '0914235689', 'sgsgsg@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-15 16:17:44', '2018-11-15 16:23:15'),
('0101001/027/11', 'ቅድስት', 'አለም', 'በረሀ', 'ኣን', 'መቀለ', '1961-03-11', 'ሸቃላይ', 'ዉዳበ', NULL, '2011-03-02', '00101', '1', 'አበበ', '007', 'ትግራይ', '001', '', '0914780138', 'weldemaryam.gwahid@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-15 17:04:34', '2018-11-15 17:19:27'),
('0101001/028/11', 'ደስታ', 'ኣረጋዊ', 'መስፍን', 'ተባ', 'ዓዲግራት', '1980-05-01', 'ተምሃራይ', 'የለን', NULL, '2011-01-05', '00101', '1', 'ገሬ', '444/1', 'ትግራይ', '001', '', '', '', 1, 1, 1, 1, 1, 'ካብ ኣባልነት ዝተባረረ', '2018-11-15 17:05:00', '2018-11-15 20:42:25'),
('0101001/029/11', 'ቅድስት', 'አለም', 'በረሀ', 'ኣን', 'መቀለ', '1961-03-11', 'ሸቃላይ', 'ዉዳበ', NULL, '2011-03-02', '00101', '1', 'አበበ', '007', 'ትግራይ', '001', '', '0914780138', 'weldemaryam.gwahid@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተናዊሑ', '2018-11-15 17:08:31', '2018-11-15 20:42:16'),
('0101001/030/11', 'abeba', 'desta', 'abrha', 'ኣን', 'enderta', '1979-03-03', 'ተምሃራይ', 'persenel', NULL, '2010-03-02', '00101', '1', 'abadit', '0001', 'ትግራይ', '001', '', '0914200036', 'habengebre21@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-15 17:10:48', '2018-11-15 17:12:44'),
('0101001/031/11', 'ቅድስት', 'አለም', 'በረሀ', 'ኣን', 'መቀለ', '1961-03-11', 'ሸቃላይ', 'ዉዳበ', NULL, '2011-03-02', '00101', '1', 'አበበ', '007', 'ትግራይ', '001', '', '0914780138', 'weldemaryam.gwahid@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-15 17:17:36', '2018-11-15 17:17:36'),
('0101001/032/11', 'ቅድስት', 'አለም', 'በረሀ', 'ኣን', 'መቀለ', '1961-03-11', 'ሸቃላይ', 'ዉዳበ', NULL, '2011-03-02', '00101', '1', 'አበበ', '007', 'ትግራይ', '001', '', '0914780138', 'weldemaryam.gwahid@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-15 17:17:39', '2018-11-15 17:17:39'),
('050607/013/11', 'rahwa', 'hadush', 'desta', 'ኣን', 'adwa', '1990-03-12', 'ገባር', 'abal', NULL, '2009-03-04', '0013', '5', 'tesfay', '023/05', 'ትግራይ', '07', '', '0914893881', 'lemlemberhe@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይነት ተሰሪዙ', '2018-11-15 17:26:08', '2018-11-15 19:40:20'),
('050607/014/11', 'Alemu', 'hgu', 'rew', 'ተባ', 'Adwa', '1980-03-03', 'ምሁር', 'EXpert', NULL, '2011-03-02', '0013', '5', 'Kebde', '021', 'ትግራይ', '07', '', '0914396491', 'gbrekiros@gmail.com', 1, 1, 1, 1, 1, 'ሕፁይ', '2018-11-15 20:38:43', '2018-11-15 20:38:43'),
('0101001/034/11', 'andom', 'gebre', 'gebres', 'ተባ', 'asmera', '2001-03-01', 'መምህር', 'abal', NULL, '2011-03-03', '00101', '1', 'rezene', '01111', 'ትግራይ', '001', '', '0910139241', 'hatekel@gmail.com', 1, 1, 1, 1, 1, 'ኣባል', '2018-11-15 20:48:06', '2018-11-15 20:49:22'),
('0101001/035/11', 'ኣበበ', 'ከበድ', 'ሃይሉ', 'ተባ', 'መቐለ', '1982-03-13', 'ደኣንት', 'ኣመሓዳሪ', 'ጀማሪ', '2011-03-05', '00101', '1', 'ሃፍቱ', '324/3242', 'ትግራይ', '001', '', '0920304050', 'q@p.com', 1, 1, 1, 0, 0, 'ሕፁይ', '2018-11-22 03:17:39', '2018-11-22 03:17:39'),
('0101001/000006', 'berhe', 'haftu', 'haile', 'ተባ', 'mekelle', '2011-03-07', 'ገባር', 'farmer', NULL, '2011-03-28', '00101', '1', 'john', '324/568', 'ትግራይ', '001', '', '0914172030', '', 0, 1, 1, 0, 0, 'ሕፁይ', '2018-12-07 14:07:20', '2018-12-07 14:07:20'),
('0101001/000007', 'kebede', 'haftu', 'haile', 'ተባ', 'mekelle', '2011-03-07', 'ገባር', 'farmer', NULL, '2011-03-28', '00101', '1', 'john', '324/568', 'ትግራይ', '001', '', '0914204050', 'f@q.com', 0, 1, 1, 0, 0, 'ሕፁይ', '2018-12-07 14:13:36', '2018-12-07 14:13:36');

-- --------------------------------------------------------

--
-- Table structure for table `lower_leaders`
--

DROP TABLE IF EXISTS `lower_leaders`;
CREATE TABLE IF NOT EXISTS `lower_leaders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `evaluation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lower_leaders_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `lower_leaders`
--

INSERT INTO `lower_leaders` (`id`, `hitsuyID`, `model`, `evaluation`, `remark`, `created_at`, `updated_at`) VALUES
(3, '0101001/006/11', 'ሞዴል', 'B', 'delete', '2018-11-29 13:07:25', '2018-11-29 13:07:25'),
(7, '0101001/006/11', 'ሞዴል', 'B', 'sdkljflk', '2018-11-30 03:43:44', '2018-11-30 03:43:44');

-- --------------------------------------------------------

--
-- Table structure for table `meseretawiwidabeaplans`
--

DROP TABLE IF EXISTS `meseretawiwidabeaplans`;
CREATE TABLE IF NOT EXISTS `meseretawiwidabeaplans` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `widabecode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `planyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descrpt` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meseretawiwidabeaplans`
--

INSERT INTO `meseretawiwidabeaplans` (`id`, `widabecode`, `planyear`, `plantype`, `amount`, `descrpt`, `created_at`, `updated_at`) VALUES
(1, '00101', '2011', 'ነበርቲ ተራ ኣባላት', '38', 'sldjfa', '2018-11-11 08:00:09', '2018-11-11 08:00:09');

-- --------------------------------------------------------

--
-- Table structure for table `meseretawi_wdabes`
--

DROP TABLE IF EXISTS `meseretawi_wdabes`;
CREATE TABLE IF NOT EXISTS `meseretawi_wdabes` (
  `tabiaCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `widabeName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `widabeCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`widabeCode`),
  KEY `meseretawi_wdabes_tabiacode_foreign` (`tabiaCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `meseretawi_wdabes`
--

INSERT INTO `meseretawi_wdabes` (`tabiaCode`, `widabeName`, `widabeCode`, `created_at`, `updated_at`) VALUES
('001', 'መለስ', '00101', '2017-11-09 04:48:14', '2018-12-07 15:08:32'),
('002', 'ኣባይ', '00102', '2017-11-09 04:48:35', '2017-11-09 04:48:35'),
('03', 'አዲ አርቃይ', '0012', NULL, NULL),
('04', 'Construction', '0112', NULL, NULL),
('07', 'ምፍራይ ንህቢ', '0013', NULL, NULL),
('001', 'ቖቓሕ', '00113', '2018-12-07 15:18:38', '2018-12-07 15:18:38');

-- --------------------------------------------------------

--
-- Table structure for table `mewachos`
--

DROP TABLE IF EXISTS `mewachos`;
CREATE TABLE IF NOT EXISTS `mewachos` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mewacho_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payday` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `mewachos_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mewachos`
--

INSERT INTO `mewachos` (`id`, `hitsuyID`, `mewacho_name`, `payday`, `amount`, `created_at`, `updated_at`) VALUES
(3, '0101001/001/10', '11 ለካቲት', '2011-02-02', '50.00', '2018-11-13 20:05:29', '2018-11-13 20:05:29');

-- --------------------------------------------------------

--
-- Table structure for table `mewacho_settings`
--

DROP TABLE IF EXISTS `mewacho_settings`;
CREATE TABLE IF NOT EXISTS `mewacho_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `purpose` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `mtype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `deadline` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `mewacho_settings`
--

INSERT INTO `mewacho_settings` (`id`, `name`, `purpose`, `mtype`, `amount`, `deadline`, `created_at`, `updated_at`) VALUES
(1, '11 ለካቲት', 'ፅምብል 11 ለካቲት', 'ምሁር', '50.00', '2011-06-30', '2018-03-20 22:52:25', '2018-11-27 02:55:47'),
(2, 'ጉንበት 20', 'ፅምብል 20 ጉንበት', 'ደኣንት', '10.00', '2010-06-30', '2018-03-20 22:52:58', '2018-03-20 22:52:58');

-- --------------------------------------------------------

--
-- Table structure for table `middle_leaders`
--

DROP TABLE IF EXISTS `middle_leaders`;
CREATE TABLE IF NOT EXISTS `middle_leaders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer5` text COLLATE utf8_unicode_ci NOT NULL,
  `answer6` text COLLATE utf8_unicode_ci NOT NULL,
  `answer7` text COLLATE utf8_unicode_ci NOT NULL,
  `answer8` text COLLATE utf8_unicode_ci NOT NULL,
  `answer9` text COLLATE utf8_unicode_ci NOT NULL,
  `answer10` text COLLATE utf8_unicode_ci NOT NULL,
  `answer11` text COLLATE utf8_unicode_ci NOT NULL,
  `answer12` text COLLATE utf8_unicode_ci NOT NULL,
  `answer13` text COLLATE utf8_unicode_ci NOT NULL,
  `answer14` text COLLATE utf8_unicode_ci NOT NULL,
  `answer15` text COLLATE utf8_unicode_ci NOT NULL,
  `answer16` text COLLATE utf8_unicode_ci NOT NULL,
  `result1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result10` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result11` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result12` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result13` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result14` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `middle_leaders_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `middle_leaders`
--

INSERT INTO `middle_leaders` (`id`, `hitsuyID`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `answer7`, `answer8`, `answer9`, `answer10`, `answer11`, `answer12`, `answer13`, `answer14`, `answer15`, `answer16`, `result1`, `result2`, `result3`, `result4`, `result5`, `result6`, `result7`, `result8`, `result9`, `result10`, `result11`, `result12`, `result13`, `result14`, `remark`, `created_at`, `updated_at`) VALUES
(1, '0202002/001/10', 'dklfs', 'd', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '2018-11-29 12:36:13', '2018-11-29 12:36:13');

-- --------------------------------------------------------

--
-- Table structure for table `midebas`
--

DROP TABLE IF EXISTS `midebas`;
CREATE TABLE IF NOT EXISTS `midebas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `birkiCommittee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deraja` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `awekakla` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `woreda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedWudabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedWahio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldzone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldworeda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldassignedWudabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldassignedWahio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proposedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `commentedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approvedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `isProposed` tinyint(1) NOT NULL,
  `approvedWudabe` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `midebas_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=127 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(83, '2014_10_12_000000_create_users_table', 1),
(84, '2014_10_12_100000_create_password_resets_table', 1),
(85, '2017_08_20_051256_create_hitsuys_table', 1),
(86, '2017_08_28_175648_create_zobatats_table', 1),
(87, '2017_08_29_200117_create_data1s_table', 1),
(88, '2017_09_01_112607_create_woredas_table', 1),
(89, '2017_09_07_031154_create_tabias_table', 1),
(90, '2017_09_08_091131_create_monthlies_table', 1),
(91, '2017_09_08_123312_create_meseretawi_wdabes_table', 1),
(92, '2017_09_17_054948_create_transfers_table', 1),
(93, '2017_09_19_091519_create_approved_hitsuys_table', 1),
(94, '2017_09_20_022641_create_midebas_table', 1),
(95, '2017_09_20_024358_create_penalties_table', 1),
(96, '2017_09_20_025017_create_terminations_table', 1),
(97, '2017_09_20_033610_create_yearlies_table', 1),
(98, '2017_09_21_074130_create_rejected_hitsuys_table', 1),
(99, '2017_09_21_074155_create_notyet_hitsuys_table', 1),
(100, '2017_09_30_005146_create_siltenas_table', 1),
(101, '2017_10_04_091418_create_middle_leaders_table', 1),
(102, '2017_10_09_082909_create_wahios_table', 1),
(103, '2017_10_21_053300_create_core_degeftis_table', 1),
(104, '2017_10_27_064739_create_yearly_settings_table', 1),
(105, '2017_11_03_002946_create_monthly_settings_table', 1),
(106, '2017_11_03_031621_create_mewacho_settings_table', 1),
(107, '2017_11_03_034220_create_mewachos_table', 1),
(108, '2017_11_06_172425_create_first_instant_leaders_table', 1),
(109, '2017_11_09_040808_create_experts_table', 1),
(110, '2017_11_11_115910_create_dismisses_table', 1),
(111, '2017_12_02_032928_create_training_settings_table', 1),
(112, '2017_12_02_133802_create_donors_table', 1),
(113, '2017_12_10_025130_create_gifts_table', 1),
(114, '2017_12_31_045505_create_lower_leaders_table', 1),
(115, '2017_12_31_104306_create_tara_members_table', 1),
(116, '2018_01_10_162022_create_top_leaders_table', 1),
(117, '2018_01_28_083054_create_educations_table', 1),
(118, '2018_01_28_204959_create_work_expriences_table', 1),
(119, '2018_01_29_073953_create_officeplans_table', 1),
(120, '2018_01_29_074037_create_zoneplans_table', 1),
(121, '2018_01_29_074051_create_woredaplans_table', 1),
(122, '2018_01_29_074137_create_meseretawiwidabeaplans_table', 1),
(123, '2018_01_31_154342_create_career_informations_table', 1),
(124, '2018_01_31_161215_create_education_informations_table', 1),
(125, '2018_02_28_151937_create_super_leaders_table', 1),
(126, '2018_04_07_091552_create_srires_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `monthlies`
--

DROP TABLE IF EXISTS `monthlies`;
CREATE TABLE IF NOT EXISTS `monthlies` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `month` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `monthlies_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=37 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `monthlies`
--

INSERT INTO `monthlies` (`id`, `hitsuyID`, `month`, `year`, `amount`, `created_at`, `updated_at`) VALUES
(3, '0101001/001/10', 'ሚያዝያ', 2011, '32.25', '2018-11-11 14:04:38', '2018-11-11 14:04:38'),
(4, '050608/001/11', 'መስከረም', 2010, '24.34', '2018-11-15 16:32:57', '2018-11-15 16:32:57'),
(5, '0101001/012/11', 'መስከረም', 2011, '33.75', '2018-11-15 17:01:04', '2018-11-15 17:01:04'),
(6, '0101001/001/10', 'መስከረም', 2011, '32.25', '2018-11-15 17:11:29', '2018-11-15 17:11:29'),
(7, '0101001/001/10', 'መስከረም', 2011, '32.25', '2018-11-15 17:11:31', '2018-11-15 17:11:31'),
(8, '050608/005/11', 'ነሓሰ', 2011, '33.75', '2018-11-15 17:12:02', '2018-11-15 17:12:02'),
(9, '050608/005/11', 'ነሓሰ', 2011, '33.75', '2018-11-15 17:12:03', '2018-11-15 17:12:03'),
(10, '0101001/001/10', 'መስከረም', 2011, '32.25', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(11, '0202002/001/10', 'መስከረም', 2011, '30.75', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(12, '0101001/007/11', 'መስከረም', 2011, '58.50', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(13, '020304/001/11', 'መስከረም', 2011, '23.74', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(14, '0101001/012/11', 'መስከረም', 2011, '33.75', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(15, '0101001/017/11', 'መስከረም', 2011, '30.00', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(16, '050607/001/11', 'መስከረም', 2011, '48.75', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(17, '0101001/018/11', 'መስከረም', 2011, '32.25', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(18, '050608/005/11', 'መስከረም', 2011, '33.75', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(19, '050608/001/11', 'መስከረም', 2011, '24.34', '2018-11-15 17:12:35', '2018-11-15 17:12:35'),
(20, '0101001/001/10', 'መስከረም', 2011, '32.25', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(21, '0202002/001/10', 'መስከረም', 2011, '30.75', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(22, '0101001/007/11', 'መስከረም', 2011, '58.50', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(23, '020304/001/11', 'መስከረም', 2011, '23.74', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(24, '0101001/012/11', 'መስከረም', 2011, '33.75', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(25, '0101001/017/11', 'መስከረም', 2011, '30.00', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(26, '050607/001/11', 'መስከረም', 2011, '48.75', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(27, '0101001/018/11', 'መስከረም', 2011, '32.25', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(28, '050608/005/11', 'መስከረም', 2011, '33.75', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(29, '050608/001/11', 'መስከረም', 2011, '24.34', '2018-11-15 17:12:36', '2018-11-15 17:12:36'),
(30, '0202002/001/10', 'ጥቅምቲ', 2011, '30.75', '2018-11-15 17:18:29', '2018-11-15 17:18:29'),
(31, '0101001/018/11', 'መስከረም', 2011, '32.25', '2018-11-15 17:24:40', '2018-11-15 17:24:40'),
(32, '0202002/001/10', 'ሕዳር', 2011, '20.50', '2018-11-25 13:02:32', '2018-11-25 13:02:32'),
(33, '0202002/001/10', 'ሕዳር', 2011, '20.50', '2018-11-25 13:05:17', '2018-11-25 13:05:17'),
(34, '0202002/001/10', 'ታሕሳስ', 2011, '20.50', '2018-11-25 13:12:45', '2018-11-25 13:12:45'),
(35, '0202002/001/10', 'ጥሪ', 2011, '20.50', '2018-11-25 13:14:04', '2018-11-25 13:14:04'),
(36, '0202002/001/10', 'መጋቢት', 2011, '20.50', '2018-11-25 13:14:38', '2018-11-25 13:14:38');

-- --------------------------------------------------------

--
-- Table structure for table `monthly_settings`
--

DROP TABLE IF EXISTS `monthly_settings`;
CREATE TABLE IF NOT EXISTS `monthly_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `from` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `to` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `percent` decimal(6,5) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `monthly_settings`
--

INSERT INTO `monthly_settings` (`id`, `code`, `from`, `to`, `percent`, `created_at`, `updated_at`) VALUES
(1, '01', '0', '500', '0.00000', '2018-03-20 22:41:13', '2018-11-26 03:35:25'),
(3, '02', '500', '1000', '0.00250', '2018-03-20 22:45:00', '2018-03-20 22:45:00'),
(4, '03', '1000', '4101', '0.00500', '2018-03-20 22:45:51', '2018-03-20 22:45:51'),
(5, '04', '4101', '10000', '0.00750', '2018-03-20 22:47:34', '2018-03-20 22:47:34'),
(6, '05', '10000', '20000', '0.00850', '2018-03-20 22:48:41', '2018-03-20 22:48:41'),
(17, '06', '20000', '30000', '0.00950', '2018-11-26 14:18:26', '2018-11-26 14:18:26'),
(16, '07', '30000', '40000', '0.01000', '2018-11-26 14:17:59', '2018-11-26 14:17:59');

-- --------------------------------------------------------

--
-- Table structure for table `notyet_hitsuys`
--

DROP TABLE IF EXISTS `notyet_hitsuys`;
CREATE TABLE IF NOT EXISTS `notyet_hitsuys` (
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `postponedDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `notyet_hitsuys`
--

INSERT INTO `notyet_hitsuys` (`hitsuyID`, `postponedDate`, `created_at`, `updated_at`) VALUES
('0202002/002/10', '2011-02-28', '2018-11-09 13:51:05', '2018-11-09 13:51:05'),
('0101001/002/10', '2011-06-05', '2018-11-14 20:06:02', '2018-11-14 20:06:02'),
('0202002/001/10', '2011-03-05', '2018-11-14 19:00:09', '2018-11-14 19:00:09'),
('0101001/006/11', '2011-03-07', '2018-11-14 20:08:22', '2018-11-14 20:08:22'),
('0101001/014/11', '2011-03-07', '2018-11-14 20:45:55', '2018-11-14 20:45:55'),
('0101001/015/11', '2021-03-05', '2018-11-14 20:55:09', '2018-11-14 20:55:09'),
('020303/001/11', '2011-03-20', '2018-11-14 20:55:44', '2018-11-14 20:55:44'),
('050608/003/11', '2011-04-15', '2018-11-14 20:56:36', '2018-11-14 20:56:36'),
('0101001/008/11', '2010-08-08', '2018-11-14 20:57:51', '2018-11-14 20:57:51'),
('0202002/003/11', '2011-03-28', '2018-11-14 20:57:57', '2018-11-14 20:57:57'),
('050608/002/11', '2011-03-29', '2018-11-14 21:01:56', '2018-11-14 21:01:56'),
('0101001/020/11', '2011-03-07', '2018-11-14 21:07:20', '2018-11-14 21:07:20'),
('050607/002/11', '2011-03-14', '2018-11-14 21:07:34', '2018-11-14 21:07:34'),
('0101001/019/11', '2011-03-03', '2018-11-14 21:07:45', '2018-11-14 21:07:45'),
('020303/005/11', '2011-03-12', '2018-11-14 21:14:24', '2018-11-14 21:14:24'),
('0101001/010/11', '2011-03-04', '2018-11-14 21:15:25', '2018-11-14 21:15:25'),
('050607/008/11', '2011-03-29', '2018-11-14 21:15:28', '2018-11-14 21:15:28'),
('050608/007/11', '2011-06-12', '2018-11-14 21:15:35', '2018-11-14 21:15:35'),
('020303/002/11', '2011-03-03', '2018-11-14 21:15:44', '2018-11-14 21:15:44'),
('050608/001/11', '2011-06-28', '2018-11-14 21:17:25', '2018-11-14 21:17:25'),
('0202002/005/11', '2011-03-02', '2018-11-14 21:17:41', '2018-11-14 21:17:41'),
('0101001/009/11', '2011-03-05', '2018-11-14 21:18:24', '2018-11-14 21:18:24'),
('050608/009/11', '1972-04-23', '2018-11-14 21:18:25', '2018-11-14 21:18:25'),
('050607/010/11', '2011-03-06', '2018-11-14 21:26:31', '2018-11-14 21:26:31'),
('050607/012/11', '2011-03-27', '2018-11-14 21:41:46', '2018-11-14 21:41:46'),
('050607/013/11', '2011-03-12', '2018-11-15 19:30:19', '2018-11-15 19:30:19'),
('0101001/029/11', '2011-03-28', '2018-11-15 20:42:16', '2018-11-15 20:42:16');

-- --------------------------------------------------------

--
-- Table structure for table `officeplans`
--

DROP TABLE IF EXISTS `officeplans`;
CREATE TABLE IF NOT EXISTS `officeplans` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `planyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descrpt` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE IF NOT EXISTS `password_resets` (
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `penalties`
--

DROP TABLE IF EXISTS `penalties`;
CREATE TABLE IF NOT EXISTS `penalties` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chargeType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `chargeLevel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `penaltyGiven` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proposedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approvedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `duration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `isReported` tinyint(1) NOT NULL,
  `isApproved` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `penalties_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `penalties`
--

INSERT INTO `penalties` (`id`, `hitsuyID`, `chargeType`, `chargeLevel`, `penaltyGiven`, `proposedBy`, `approvedBy`, `duration`, `startDate`, `isReported`, `isApproved`, `created_at`, `updated_at`) VALUES
(8, '0101001/028/11', 'ብኸቢድ ገበን ተኸሲሱ ገበነኛ ዝተብሃለ', 'ኸቢድ', 'ካብ ኣባልነት ምብራር', 'ከ', 'ወ', ' ', '2011-03-23', 1, 1, '2018-11-15 20:42:25', '2018-11-15 20:42:25'),
(4, '000101', 'ናይ ስነምግባር መጠንቐቕታ ተዋሂብዎ ዝደገመ', 'ኸቢድ', 'መጠንቀቕታ', 'wwwww', 'ddddd', '6 ኣዋርሕ', '2011-03-19', 1, 1, '2018-11-15 16:29:30', '2018-11-15 16:29:30'),
(5, '120', 'ቀሊል ናይ ስነምግባር ጉድለት', 'ቀሊል', 'መጠንቀቕታ', 'ጣብያውዳብ', 'ውዳብ', '6 ኣዋርሕ', '2011-03-07', 1, 1, '2018-11-15 16:35:00', '2018-11-15 16:35:00'),
(6, '050607/006/11', 'ናይ ጉጅለ ምንቅስቓስ ምክያድ', 'ኸቢድ', 'ካብ ሓላፍነት ንውሱን ጊዜ ምእጋድ', 'selam', 'brhane', '6 ኣዋርሕ', '2011-03-05', 1, 1, '2018-11-15 20:31:01', '2018-11-15 20:31:01'),
(7, '0101001/032/11', 'ቀሊል ናይ ስነምግባር ጉድለት', 'ቀሊል', 'መጠንቀቕታ', 'ሓጎስ', 'በየነ', '6 ኣዋርሕ', '2011-03-10', 1, 1, '2018-11-15 20:33:26', '2018-11-15 20:33:26'),
(9, '0101001/028/11', 'ቀሊል ናይ ስነምግባር ጉድለት', 'ቀሊል', 'መጠንቀቕታ', 'ታደሰ', 'ታደሰ', '6 ኣዋርሕ', '2011-03-02', 1, 1, '2018-11-15 20:42:54', '2018-11-15 20:42:54'),
(10, '001234', 'ናይ ስነምግባር መጠንቐቕታ ተዋሂብዎ ዝደገመ', 'ቀሊል', 'መጠንቀቕታ', 'wahiyo', 'mwidab', '6 ኣዋርሕ', '2011-03-06', 0, 1, '2018-11-15 20:46:44', '2018-11-15 20:46:44');

-- --------------------------------------------------------

--
-- Table structure for table `rejected_hitsuys`
--

DROP TABLE IF EXISTS `rejected_hitsuys`;
CREATE TABLE IF NOT EXISTS `rejected_hitsuys` (
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rejectionReason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `rejectionDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `rejected_hitsuys`
--

INSERT INTO `rejected_hitsuys` (`hitsuyID`, `rejectionReason`, `rejectionDate`, `created_at`, `updated_at`) VALUES
('0101001/002/10', 'aybekeetn', '2011-03-05', '2018-11-14 20:06:57', '2018-11-14 20:06:57'),
('0101001/005/11', 'ንአባልነት ስለ ዘይትበቅእ', '2011-03-04', '2018-11-14 20:16:46', '2018-11-14 20:16:46'),
('0101001/006/11', 'dspline', '2011-03-05', '2018-11-14 20:17:12', '2018-11-14 20:17:12'),
('0101001/004/11', 'ግቡኣ ዘይምፍፃም', '2011-03-05', '2018-11-14 20:43:19', '2018-11-14 20:43:19'),
('0101001/015/11', 'ስርቂ', '2011-03-05', '2018-11-14 20:57:56', '2018-11-14 20:57:56'),
('020303/001/11', 'not perfect', '2011-05-11', '2018-11-14 20:58:36', '2018-11-14 20:58:36'),
('020303/004/11', 'buqee aykonene', '2011-03-05', '2018-11-14 21:03:15', '2018-11-14 21:03:15'),
('0101001/020/11', 'fasdfasf', '2011-03-05', '2018-11-14 21:08:09', '2018-11-14 21:08:09'),
('050608/004/11', 'bkflit', '2011-03-05', '2018-11-14 21:16:25', '2018-11-14 21:16:25'),
('0101001/010/11', 'bkat yelewm', '2011-03-03', '2018-11-14 21:16:56', '2018-11-14 21:16:56'),
('0202002/005/11', 'ክፍሊት ብእዋኑ ዘይምክፈል', '2011-03-23', '2018-11-14 21:18:29', '2018-11-14 21:18:29'),
('050607/004/11', 'kflit zeymkfal', '2011-03-04', '2018-11-14 21:20:25', '2018-11-14 21:20:25'),
('020303/005/11', 'gubuxzyMfsm', '1972-04-04', '2018-11-14 21:20:48', '2018-11-14 21:20:48'),
('050608/009/11', 'tsegeme sne mgbar', '2011-03-05', '2018-11-14 21:23:36', '2018-11-14 21:23:36'),
('0101001/009/11', 'ሞየቱ', '2011-03-08', '2018-11-14 21:37:41', '2018-11-14 21:37:41'),
('050608/010/11', 'manay', '2011-03-12', '2018-11-14 21:43:14', '2018-11-14 21:43:14'),
('050607/013/11', 'kflit', '2011-03-27', '2018-11-15 19:40:20', '2018-11-15 19:40:20'),
('050608/001/11', 'ብምክንያት ዘይምብቃዕ', '2011-03-06', '2018-11-15 20:11:39', '2018-11-15 20:11:39'),
('0202002/003/11', 'bque xykonn', '2011-03-06', '2018-11-15 20:40:40', '2018-11-15 20:40:40');

-- --------------------------------------------------------

--
-- Table structure for table `siltenas`
--

DROP TABLE IF EXISTS `siltenas`;
CREATE TABLE IF NOT EXISTS `siltenas` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trainingLevel` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trainer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `numDays` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trainingPlace` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trainingType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zoneDecision` tinyint(1) NOT NULL,
  `woredaApproved` tinyint(1) NOT NULL,
  `zoneApproved` tinyint(1) NOT NULL,
  `officeApproved` tinyint(1) NOT NULL,
  `isDocumented` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siltenas_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=73 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `siltenas`
--

INSERT INTO `siltenas` (`id`, `hitsuyID`, `trainingLevel`, `trainer`, `startDate`, `endDate`, `numDays`, `trainingPlace`, `trainingType`, `zoneDecision`, `woredaApproved`, `zoneApproved`, `officeApproved`, `isDocumented`, `created_at`, `updated_at`) VALUES
(5, '0101001/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'TPLF', '2011-02-06', '2011-03-27', '13', 'Mekelle', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-10 05:15:04', '2018-11-10 05:15:04'),
(6, '0101001/012/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'tplf', '2011-03-02', '2011-03-06', '5', 'mekelle', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:19:13', '2018-11-15 16:19:13'),
(7, '0101001/007/11', 'ላዕለዋይ ኣመራርሓ ስልጠና', 'selam', '2011-03-07', '2011-03-12', '5', 'aksum', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:21:07', '2018-11-15 16:21:07'),
(8, '0101001/012/11', 'ላዕለዋይ ኣመራርሓ ስልጠና', 'selam', '2011-03-07', '2011-03-12', '5', 'aksum', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:21:07', '2018-11-15 16:21:07'),
(9, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'tplf', '2011-03-04', '2011-04-04', '30', 'awasa', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:22:53', '2018-11-15 16:22:53'),
(10, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'tplf', '2011-03-04', '2011-04-04', '30', 'awasa', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:22:56', '2018-11-15 16:22:56'),
(11, '050608/008/11', 'ላዕለዋይ ኣመራርሓ ስልጠና', 'nigsti', '2011-03-15', '2011-03-20', '5', 'adwa', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:23:13', '2018-11-15 16:23:13'),
(12, '0202002/005/11', 'ላዕለዋይ ኣመራርሓ ስልጠና', 'yordanos', '2011-03-01', '2011-03-05', '5', 'machow', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:25:00', '2018-11-15 16:25:00'),
(13, '0101001/003/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'መለስ ኣካዳሚክ', '2011-03-06', '2011-03-30', '24 ', 'መቀለ', 'ናይ ውድብ', 1, 1, 1, 0, 0, '2018-11-15 16:30:00', '2018-11-15 16:30:00'),
(14, '020304/001/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'በላይ', '2011-03-25', '2011-05-01', '30', 'መቀለ', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:30:55', '2018-11-15 16:30:55'),
(15, '0101001/003/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'መለስ ኣካዳሚክ', '2011-03-02', '2011-03-30', '28', 'መቀለ', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 16:32:10', '2018-11-15 16:32:10'),
(16, '0202002/002/10', 'ማእኸላይ ኣመራርሓ ስልጠና', 'debretsion', '2011-02-08', '2011-03-02', '5', 'weree leke', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:00:28', '2018-11-15 17:00:28'),
(17, '0101001/006/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'debretsion', '2011-02-08', '2011-03-02', '5', 'weree leke', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:00:28', '2018-11-15 17:00:28'),
(18, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'wudb', '1972-04-22', '1972-04-23', '1', 'mkl', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:24:20', '2018-11-15 17:24:20'),
(19, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'wudb', '1972-04-22', '1972-04-23', '1', 'mkl', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:24:23', '2018-11-15 17:24:23'),
(20, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'wudb', '1972-04-22', '1972-04-23', '1', 'mkl', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:24:24', '2018-11-15 17:24:24'),
(21, '0101001/012/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'betshft wudb', '2011-03-06', '2011-03-17', '11', 'mekel', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:25:00', '2018-11-15 17:25:00'),
(22, '0101001/014/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'betshft wudb', '2011-03-06', '2011-03-17', '11', 'mekel', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:25:00', '2018-11-15 17:25:00'),
(23, '0101001/016/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'betshft wudb', '2011-03-06', '2011-03-17', '11', 'mekel', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 17:25:00', '2018-11-15 17:25:00'),
(24, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'berhe', '2011-01-03', '2011-03-02', '10', 'mekele', 'ናይ መንግስቲ', 1, 1, 1, 1, 1, '2018-11-15 17:26:26', '2018-11-15 17:26:26'),
(25, '0101001/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'berhe', '2011-01-03', '2011-03-02', '10', 'mekele', 'ናይ መንግስቲ', 1, 1, 1, 1, 1, '2018-11-15 17:26:26', '2018-11-15 17:26:26'),
(26, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'berhe', '2011-01-03', '2011-03-02', '10', 'mekele', 'ናይ መንግስቲ', 1, 1, 1, 1, 1, '2018-11-15 17:26:26', '2018-11-15 17:26:26'),
(27, '0101001/006/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'berhe', '2011-01-03', '2011-03-02', '10', 'mekele', 'ናይ መንግስቲ', 1, 1, 1, 1, 1, '2018-11-15 17:26:26', '2018-11-15 17:26:26'),
(28, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'freselam', '2011-01-02', '2011-03-03', '30', 'mu', 'ናይ መንግስቲ', 1, 1, 1, 1, 1, '2018-11-15 19:41:53', '2018-11-15 19:41:53'),
(29, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'freselam', '2011-01-02', '2011-03-03', '30', 'mu', 'ናይ መንግስቲ', 1, 1, 1, 1, 1, '2018-11-15 19:42:03', '2018-11-15 19:42:03'),
(30, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'data admin', '2011-02-06', '2011-03-07', '31', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:26:56', '2018-11-15 20:26:56'),
(31, '0101001/003/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'data admin', '2011-02-06', '2011-03-07', '31', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:26:56', '2018-11-15 20:26:56'),
(32, '0101001/016/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'data admin', '2011-02-06', '2011-03-07', '31', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:26:56', '2018-11-15 20:26:56'),
(33, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'jhgj', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:31:19', '2018-11-15 20:31:19'),
(34, '0101001/003/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'jhgj', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:31:19', '2018-11-15 20:31:19'),
(35, '0101001/016/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'jhgj', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:31:19', '2018-11-15 20:31:19'),
(36, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(37, '0101001/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(38, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(39, '0101001/006/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(40, '0101001/007/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(41, '020304/001/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(42, '0101001/003/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(43, '0101001/012/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(44, '0101001/014/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(45, '0101001/016/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:40', '2018-11-15 20:31:40'),
(46, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(47, '0101001/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(48, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(49, '0101001/006/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(50, '0101001/007/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(51, '020304/001/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(52, '0101001/003/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(53, '0101001/012/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(54, '0101001/014/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(55, '0101001/016/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'hadush', '2011-02-02', '2011-03-02', '30', 'meles akadami', 'ናይ ውድብ', 0, 1, 0, 0, 1, '2018-11-15 20:31:42', '2018-11-15 20:31:42'),
(56, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'data', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:33:58', '2018-11-15 20:33:58'),
(57, '0202002/001/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'data', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:33:58', '2018-11-15 20:33:58'),
(58, '0101001/007/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'data', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:33:58', '2018-11-15 20:33:58'),
(59, '020304/001/11', 'ጀማሪ ኣመራርሓ ስልጠና', 'data', '2011-03-01', '2011-03-06', '5', 'mit', 'ናይ ውድብ', 1, 1, 1, 1, 1, '2018-11-15 20:33:58', '2018-11-15 20:33:58'),
(60, '0202002/002/10', 'ጀማሪ ኣመራርሓ ስልጠና', 'meless acadami', '2011-03-11', '2011-03-15', '4', 'mekelle', 'ናይ ውድብ', 0, 0, 0, 0, 0, '2018-11-15 20:34:15', '2018-11-15 20:34:15'),
(61, '0202002/002/10', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:02', '2018-11-15 20:36:02'),
(62, '0101001/001/10', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:02', '2018-11-15 20:36:02'),
(63, '020304/001/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:02', '2018-11-15 20:36:02'),
(64, '0101001/012/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:02', '2018-11-15 20:36:02'),
(65, '0101001/016/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:02', '2018-11-15 20:36:02'),
(66, '0101001/017/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:02', '2018-11-15 20:36:02'),
(67, '0202002/002/10', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:04', '2018-11-15 20:36:04'),
(68, '0101001/001/10', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:04', '2018-11-15 20:36:04'),
(69, '020304/001/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:04', '2018-11-15 20:36:04'),
(70, '0101001/012/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:04', '2018-11-15 20:36:04'),
(71, '0101001/016/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:04', '2018-11-15 20:36:04'),
(72, '0101001/017/11', 'ማእኸላይ ኣመራርሓ ስልጠና', 'abirhaly', '2011-03-05', '2011-03-09', '4', 'makl', 'ናይ ውድብ', 0, 0, 1, 0, 0, '2018-11-15 20:36:04', '2018-11-15 20:36:04');

-- --------------------------------------------------------

--
-- Table structure for table `srires`
--

DROP TABLE IF EXISTS `srires`;
CREATE TABLE IF NOT EXISTS `srires` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `srires`
--

INSERT INTO `srires` (`id`, `type`, `code`, `result`, `year`, `created_at`, `updated_at`) VALUES
(1, 'ወረዳ', '01', 'ቅድሚት', '2011', '2018-11-17 02:36:20', '2018-11-17 02:36:20'),
(2, 'ወረዳ', '04', 'ቅድሚት', '2011', '2018-11-17 02:36:20', '2018-11-17 02:36:20'),
(3, 'ወረዳ', '02', 'ማእኸላይ', '2011', '2018-11-25 13:58:27', '2018-11-25 13:58:27');

-- --------------------------------------------------------

--
-- Table structure for table `super_leaders`
--

DROP TABLE IF EXISTS `super_leaders`;
CREATE TABLE IF NOT EXISTS `super_leaders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer5` text COLLATE utf8_unicode_ci NOT NULL,
  `answer6` text COLLATE utf8_unicode_ci NOT NULL,
  `answer7` text COLLATE utf8_unicode_ci NOT NULL,
  `answer8` text COLLATE utf8_unicode_ci NOT NULL,
  `answer9` text COLLATE utf8_unicode_ci NOT NULL,
  `answer10` text COLLATE utf8_unicode_ci NOT NULL,
  `answer11` text COLLATE utf8_unicode_ci NOT NULL,
  `answer12` text COLLATE utf8_unicode_ci NOT NULL,
  `answer13` text COLLATE utf8_unicode_ci NOT NULL,
  `answer14` text COLLATE utf8_unicode_ci NOT NULL,
  `answer15` text COLLATE utf8_unicode_ci NOT NULL,
  `result1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result10` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result11` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result12` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result13` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `super_leaders_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `super_leaders`
--

INSERT INTO `super_leaders` (`id`, `hitsuyID`, `answer1`, `answer2`, `answer3`, `answer4`, `answer5`, `answer6`, `answer7`, `answer8`, `answer9`, `answer10`, `answer11`, `answer12`, `answer13`, `answer14`, `answer15`, `result1`, `result2`, `result3`, `result4`, `result5`, `result6`, `result7`, `result8`, `result9`, `result10`, `result11`, `result12`, `result13`, `remark`, `created_at`, `updated_at`) VALUES
(1, '0101001/001/10', 'ፅቡቅ', 'ጅግና እዩ', 'ነፃ እዩ', 'ፃዕራም', 'ፅቡቅ', 'ፅኑዕ', 'ፅቡቅ', 'ፅቡቅ', 'xxxx', 'xxx', 'xxx', 'dehan Xyu', 'xxxx', 'abcd', 'ዋይዋይዋይ', '10', '9', '8', '4', '1.5', '1', '1.5', '1.8', '10', '9', '13', '9', '9', 'ተቐቢለዮ ኣለኩ', '2018-11-14 20:51:21', '2018-11-14 20:51:21'),
(2, '0202002/002/10', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', 'd', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', '1', 'd', '2018-11-29 05:11:27', '2018-11-29 05:11:27');

-- --------------------------------------------------------

--
-- Table structure for table `tabias`
--

DROP TABLE IF EXISTS `tabias`;
CREATE TABLE IF NOT EXISTS `tabias` (
  `woredacode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tabiaName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `tabiaCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isUrban` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`tabiaCode`),
  KEY `tabias_woredacode_foreign` (`woredacode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tabias`
--

INSERT INTO `tabias` (`woredacode`, `tabiaName`, `tabiaCode`, `isUrban`, `created_at`, `updated_at`) VALUES
('01', 'ሞሞና', '001', 'ገጠር', '2017-11-09 04:47:18', '2018-11-28 06:13:40'),
('02', 'ማርቕስ', '002', 'ከተማ', '2017-11-09 04:47:50', '2017-11-09 04:47:50'),
('03', 'ዛታ ', '03', 'ከተማ', '2018-11-14 19:28:08', '2018-11-14 19:28:08'),
('03', 'ፋላ', '04', 'ገጠር', '2018-11-14 19:28:26', '2018-11-27 03:13:30'),
('06', 'የሓ', '07', 'ከተማ', '2018-11-14 19:29:51', '2018-11-14 19:29:51'),
('01', 'test', '0009', 'ከተማ', '2018-12-07 06:48:07', '2018-12-07 06:48:07'),
('01', 'delete', '8', 'ከተማ', '2018-11-28 16:17:14', '2018-11-28 16:17:14');

-- --------------------------------------------------------

--
-- Table structure for table `tara_members`
--

DROP TABLE IF EXISTS `tara_members`;
CREATE TABLE IF NOT EXISTS `tara_members` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `model` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `evaluation` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `tara_members_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tara_members`
--

INSERT INTO `tara_members` (`id`, `hitsuyID`, `model`, `evaluation`, `remark`, `created_at`, `updated_at`) VALUES
(3, '0101001/001/10', 'ሞዴል', 'B', 'fsdlfkjs', '2018-11-10 12:44:58', '2018-11-10 12:44:58'),
(7, '050607/010/11', 'ሞዴል', 'A', 'tsubuk', '2018-11-15 20:26:45', '2018-11-15 20:26:45'),
(8, '050607/010/11', 'ሞዴል', 'A', 'tsubuk', '2018-11-15 20:26:47', '2018-11-15 20:26:47'),
(10, '0101001/033/11', 'ሞዴል', 'A', 'this is great man', '2018-11-15 20:42:14', '2018-11-15 20:42:14'),
(14, '0101001/033/11', 'ሞዴል', 'B', 'fgwfsfgwgdeh3ry4jrkh3e4drh', '2018-11-15 20:49:14', '2018-11-15 20:49:14'),
(16, '0101001/006/11', 'ሞዴል', 'A', 'eti ztebhale neger kulu ysmamemelu eye', '2018-11-15 20:49:57', '2018-11-15 20:49:57'),
(17, '0101001/027/11', 'ሞዴል', 'B', 'ቀፅለሉ', '2018-11-15 20:50:08', '2018-11-15 20:50:08'),
(19, '0101001/033/11', 'ሞዴል', 'A', 'ተቀበቢለየዮ', '2018-11-15 20:51:42', '2018-11-15 20:51:42'),
(22, '0101001/001/10', 'ሞዴል', 'A', 'good ', '2018-11-15 20:51:48', '2018-11-15 20:51:48'),
(23, '0101001/027/11', 'ሞዴል', 'A', 'እቲ ተዋሂቡኒ ዘሎ ስርርዕ ተቀቢለዮ ኣለኩ', '2018-11-15 20:51:48', '2018-11-15 20:51:48'),
(24, '0101001/001/10', 'ሞዴል', 'A', 'good ', '2018-11-15 20:51:53', '2018-11-15 20:51:53'),
(27, '0101001/027/11', 'ሞዴል', 'A', 'ቅቡል እዩ', '2018-11-15 20:52:19', '2018-11-15 20:52:19'),
(30, '0101001/003/11', 'ዘይሞዴል', 'B', 'tqbilyo alku', '2018-11-15 20:54:37', '2018-11-15 20:54:37'),
(32, '0101001/003/11', 'ዘይሞዴል', 'B', 'sldkfj', '2018-11-29 15:00:39', '2018-11-29 15:00:39');

-- --------------------------------------------------------

--
-- Table structure for table `terminations`
--

DROP TABLE IF EXISTS `terminations`;
CREATE TABLE IF NOT EXISTS `terminations` (
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `proposedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approvedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `terminationDate` date NOT NULL,
  `isReported` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isApproved` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `top_leaders`
--

DROP TABLE IF EXISTS `top_leaders`;
CREATE TABLE IF NOT EXISTS `top_leaders` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `answer1` text COLLATE utf8_unicode_ci NOT NULL,
  `answer2` text COLLATE utf8_unicode_ci NOT NULL,
  `answer3` text COLLATE utf8_unicode_ci NOT NULL,
  `answer4` text COLLATE utf8_unicode_ci NOT NULL,
  `answer5` text COLLATE utf8_unicode_ci NOT NULL,
  `answer6` text COLLATE utf8_unicode_ci NOT NULL,
  `answer7` text COLLATE utf8_unicode_ci NOT NULL,
  `answer8` text COLLATE utf8_unicode_ci NOT NULL,
  `answer9` text COLLATE utf8_unicode_ci NOT NULL,
  `answer10` text COLLATE utf8_unicode_ci NOT NULL,
  `answer11` text COLLATE utf8_unicode_ci NOT NULL,
  `answer12` text COLLATE utf8_unicode_ci NOT NULL,
  `answer13` text COLLATE utf8_unicode_ci NOT NULL,
  `answer14` text COLLATE utf8_unicode_ci NOT NULL,
  `answer15` text COLLATE utf8_unicode_ci NOT NULL,
  `result1` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result2` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result3` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result4` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result5` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result6` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result7` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result8` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result9` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result10` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result11` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result12` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `result13` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `remark` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `top_leaders_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `training_settings`
--

DROP TABLE IF EXISTS `training_settings`;
CREATE TABLE IF NOT EXISTS `training_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `trainingname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `trainee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `traininglength` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `deadline` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `training_settings`
--

INSERT INTO `training_settings` (`id`, `trainingname`, `trainee`, `traininglength`, `deadline`, `created_at`, `updated_at`) VALUES
(1, 'ጀማሪ ኣመራርሓ ስልጠና', 'ተራ ኣባል', '3 ወርሒ', '2020-04-30', '2018-03-20 22:53:33', '2018-03-20 22:53:33'),
(2, 'ጀማሪ ኣመራርሓ ስልጠና', 'ሰብ ሞያ', '3 ወርሒ', '2020-04-30', '2018-03-20 22:53:53', '2018-03-20 22:53:53'),
(3, 'ታሕተዋይ ኣመራርሓ ስልጠና', 'ጀማሪ ኣመራርሓ', '4 ወርሒ', '2020-04-30', '2018-03-20 22:54:33', '2018-03-20 22:54:33'),
(4, 'ማእኸላይ ኣመራርሓ ስልጠና', 'ታሕተዋይ ኣመራርሓ', '3 ወርሒ', '2020-04-30', '2018-03-20 23:05:37', '2018-03-20 23:05:37'),
(5, 'ላዕለዋይ ኣመራርሓ ስልጠና', 'ማእኸላይ ኣመራርሓ', '4 ወርሒ', '2020-04-30', '2018-03-20 23:06:46', '2018-03-20 23:06:46'),
(6, 'ኣስድክፋ', 'ፍልስክድጅፍ', 'ፍስክልድፍ', '2020-03-20', '2018-11-16 17:24:36', '2018-11-16 17:24:36');

-- --------------------------------------------------------

--
-- Table structure for table `transfers`
--

DROP TABLE IF EXISTS `transfers`;
CREATE TABLE IF NOT EXISTS `transfers` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `committee` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `dereja` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `place` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `woreda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedWudabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignedWahio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldzone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldworeda` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldassignedWudabe` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `oldassignedWahio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `reason` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `assignment` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `office` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `transferedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `approvedBy` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `endDate` date NOT NULL,
  `isProposed` tinyint(1) NOT NULL,
  `approvedWudabe` tinyint(1) NOT NULL,
  `partyPos` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transfers_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `transfers`
--

INSERT INTO `transfers` (`id`, `hitsuyID`, `committee`, `dereja`, `place`, `zone`, `woreda`, `assignedWudabe`, `assignedWahio`, `oldzone`, `oldworeda`, `oldassignedWudabe`, `oldassignedWahio`, `reason`, `assignment`, `office`, `position`, `transferedBy`, `approvedBy`, `startDate`, `endDate`, `isProposed`, `approvedWudabe`, `partyPos`, `created_at`, `updated_at`) VALUES
(3, '050607/002/11', 'ወረዳ ኮሚቴ', 'ኣባል', 'ናይ ውድብ', '01', '01', '00101', '1', '05', '06', '0013', '5', 'ዕቤት', 'mmhr', 'betmhrti', 'drector', 'baelu', 'selam', '2011-03-02', '2011-03-17', 1, 1, 1, '2018-11-15 16:19:51', '2018-11-15 16:19:51'),
(5, '0101001/024/11', 'ወረዳ ኮሚቴ', 'ኣባል', 'ናይ ውድብ', '01', '01', '00101', '1', '01', '01', '00101', '2', 'ቕፅዓት', 'ገሀ', 'ሀሀ', 'ከጀየተ', 'ሀገ', 'bob', '2011-03-11', '2011-03-20', 1, 1, 1, '2018-11-15 16:57:35', '2018-12-09 04:21:18'),
(7, '0101001/024/11', 'ጣብያ ኮሚቴ', 'ኣባል', 'ናይ ውድብ', '02', '02', '00102', '2', '01', '01', '00101', '1', 'ናይ ኣባል ሕቶ(ማሕበራዊ)', 'ict', 'fthi', 'moya', 'tadese', 'hagos', '2011-03-02', '2011-03-05', 1, 1, 1, '2018-11-15 17:21:59', '2018-11-15 17:21:59');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `firstname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `lastname` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `usertype` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'staff',
  `image` varchar(255) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'avatar.png',
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=94 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstname`, `lastname`, `email`, `password`, `usertype`, `image`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tewodros', 'Weldebirhan', 'tewdrosw@tplf.com', '$2y$10$mHgFnqBl986sPjjJTusH4egBjRBJtmngV3m.haIkQtDWTBi1r9KRm', 'admin', 'avatar.png', 'v37ZSSxhqhABKmhREk52bbzCX8luJ9xQdGvMbXP8aky8MiObMI55lbdTa2Xb', '2017-11-09 04:44:26', '2018-11-13 20:09:56'),
(2, 'ኣበበ', 'ከበደ', 'admin@admin.com', '$2y$10$nDRImKPozzImatfP2clyTu8p6Pvqj7e.s1mbY9AMgLNAVavGreyF6', 'admin', 'avatar.png', 'LBXmVk2g1DFyooe8DM3bQYE2oJwIsXXa3fqnC32neh8xt3WzSH56KyLqCUn7', '2018-09-13 17:00:56', '2018-12-08 16:31:10'),
(6, 'ab', 'cd', 'a@b.com', '$2y$10$FArIk58.UXjICluviocOb.b/U2TeTZslPI2j7r80hQJwOx6OupsnC', 'management', 'avatar.png', 'agzBznW5k8qa4niNhfwmGhDtF7uEoKnw8nUG7VT6fWlcLdgzxC67J9JxkCBT', '2018-11-12 16:00:35', '2018-11-25 09:20:47'),
(7, 'Selam', 'Kebede', 'selam@gmail.com', '$2y$10$eoFULqRK5IY5RRMjr2To/eyGQb7ANUiEmpp.eOIkgd0qNV/Q7LoJO', 'staff', 'avatar.png', 'W5BIA2HPlNI8vICcElUyYxKkpxFynXEw7bT7HQGsN596yYZbTh51d7Z0m2ZY', '2018-11-14 14:27:16', '2018-11-14 14:31:18'),
(8, 'telweyn ', 'hal', 'teki12e@gmial.com', '$2y$10$4AZl5ZYS7SjSV0DyDV4ONeLJdVolAFyRMECw9B8iCv28E4A9ABLYe', 'staff', '20754.jpg', NULL, '2018-11-14 16:14:23', '2018-11-14 17:09:23'),
(9, 'sinkey', 'girmay', 'sinkey@gmail.com', '$2y$10$Q6K9PvRomEPHbP1W3Mv6huRzzPLupV6K1cw.OwqNGEdzM4jKS.9wu', 'staff', '23290.jpg', 'R6RvWLcdZZ5Prrq8QiWVK2XfFhKAoVRFo7iGw77qgsYGO9SnNYPQ1Jtd3Ad6', '2018-11-14 16:19:16', '2018-11-15 16:32:32'),
(10, 'freselam', 'berhe', 'rahwa@gmail.com', '$2y$10$wCO0d1LVIaEj9xOMP0qb3eeH94VM/MDgtSuUS5qSG6mYKLW/Y.5mS', 'staff', '10417.jpg', 'vpL1GNvW0ZUZftfP9ZxqcXnHGLTU98gKXmjkXPNMgmbA6JWftts86x0Srv6s', '2018-11-14 16:19:31', '2018-11-14 17:32:27'),
(11, 'Brkti', 'Gebregzabiher', 'BakiGg2127@gmail.com', '$2y$10$Z.xuqoM2mEOiwT2pJ.7AG.jhrGIWosVLn6CfAjfAB.hpEAhj7H9kO', 'staff', '17103.jpg', NULL, '2018-11-14 16:21:47', '2018-11-14 17:12:32'),
(12, 'mercy', 'hadush', 'hmercy05@gmail.com', '$2y$10$O/DCSx.Cq73R2KT5v7t3rOcZDq8Mqk57vFHRWSOI.NIBKH8H3wQ4.', 'staff', '7523.jpg', 'GK5af6iaCRuQmGlqvuxIfMFxWvmq9BgVHEy4vdGTk3hvEBdkeF7FShIGjHrR', '2018-11-14 16:22:21', '2018-11-14 20:16:00'),
(13, 'letay', 'mesfin', 'letaymesfin@gmail.com', '$2y$10$0vO/0QxXBDAFSJJD..uqR.JcJFFhUMtEPleveEBceBOsoJGKHPOEm', 'staff', '79.jpg', '0rOjRX3PMZeMPwXnNY4xHG9HZIQw4rR81TR8nQiQdtFo5di1by7yM0D60KR7', '2018-11-14 16:22:39', '2018-11-14 21:33:50'),
(14, 'yrga', 'abera', '1980tplf@gmail.com', '$2y$10$74T9NxzpIQWmqo0EfHXj/u.z6eyfVmjH1wxTwmLfKM7KBAQBMbKde', 'staff', 'avatar.png', NULL, '2018-11-14 16:24:15', '2018-11-14 16:24:15'),
(15, 'solomon', 'temam', 'solomon@gmail.com', '$2y$10$xJAUnPKdLpHVWUn9GCrs4eHBMHBGjesbEETn/rDiBaSdEOz/sbG7e', 'staff', 'avatar.png', 'z1cjFHgMFZd2Kto9dSJ6zFS1m36rC9UoraB9nhMgqdy364pTTPoMxOcyaUYq', '2018-11-14 16:26:25', '2018-11-14 21:37:59'),
(16, 'tekit', 'hailu', 'hatekel@gmail.com', '$2y$10$C4lOYWw5MEV8r.r48dB0zOHuOJJz7Mo1s9txuPX1vskRHNRMuxJLW', 'staff', 'avatar.png', NULL, '2018-11-14 16:27:40', '2018-11-14 16:27:40'),
(17, 'brhane', 'aregawi', 'brhanear13@gmail.com', '$2y$10$rOHF6GqL3N0.bxIVyM9rvumO0qNG/t5j1AePQeaybMaXjVSQmNI/m', 'staff', '26168.jpg', NULL, '2018-11-14 16:27:41', '2018-11-14 16:31:02'),
(18, 'alemtsehay ', 'assefa', 'alem@gmail.com', '$2y$10$G7IRqAEDAK8LnZOpPAaG3.ZeZoyoryQfdcJO2GD8rz2HXtYUDdJn2', 'staff', '7401.jpg', 'CTGVaD5RUbQTrt5euW1JaT0wCucGZTbie3kEceypCU0tPUAf0UocghreIXtO', '2018-11-14 16:27:42', '2018-11-14 17:11:41'),
(19, 'brhane', 'berhe', 'brhaneberhe@gmail.com', '$2y$10$K/3vmiXOhBOIEpxWhomhiOsMzRB.938tkZ.LIgF35vnnRiaTirVjS', 'staff', 'avatar.png', 'gU8AvdNtZfHJZDXEkRQ9XrccifxN7CeIta5mK81l3G39Qx9e2qEbcmHj9lqR', '2018-11-14 16:28:45', '2018-11-15 16:15:00'),
(20, 'tsehayansh', 'kahsay', 'tsehaynsh@jmaill.com', '$2y$10$1GOOhackT2wmle9TCnINp.S5.mV8zo5JCnwcIGrwbUndfvncuPhfS', 'staff', 'avatar.png', NULL, '2018-11-14 16:28:59', '2018-11-14 16:28:59'),
(21, 'Getachew', 'Bllo', 'Getachewbllo@gmail.com', '$2y$10$WRn9lZwOFEEhNrNB8ugzz.22CzVHIrES20O3LMb2bWVjrahrsoSTy', 'staff', 'avatar.png', NULL, '2018-11-14 16:30:37', '2018-11-14 16:30:37'),
(22, 'meaza', 'gidey', 'gideymeaza@yahoo.com', '$2y$10$MchJY79IePp3SkJRI01BHujRHktB4boVxTNIw5EGH4/UV5p3Lrf/C', 'staff', 'avatar.png', 'y5ToLgzBacLEti9w2rFN5de5UJ1M7TY7PjuZbRQHRBwZIXcQI6kO0H8tyq9z', '2018-11-14 16:37:51', '2018-11-14 16:44:10'),
(23, 'gbrkiros', 'mersa', 'gbrekiros@gmail.com', '$2y$10$jyOI2Ok4qr25nJcM9XZaJeAOWS9zgiF8FjoZwn93qzu1kRqUU/P9a', 'staff', 'avatar.png', NULL, '2018-11-14 16:38:05', '2018-11-14 16:38:05'),
(24, 'g/kidan ', 'welensea', 'humera2011@gmail.com', '$2y$10$28OsAaDp2YMPYW5ciqQkVOQ1OeJJ5LNm5WFlgUjTeZ1Hw24h4TFKq', 'staff', 'avatar.png', NULL, '2018-11-14 16:42:56', '2018-11-14 16:42:56'),
(25, 'slshi', 'shimuye', 'sleshishimuye@giaml.com', '$2y$10$Q2XYu/ubbZ9ZsrNJtlrHg.QeETBi8L1J3dO19StAvPkpY.Ny.cTlK', 'staff', 'avatar.png', 'rhId9c7b2wQdExzhjq2sycbGVncpLCYz8QyMLwWAJxVsy6soFalpHmt1FOpq', '2018-11-14 16:43:44', '2018-11-14 17:15:18'),
(26, 'yordanos', 'tsehaye', 'yordanos.tsehaye@gmail.com', '$2y$10$sGjWLW5CsQgi3EoT/6Tri.JJvtadnX7zCnPt.wQLcQKTvP5inTkPC', 'staff', 'avatar.png', NULL, '2018-11-14 16:49:40', '2018-11-14 16:49:40'),
(27, 'mebrat', 'ambaye', 'ambayemebrat@yahoo.com', '$2y$10$Spt7hqG9EuN4nKifxpXj.e1yGDrA4aGAksv1pw8Vehud3SnxQeY3G', 'staff', 'avatar.png', NULL, '2018-11-14 16:53:36', '2018-11-14 16:53:36'),
(28, 'abebe', 'kebede', 'abebe.kebede@gmail.com', '$2y$10$mNMcWAQXmLR6MWeC6/Arle0jZzi16CiPUoMfkI2nhh3sodIhs6A4G', 'staff', 'avatar.png', 'QhWOS3IUxcVuC1Ie2o5uL0DZHuxQIrGcvqnAdnC4409oVs0HS4uXstPEa2oi', '2018-11-14 16:56:19', '2018-11-14 17:02:22'),
(29, 'etenesh', 'tesfay', 'eteneshtesfay@gmail.com', '$2y$10$6yqco3fjjTHfEjTpyRwxvO.PDI0UnKYnN0g93ahKBLgXKMrKVMLp6', 'staff', 'avatar.png', NULL, '2018-11-14 17:00:31', '2018-11-14 17:00:31'),
(30, 'fantanesh', 'meresa', 'fantaneshmeresa@gmail.com', '$2y$10$zFfExBG3VzdqeP5LS555yO./efRzuY6mxiB/dIw1MS3VF3Hht9jua', 'staff', 'avatar.png', NULL, '2018-11-14 17:01:17', '2018-11-14 17:01:17'),
(31, 'ክብርቲ', 'ብርሃነ', 'kibrtibirhane@gmial.com', '$2y$10$q1twODyCnxWwt4snh1o4uuw7vJwl8UKox4VXN4Sls792kAbkzcsxm', 'staff', 'avatar.png', NULL, '2018-11-14 17:02:51', '2018-11-14 17:02:51'),
(32, 'rahel ', 'g/maryam', 'rahelg/maryam@gmail.com', '$2y$10$PZ9xM.mzmoVQ7Ia5jvt.LOPH07B24fGirewF.cqCLQgeFN.KGnttO', 'staff', 'avatar.png', 'E2p6NEQoTxjxZIjs6j4mGk5pI18Am6yVH8g9YYA0DKj2duIFskvMtbqqwmKE', '2018-11-14 17:02:57', '2018-11-15 17:04:51'),
(33, 'ገብረሀሂወት', 'ገረዝገሄር', 'gbrhiwoT@gmial.com', '$2y$10$0LV/Xvn6UIlLG1H1hUp2ZuKfabp1nqDADDopSohFQ84H8VepjOOpa', 'staff', 'avatar.png', NULL, '2018-11-14 17:03:37', '2018-11-14 17:03:37'),
(34, 'etenesh', 'tesfay', 'etenesh.tesfay@gmail.com', '$2y$10$ztSaFO9lQeOASKS4bVlu7e9rfOwZQpVRvSgbw/Fm0MBUZs/qxKznC', 'staff', 'avatar.png', NULL, '2018-11-14 17:04:41', '2018-11-14 17:04:41'),
(35, 'Haftu', 'Abebe', 'haftuabebe@gmai.com', '$2y$10$MeU.xcJxfDDtZWRYWby1vOmB9e1Yvx.Mjx7rsS8O/3tN/4ufA0fZW', 'staff', 'avatar.png', 'Wwv9wKTfeOec5Rn8fy6KnAmwEt09GLyrVTotGuL6L3hA4zhF8lzJmVrKoyrM', '2018-11-14 17:04:59', '2018-11-14 17:06:32'),
(36, 'Brhane', 'Mezgebo', 'Brhane@gmail.com', '$2y$10$AOR0oQUl8LFXnYRoU6NqZubboGB7el.GizFxAhpAa.ZOB1RHZPGcW', 'staff', 'avatar.png', NULL, '2018-11-14 17:06:49', '2018-11-14 17:06:49'),
(37, 'molla', 'berihun', 'mollaberihunabay@gmail.com', '$2y$10$iqQ1saLfnHb0cFDZSetSZOdZfRHTGD3r7C5JgxORn7cett1xFA.y6', 'staff', 'avatar.png', NULL, '2018-11-14 17:07:46', '2018-11-14 17:07:46'),
(38, 'brhane', 'aregawi', 'brhaneare13@gmail.com', '$2y$10$S5p8o/aXeWUrOxAQYktQy.RnT5DhxssS1/dffkujNBXZCxmyAJQvy', 'staff', '3763.jpg', 'fkeSqtwXKOJo8bQGg7r2yhA7WZp5qKeNXu07RYgxAHg4pQ2E0p34cMix6NiO', '2018-11-14 17:10:45', '2018-11-14 21:47:05'),
(39, 'ወ/ማሪያም', 'ገ/ዋህድ', 'weldemaryam.gwahid@gmail.com', '$2y$10$xLtO00vKSgEg7voU3lb4WuqXwjq.7kX6TTeTyhpaRas46iuvkcdVu', 'staff', 'avatar.png', NULL, '2018-11-14 17:11:44', '2018-11-14 17:11:44'),
(40, ' አረጋዊ', 'ገብሩ', 'aregawigebru@gmail.com', '$2y$10$jpWPP7gldXdmOJbNqr0F6OnNpqAdU7KbG3Wny4tvH.c8id5QDxrlq', 'staff', 'avatar.png', NULL, '2018-11-14 17:13:49', '2018-11-14 17:13:49'),
(41, 'haben', 'gebremichael', 'habengebre21@gmail.com', '$2y$10$WX1nprWXhnPPIxLRS1cZi.r6fGgitGaVxiVM97I7lw7DrC3aDjxnS', 'staff', '31856.jpg', 'y3LO0iThcRYGLnJqYtQeKw5XVGDwTLf31LH4I0BCHxXPV5f4Ny1DV9jzuEfN', '2018-11-14 17:14:30', '2018-11-15 16:04:40'),
(42, 'welay', 'meresa', 'kbwelaymeresa@gimail.com', '$2y$10$nQb24Lkacw6e5peY4M3EruVM1hxw7.LAhSDRDZBLOs9Z277SrIg8O', 'staff', 'avatar.png', NULL, '2018-11-14 17:15:30', '2018-11-14 17:15:30'),
(43, 'yohans', 'kidanu', 'yowhanskidanu@gmail.com', '$2y$10$WU73UNg1Wxb5hVfqL2kw5OFoNzZd08uOBE8qoILgJpw0pjTiMncE6', 'staff', 'avatar.png', NULL, '2018-11-14 17:16:26', '2018-11-14 17:16:26'),
(44, 'cherkos', 'welday', 'gebre@gmail.com', '$2y$10$Xz5OMJQ8gQQEeKmN.nSO9uQkNKoELHHcCGXhWSPcIRlMOsSVz06nC', 'staff', 'avatar.png', NULL, '2018-11-14 17:19:55', '2018-11-14 17:19:55'),
(45, 'ንግስቲ', 'ንጋቱ', 'Nigist.nigatu@gmail.com', '$2y$10$oxVsNczSXAegaP9g9cEJS.kHma38vj2Q1YrhlZMSbLgG8cQ8sXJE6', 'staff', 'avatar.png', NULL, '2018-11-14 17:25:11', '2018-11-14 17:25:11'),
(46, 'hailu', 'degefa', 'hailu.degefa2123@gmail.com', '$2y$10$bD3pfl01x1Uo0qVU6YSxMOswo/4zmLmCLHqrOsh4QCnbEGQnbGAm.', 'staff', 'avatar.png', NULL, '2018-11-14 17:25:42', '2018-11-14 17:25:42'),
(47, 'saba ', 'tkaly', 'saba@gmail.com', '$2y$10$PEnolCThT.aABTy2f1wJ/Oy2XvEjpOT95U27eZGRfjqqiG/ombtum', 'staff', 'avatar.png', NULL, '2018-11-14 17:33:07', '2018-11-14 17:33:07'),
(48, 'freselam', 'berhe', 'freselaberhe@gmail.com', '$2y$10$YpMwxMs0ynkdcqmkvn7theUm21eG.1n69uXeG3jtXI18eO5hhUfQa', 'staff', '17214.jpg', 'VsCGHIU2mpt8VLFBbrrg6bnWvvjBJkTE94J43cccUc66LjhcQxOmGsM4ts7T', '2018-11-14 17:34:54', '2018-11-14 21:30:18'),
(49, 'Getachew', 'Bllo', 'Getachew37@gmail.com', '$2y$10$iBrlbiUIies2O0ERX5R4kO2JLb5lmssRrBhE5BX/8XuIhYQbcxLuy', 'management', 'avatar.png', 'ESCaDAtbToqFPdoGLy1xLr17rLuBN14SgW5YlcKiGMSOYXGaG0OHMZZLO5k1', '2018-11-14 20:17:32', '2018-11-15 16:39:37'),
(50, 'teki', 'hal', 'teki12e@gmail.com', '$2y$10$Dsud14ZOK9xs2YGvp/qfCOR8l.UseGe1HCtSq7LQQ9tQMyyT9v3Za', 'staff', '13364.jpg', NULL, '2018-11-14 20:18:15', '2018-11-15 16:28:47'),
(51, 'cherkos', 'welday', 'gebrea@gmail.com', '$2y$10$19.iwNszLYfAcOxj9ba5WexI2.bgmaQ1x/HSbIbDxtVC0SmSI0ecq', 'staff', 'avatar.png', NULL, '2018-11-14 20:18:20', '2018-11-14 20:18:20'),
(52, 'lemlem', 'berhe', 'lemlemberhe12@gmail.com', '$2y$10$g/eMRuulOiPZAuiyBe7pruLwdu32PmVFNqCcAc.Bly9IJic7qiz3a', 'staff', '10976.jpg', NULL, '2018-11-14 20:19:50', '2018-11-14 21:02:54'),
(53, 'Gebrekiros', 'Meresa', 'Gebrekiros@gmail.com', '$2y$10$WxB9uRke9NR5O3JBLcOfzeXaEUOWV1mdvyJSOlivC/x7ri3REZUPm', 'staff', 'avatar.png', NULL, '2018-11-14 20:20:48', '2018-11-14 20:20:48'),
(54, 'ሳባ', 'ተከላይ', 'sabatklay@gmail.com', '$2y$10$ACOy4Ll5UdZsYCSRZTywZ.3XIKvfMVSoE2ONqp/BXufbP.KKcmDFy', 'staff', 'avatar.png', NULL, '2018-11-14 20:22:45', '2018-11-14 20:22:45'),
(55, 'abebe', 'hailu', 'abebeh@gmail.com', '$2y$10$4ZeFN3VgKDppQultiZU05u82L2UTUlxPjEYHy57XewFPM5q0jh9nC', 'staff', '8348.jpg', NULL, '2018-11-14 20:23:52', '2018-11-14 20:25:39'),
(56, 'Selam', 'Desalegn', 'selamdesalegn@gmail.com', '$2y$10$y3kS/OYr0FSyqpMvOYBNMula2eo.7UbnBOH9kCEiWZDDvgT3PC4wC', 'staff', 'avatar.png', NULL, '2018-11-14 20:24:35', '2018-11-14 20:24:35'),
(57, 'tsehayansh', 'kahsay', 'tsehaynash@gaimii.com', '$2y$10$4EksSof2XyqEqdIPqDUgnup0t1XqDmaYAPugfZHDLClDvfJGNs6Oa', 'staff', 'avatar.png', NULL, '2018-11-14 20:27:25', '2018-11-14 20:27:25'),
(58, 'yrga', 'abera', '1988tplf@gmail.com', '$2y$10$4K2fn.vzENZdqqy93GjDOu9fVvSZ2IrRHHjxZIMej2BjW0r1wKptC', 'staff', 'avatar.png', NULL, '2018-11-14 20:27:30', '2018-11-14 20:27:30'),
(59, 'gbrhiwot', 'grzgiher', 'gbrhiwoTgrzgihr@gmial.com', '$2y$10$KLRjQ0cT7ZaS8VYTK7TIl.F8b8y9c4J2kj1hJUa0V2TQ26n6H2L3i', 'staff', 'avatar.png', NULL, '2018-11-14 20:27:48', '2018-11-14 20:27:48'),
(60, 'gbrhiwot', 'grzgiher', 'gbrhiworgrzgihr@gmial.com', '$2y$10$bzsbuVhg3RYboAfbhJpkVut0Qxl0Ea2gO2uIcr8f0AcLROJq0Wo4u', 'staff', 'avatar.png', NULL, '2018-11-14 20:29:20', '2018-11-14 20:29:20'),
(61, 'mizan', 'abrha', 'mizanabrha@gmail.com', '$2y$10$hga5.Q/ZH8/fk1AXuVksVOYKtxpHwvWPPcsTFFI.gS1cGre5LO.We', 'staff', 'avatar.png', NULL, '2018-11-14 20:46:59', '2018-11-14 20:46:59'),
(62, 'fantu', 'meresa', 'fantanesh.meresa@gmail.com', '$2y$10$OpSeegr3ZSygXiLxyzQGHe76uMBN7CxnBbn4QzpqBwXw9xMQlC4Bu', 'staff', 'avatar.png', NULL, '2018-11-14 20:48:46', '2018-11-14 20:48:46'),
(63, 'yrga', 'abera', '1980tplff@gmail.com', '$2y$10$FTBZ5c.ElVpfdWpVdSaTXeH/9Xsg0I5gZUmtDNiwsLbKEMLslmaF6', 'staff', 'avatar.png', NULL, '2018-11-14 20:51:52', '2018-11-14 20:51:52'),
(64, 'welay', 'meresa', 'welaymeresa@gimail.com', '$2y$10$j23xkzR6Zp/dtn/Ygz7Kl.ZBseTz8dzNtDzyYlYc34k2snbw/1XoG', 'staff', 'avatar.png', NULL, '2018-11-14 20:54:50', '2018-11-14 20:54:50'),
(65, 'ገ/ዚሄር', 'ሐጎስ', 'g/herhags@gmail.com', '$2y$10$7D3YJITV6iH70Hjq2d9pJeSpzw/.FGcCxpX7LKoArPRt3pgPfGsBa', 'staff', 'avatar.png', NULL, '2018-11-14 21:23:58', '2018-11-14 21:23:58'),
(66, 'algansh', 'grezgiher', 'algansh@gmail.com', '$2y$10$dl473bz96s0d4RjrAgPcfuFPuh7AFloGe6C/06i7FcPU576RUB.3C', 'staff', 'avatar.png', NULL, '2018-11-14 21:26:38', '2018-11-14 21:26:38'),
(67, 'Yohans', 'Kidanu', 'hohans@gmail.com', '$2y$10$NPxE7JC2XbHf/NgJ.7l4lu4uL2XwaLJjRkr4ZRBVrOBsxWeX9dVHi', 'staff', 'avatar.png', NULL, '2018-11-14 21:31:52', '2018-11-14 21:31:52'),
(68, 'negasi', 'gbre', 'gebre2011@gmaill.com', '$2y$10$/tOMTLuKNq/I9yZdq0h2hOogslzJdgKhavyvVZyi5EMj6p5oPirGu', 'staff', 'avatar.png', NULL, '2018-11-14 22:05:23', '2018-11-14 22:05:23'),
(69, 'yohans', 'kidanu', 'yohans@gmail.com', '$2y$10$nU0LoLGPMBuGYU5RUlSltOnVllQIGgY8eoI/bjMEVeGDn6n/4PjRC', 'staff', 'avatar.png', NULL, '2018-11-15 16:01:58', '2018-11-15 16:01:58'),
(70, 'Zed', 'Moke', 'moke@gmail.com', '$2y$10$hjP9wIJHrH72HYFctUKRh.ipfPMrdlxtat9TTI0QLQAdogUn2brW6', 'staff', 'avatar.png', 'wqYG9lL03jd0oLuDOrK1G6gepsWMfxN7W0YcBlXPIJJMSsG0CSyalc6pN8Jz', '2018-11-15 16:03:27', '2018-11-15 16:39:32'),
(71, 'embetu', 'alemayehu', 'embetualemayehu6@gmail.com', '$2y$10$x7IQ9D.x569tc722TgGr8uxW7cT.rih8MMgiRYBWlR.4VxsNKKlBu', 'staff', 'avatar.png', NULL, '2018-11-15 16:04:11', '2018-11-15 16:04:11'),
(72, 'ክብርቲ', 'ብርሃነ', 'kibrtbirhane@gmail.com', '$2y$10$JfX1t0tdonw5JEs0fXHG6OEiXAF7J89x11njXJewLUBzZMaEEC7xq', 'staff', 'avatar.png', NULL, '2018-11-15 16:04:30', '2018-11-15 16:04:30'),
(73, 'yrga', 'abera', 'yirgaabera1988@gmail.com', '$2y$10$HLngOjsyyiRLJdkyrPSX..pkUa1oECb9RG/bv2u/idlqsyJRxchqK', 'staff', 'avatar.png', NULL, '2018-11-15 16:07:28', '2018-11-15 16:07:28'),
(74, 'sirak', 'selemon', 'sirak@gmail.com', '$2y$10$PNtYL6w7wOFefc5bsdEoFugMOkQAK46PtDBAuDlebKqrvp/RApod6', 'staff', 'avatar.png', NULL, '2018-11-15 16:08:22', '2018-11-15 16:08:22'),
(75, 'tsehayansh', 'kahsu', 'tsehay1212@gmail.com', '$2y$10$eMnDQC3Yydh8Oi9EyP/upes6pAkboeu9RHFBzV6n9XxGpCwu.mjau', 'management', 'avatar.png', '4DJS7qSO3abTsDDcpVDcTwkgunvKhf30SO1SzdXDpsiHthpzdWzZkXZIeLWP', '2018-11-15 16:17:04', '2018-11-15 17:17:49'),
(76, 'gidey', 'mesfun', 'gidey74@gmail.com', '$2y$10$W9lu.gChLN/Kdbyn2kpbiex.0jhv.3hsl.BI5EQfngqUrK/CIGjZG', 'staff', 'avatar.png', NULL, '2018-11-15 16:31:01', '2018-11-15 16:31:01'),
(77, 'mikiale', 'mezgebo', 'mikiale@gmail.com', '$2y$10$EuObkWClRXZ4Fn/CYAnw/OtYM/9PYW4BmYeOolGNRVS6Me.vB7uIi', 'staff', 'avatar.png', NULL, '2018-11-15 16:31:07', '2018-11-15 16:31:07'),
(78, 'fantanesh', 'meresa', 'fantaneshsmeresa@gmail.com', '$2y$10$gefDRy2xcxaIQwkri9y3bemZu7AMJh/RJ7HH64tUUxgTtptHydaRS', 'staff', 'avatar.png', NULL, '2018-11-15 16:36:01', '2018-11-15 16:36:01'),
(79, 'Getachew', 'Bllo', 'Getachewb37@gmail.com', '$2y$10$88WGFjuv.zxWQW.YN6r0aecVGie38iAsc8g8vtO5iOAr36NXLO/7u', 'staff', '26979.jpg', 'vhKCAUKxqvfeRF3fHsbEx7F2PcElBE8CWrp8JkIEmkZte7xNx8Hf27V7qozS', '2018-11-15 16:41:39', '2018-11-15 21:22:43'),
(80, 'tsehayy', 'kahsuu', 'tsehayy12@gmail.com', '$2y$10$iVEM32xWnw/CcUlLAaAJc.vwplIxzx/6Do2wuLrKqmXxaGF.V..66', 'staff', 'avatar.png', NULL, '2018-11-15 17:22:16', '2018-11-15 17:22:16'),
(81, 'tsehayy', 'kahsuu', 'tsehayy12@gmill.con', '$2y$10$WneAlPqB0P/uasCx9vtao.rn84updY/3P4UXLH3WxyqKaWu2q0DJa', 'staff', 'avatar.png', NULL, '2018-11-15 19:30:23', '2018-11-15 19:30:23'),
(82, 'ሳባ', 'ተከላይ', 'SABATKalY@gmail.com', '$2y$10$u1WW2s5g6W3M5Pr6sjCf1udnDcdGQzetSH3n5dPCl.rMj4Mi2dMd6', 'staff', 'avatar.png', NULL, '2018-11-15 19:31:14', '2018-11-15 19:31:14'),
(83, 'tesfay', 'teka', 'tesfayteka@gmail.com', '$2y$10$Cea.bSA9Gnsua2/hUZug8.j2wE4XUt1rkH1i7ZhFolJEGSBDB3u.S', 'staff', 'avatar.png', NULL, '2018-11-15 19:32:45', '2018-11-15 19:32:45'),
(84, 'gkk', 'welu', 'gwww@gmail.com', '$2y$10$dAqW075JMSqfcgd9RB0SY.lkod0vBv3WmUdpMGIIRROKoiRJ1LzC2', 'staff', 'avatar.png', NULL, '2018-11-15 19:35:05', '2018-11-15 19:35:05'),
(85, 'tek', 'hai', 'teklit@gmail.com', '$2y$10$6oIoU5hJGelBOMwyRs6e.O4A8f6LxqjSVkGr9o7rzjMoz2JrZE6rO', 'staff', 'avatar.png', NULL, '2018-11-15 19:35:41', '2018-11-15 19:35:41'),
(86, 'ሓዳስ ', 'ሓጎስ', 'hadshags@gmail.com', '$2y$10$ldHqzpOwHCj9j/BAwBhpd.frosY0s4QlZ3aVRqN6h7yRoQBa1z64i', 'staff', 'avatar.png', NULL, '2018-11-15 20:23:38', '2018-11-15 20:23:38'),
(87, 'lemlem', 'berhe', 'lemlemberhe06@gmail.com', '$2y$10$RTvhB/rLGZpRKNW0tlwU1.b/uGWqQqWdmtaEb0PG9rbA8XT1TnpC.', 'staff', 'avatar.png', NULL, '2018-11-15 20:28:32', '2018-11-15 20:28:32'),
(88, 'fantanesh', 'meresa', 'fantanesh.meresa@mail.com', '$2y$10$SX74yJvSPhB6FZM6fLpbte2dNan/Pi8Wq2o3BqskedxyfmMmpSOGe', 'staff', 'avatar.png', NULL, '2018-11-15 20:32:10', '2018-11-15 20:32:10'),
(89, 'meazi', 'Tsgie', 'meazitsgie@gmail.com', '$2y$10$106eTh24w04ktcCej5foz.qypVZH3vAbsCuFkZr86Fw5gR0jYxXiW', 'admin', 'avatar.png', NULL, '2018-11-15 20:32:29', '2018-11-15 20:32:29'),
(90, 'lemlem', 'berhe', 'lemlemberhe@gmail.com', '$2y$10$27esDc6YI0/oy0V3LKIy2OTstTTTmxlmrAyr12HysDDYPWJs1BPGS', 'staff', 'avatar.png', NULL, '2018-11-15 20:33:15', '2018-11-15 20:33:15'),
(91, 'Gebru', 'Adhanom', 'goitsh21@gimail.com', '$2y$10$DnZnmB2mtNqFP1lp0ATyX.mL9yu.jugVt9q89PyzAj7Poi5H0TW3G', 'staff', 'avatar.png', NULL, '2018-11-15 20:33:46', '2018-11-15 20:33:46'),
(92, 'selam', 'tesfay', 'selesweet21@gmail.com', '$2y$10$bZyGO0AJAW6aiClNpW6y5urS.Xs71J0BYN.RXmnO36HRll8HF6qvC', 'staff', 'avatar.png', NULL, '2018-11-15 20:35:04', '2018-11-15 20:35:04'),
(93, 'ብርሀሃነ', 'መሐረሪ', 'brhan@gmail.com', '$2y$10$FcwDmnwLBocp8fDZrRoME.xhFgyHhwliH8zTGhN8AZ7Mws5b3LY.C', 'staff', 'avatar.png', NULL, '2018-11-15 20:36:31', '2018-11-15 20:36:31');

-- --------------------------------------------------------

--
-- Table structure for table `wahios`
--

DROP TABLE IF EXISTS `wahios`;
CREATE TABLE IF NOT EXISTS `wahios` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `wahioName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `widabeCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `wahios_widabecode_foreign` (`widabeCode`)
) ENGINE=MyISAM AUTO_INCREMENT=12 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `wahios`
--

INSERT INTO `wahios` (`id`, `wahioName`, `widabeCode`, `created_at`, `updated_at`) VALUES
(1, 'መለስ ጀግና', '00101', '2017-11-09 04:49:12', '2018-11-28 15:55:55'),
(2, 'ኣባይ ጀግና', '00102', '2017-11-09 04:49:29', '2017-11-09 04:49:29'),
(3, 'መሰረት', '0012', '2018-11-14 19:41:55', '2018-11-14 19:41:55'),
(4, 'ዓወት ንሓፋሽ', '0112', '2018-11-14 19:42:49', '2018-11-14 19:42:49'),
(5, 'ልምዓታዊ', '0013', '2018-11-14 19:43:27', '2018-11-14 19:43:27');

-- --------------------------------------------------------

--
-- Table structure for table `woredaplans`
--

DROP TABLE IF EXISTS `woredaplans`;
CREATE TABLE IF NOT EXISTS `woredaplans` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `woredacode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `planyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descrpt` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `woredaplans`
--

INSERT INTO `woredaplans` (`id`, `woredacode`, `planyear`, `plantype`, `amount`, `descrpt`, `created_at`, `updated_at`) VALUES
(1, '01', '2011', 'ጠርነፍቲ መ/ውዳበ ዋህዮ', '30', 'መብርሂ', '2018-11-11 07:42:13', '2018-11-25 08:57:55'),
(6, '02', '2010', 'ነበርቲ ተራ ኣባላት', '20', 'slkdfa', '2018-11-11 07:48:10', '2018-11-11 07:48:10'),
(7, '06', '2011', 'ነበርቲ ተራ ኣባላት', '100000', 'plan 2011 ferest qurter', '2018-11-15 17:07:29', '2018-11-15 17:07:29'),
(8, '06', '2011', 'ነበርቲ ተራ ኣባላት', '100000', 'plan 2011 ferest qurter', '2018-11-15 17:07:30', '2018-11-15 17:07:30'),
(9, '05', '2011', 'ናይ ሰብ ሞያ', '180', 'plan 2011 1st መፋርቕ', '2018-11-15 17:08:42', '2018-11-25 08:58:12');

-- --------------------------------------------------------

--
-- Table structure for table `woredas`
--

DROP TABLE IF EXISTS `woredas`;
CREATE TABLE IF NOT EXISTS `woredas` (
  `zoneCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `woredacode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `isUrban` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`woredacode`),
  KEY `woredas_zonecode_foreign` (`zoneCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `woredas`
--

INSERT INTO `woredas` (`zoneCode`, `woredacode`, `name`, `isUrban`, `created_at`, `updated_at`) VALUES
('01', '01', 'ሓድነት', 'ከተማ', '2017-11-09 04:46:26', '2018-12-07 14:51:54'),
('02', '04', 'አላማጣ', 'ከተማ', '2018-11-14 19:23:38', '2018-11-14 19:23:38'),
('02', '02', 'ኮረም', 'ከተማ', '2018-11-14 16:15:50', '2018-11-14 16:15:50'),
('02', '03', 'ኦፍላ ', 'ገጠር', '2018-11-14 16:21:46', '2018-11-14 16:21:51'),
('05', '05', 'ዓድዋ', 'ከተማ', '2018-11-27 15:10:05', '2018-11-27 15:10:05'),
('05', '06', 'ኣኽሱም', 'ከተማ', '2018-11-27 15:11:05', '2018-11-27 15:11:05'),
('02', '7', 'test', 'ከተማ', '2018-12-07 05:46:29', '2018-12-07 05:46:29'),
('01', '008', 'ዓዲ ሓቂ', 'ከተማ', '2018-12-07 06:34:15', '2018-12-07 06:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `work_expriences`
--

DROP TABLE IF EXISTS `work_expriences`;
CREATE TABLE IF NOT EXISTS `work_expriences` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `exprienceType` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `career` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `position` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `institute` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `address` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `startDate` date NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `work_expriences_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `yearlies`
--

DROP TABLE IF EXISTS `yearlies`;
CREATE TABLE IF NOT EXISTS `yearlies` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `hitsuyID` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `year` int(11) NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `yearlies_hitsuyid_foreign` (`hitsuyID`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `yearlies`
--

INSERT INTO `yearlies` (`id`, `hitsuyID`, `year`, `amount`, `created_at`, `updated_at`) VALUES
(1, '0202002/002/10', 2008, '10.00', '2018-11-12 15:14:50', '2018-11-12 15:14:50'),
(2, '0202002/002/10', 2011, '10.00', '2018-11-15 16:59:11', '2018-11-15 16:59:11'),
(3, '0202002/002/10', 2010, '10.00', '2018-11-25 13:37:15', '2018-11-25 13:37:15'),
(4, '0101001/027/11', 2011, '100.00', '2018-11-25 13:41:38', '2018-11-25 13:41:38');

-- --------------------------------------------------------

--
-- Table structure for table `yearly_settings`
--

DROP TABLE IF EXISTS `yearly_settings`;
CREATE TABLE IF NOT EXISTS `yearly_settings` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `code` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` decimal(6,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `yearly_settings`
--

INSERT INTO `yearly_settings` (`id`, `code`, `type`, `amount`, `created_at`, `updated_at`) VALUES
(1, '01', 'ገባር', '10.50', '2018-03-20 22:49:38', '2018-11-26 09:07:49'),
(2, '02', 'ደኣንት', '100.00', '2018-03-20 22:50:30', '2018-03-20 22:50:30'),
(3, '03', 'ሸቃላይ', '100.00', '2018-03-20 22:50:51', '2018-03-20 22:50:51'),
(4, '04', 'ነጋዲይ', '1000.00', '2018-03-20 22:51:17', '2018-03-20 22:51:17'),
(9, '05', 'ተምሃራይ', '5.00', '2018-11-26 14:11:30', '2018-11-26 14:11:30');

-- --------------------------------------------------------

--
-- Table structure for table `zobatats`
--

DROP TABLE IF EXISTS `zobatats`;
CREATE TABLE IF NOT EXISTS `zobatats` (
  `zoneCode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `zoneName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`zoneCode`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zobatats`
--

INSERT INTO `zobatats` (`zoneCode`, `zoneName`, `created_at`, `updated_at`) VALUES
('01', 'መቐለ ሽኮር', '2017-11-09 04:45:12', '2018-11-28 16:22:03'),
('02', 'ደቡብ', '2017-11-09 04:45:21', '2018-11-17 02:39:07'),
('03', 'ደቡብ ምብራቅ', '2018-11-14 19:12:00', '2018-11-14 19:12:00'),
('05', 'ማእኸላይ', '2018-11-14 19:12:34', '2018-11-14 19:12:34'),
('06', 'ኣዲስ ኣበባ', '2018-12-07 05:45:37', '2018-12-07 05:45:37'),
('07', 'ትእም', '2018-12-07 06:32:26', '2018-12-07 14:49:02');

-- --------------------------------------------------------

--
-- Table structure for table `zoneplans`
--

DROP TABLE IF EXISTS `zoneplans`;
CREATE TABLE IF NOT EXISTS `zoneplans` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `zonecode` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `planyear` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `plantype` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `amount` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `descrpt` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `zoneplans`
--

INSERT INTO `zoneplans` (`id`, `zonecode`, `planyear`, `plantype`, `amount`, `descrpt`, `created_at`, `updated_at`) VALUES
(7, '01', '2011', 'ጠርነፍቲ መ/ውዳበ ዋህዮ', '20', 'fsdafasq', '2018-11-13 19:27:13', '2018-11-25 08:57:25'),
(8, '01', '2011', 'ጠርነፍቲ መ/ውዳበ ዋህዮ', '20', 'gsgfsd', '2018-11-13 19:27:48', '2018-11-13 19:27:48'),
(9, '05', '2011', 'ናይ ሰብ ሞያ', '9', '\n\n\n\nነናይ ቨገገቨገሀ', '2018-11-15 17:09:45', '2018-11-15 17:09:45');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
