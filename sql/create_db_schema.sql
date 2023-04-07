-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.4.0.6659
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for sgn
CREATE DATABASE IF NOT EXISTS `sgn` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `sgn`;

-- Dumping structure for table sgn.buildings
CREATE TABLE IF NOT EXISTS `buildings` (
  `building_id` int(11) NOT NULL AUTO_INCREMENT,
  `building_name` varchar(100) DEFAULT NULL,
  `country` varchar(100) DEFAULT NULL,
  `hq` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = No. 1 = Yes',
  PRIMARY KEY (`building_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sgn.buildings: ~5 rows (approximately)
INSERT INTO `buildings` (`building_id`, `building_name`, `country`, `hq`) VALUES
	(1, 'Issac Newton', 'UK', 0),
	(2, 'Oscar Wilde', 'UK', 0),
	(3, 'Charles Darwin', 'UK', 1),
	(4, 'Benjamin Frankilin', 'USA', 0),
	(5, 'Lucianno Pavarotti', 'Italy', 0);

-- Dumping structure for table sgn.buildings_departments
CREATE TABLE IF NOT EXISTS `buildings_departments` (
  `building_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`building_id`,`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sgn.buildings_departments: ~8 rows (approximately)
INSERT INTO `buildings_departments` (`building_id`, `department_id`) VALUES
	(1, 1),
	(1, 2),
	(2, 3),
	(2, 4),
	(4, 1),
	(4, 4),
	(5, 1),
	(5, 4);

-- Dumping structure for table sgn.departments
CREATE TABLE IF NOT EXISTS `departments` (
  `department_id` int(11) NOT NULL AUTO_INCREMENT,
  `department_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`department_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sgn.departments: ~5 rows (approximately)
INSERT INTO `departments` (`department_id`, `department_name`) VALUES
	(1, 'Development'),
	(2, 'Accounting'),
	(3, 'HR'),
	(4, 'Sales'),
	(5, 'Director');

-- Dumping structure for table sgn.employees
CREATE TABLE IF NOT EXISTS `employees` (
  `employee_id` int(11) NOT NULL AUTO_INCREMENT,
  `fname` varchar(70) NOT NULL,
  `sname` varchar(70) DEFAULT NULL,
  `rfid_number` char(32) NOT NULL,
  PRIMARY KEY (`employee_id`),
  UNIQUE KEY `rfid_number` (`rfid_number`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sgn.employees: ~1 rows (approximately)
INSERT INTO `employees` (`employee_id`, `fname`, `sname`, `rfid_number`) VALUES
	(1, 'Julius', 'Caesar', '142594708f3a5a3ac2980914a0fc954f');

-- Dumping structure for table sgn.employee_departments
CREATE TABLE IF NOT EXISTS `employee_departments` (
  `employee_id` int(11) NOT NULL,
  `department_id` int(11) NOT NULL,
  PRIMARY KEY (`employee_id`,`department_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table sgn.employee_departments: ~2 rows (approximately)
INSERT INTO `employee_departments` (`employee_id`, `department_id`) VALUES
	(1, 1),
	(1, 5);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
