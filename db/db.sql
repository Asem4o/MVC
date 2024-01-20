-- --------------------------------------------------------
-- Хост:                         127.0.0.1
-- Версия на сървъра:            10.4.28-MariaDB - mariadb.org binary distribution
-- ОС на сървъра:                Win64
-- HeidiSQL Версия:              12.5.0.6677
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Дъмп на структурата на БД mvc
CREATE DATABASE IF NOT EXISTS `mvc` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `mvc`;

-- Дъмп структура за таблица mvc.chat
CREATE TABLE IF NOT EXISTS `chat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `senderId` int(11) NOT NULL,
  `receiverId` int(11) NOT NULL,
  `content` text NOT NULL,
  `timestamp` timestamp NOT NULL DEFAULT current_timestamp(),
  `IsRead` tinyint(4) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`),
  KEY `senderId` (`senderId`),
  KEY `receiverId` (`receiverId`),
  CONSTRAINT `chat_ibfk_1` FOREIGN KEY (`senderId`) REFERENCES `users` (`id`),
  CONSTRAINT `chat_ibfk_2` FOREIGN KEY (`receiverId`) REFERENCES `users` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1178 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Изнасянето на данните беше деселектирано.

-- Дъмп структура за таблица mvc.narqd
CREATE TABLE IF NOT EXISTS `narqd` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `compensation` varchar(250) DEFAULT NULL,
  `created` date DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`),
  KEY `FK1_Users_Id_Id` (`userId`),
  CONSTRAINT `FK1_Users_Id_Id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=127 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Изнасянето на данните беше деселектирано.

-- Дъмп структура за таблица mvc.note
CREATE TABLE IF NOT EXISTS `note` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) DEFAULT NULL,
  `userId` int(11) NOT NULL,
  `note` varchar(255) DEFAULT NULL,
  `created` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `guid` (`guid`),
  KEY `FK1_UserId_` (`userId`),
  CONSTRAINT `FK1_UserId_` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=896 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Изнасянето на данните беше деселектирано.

-- Дъмп структура за таблица mvc.otpuska
CREATE TABLE IF NOT EXISTS `otpuska` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `otpuska` varchar(50) DEFAULT NULL,
  `created` year(4) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK1_id_Users_Id` (`userId`),
  CONSTRAINT `FK1_id_Users_Id` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=75 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Изнасянето на данните беше деселектирано.

-- Дъмп структура за таблица mvc.users
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `guid` varchar(50) DEFAULT NULL,
  `username` varchar(150) NOT NULL,
  `password` varchar(150) NOT NULL,
  `url` varchar(150) DEFAULT NULL,
  `pin` varchar(150) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`),
  UNIQUE KEY `guid` (`guid`)
) ENGINE=InnoDB AUTO_INCREMENT=10181 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Изнасянето на данните беше деселектирано.

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
