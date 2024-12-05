-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for ramycook
CREATE DATABASE IF NOT EXISTS `ramycook` /*!40100 DEFAULT CHARACTER SET armscii8 COLLATE armscii8_bin */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `ramycook`;

-- Dumping structure for table ramycook.categories
CREATE TABLE IF NOT EXISTS `categories` (
  `category_id` int NOT NULL,
  `category_name` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table ramycook.categories: ~4 rows (approximately)
INSERT INTO `categories` (`category_id`, `category_name`) VALUES
	(1, 'Breakfast'),
	(2, 'Lunch'),
	(3, 'Brunch'),
	(4, 'Dinner');

-- Dumping structure for table ramycook.ingredients
CREATE TABLE IF NOT EXISTS `ingredients` (
  `ingredient_id` int NOT NULL AUTO_INCREMENT,
  `recipe_id` int DEFAULT NULL,
  `ingredient_name` text CHARACTER SET armscii8 COLLATE armscii8_bin,
  `quantity` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`ingredient_id`),
  KEY `FK__recipes` (`recipe_id`),
  CONSTRAINT `FK__recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table ramycook.ingredients: ~11 rows (approximately)
INSERT INTO `ingredients` (`ingredient_id`, `recipe_id`, `ingredient_name`, `quantity`) VALUES
	(1, 5, 'Telur', '2 butir'),
	(2, 5, 'Bawang bombay', '1 butir'),
	(3, 5, 'Wortel (opsional)', '1 buah'),
	(4, 5, 'Garam', 'secukupnya'),
	(5, 5, 'Merica', 'secukupnya'),
	(6, 2, 'Tepung terigu', '150 gram'),
	(7, 2, 'Telur', '1 butir'),
	(8, 2, 'Susu', '250 ml'),
	(9, 2, 'Gula', 'Secukupnya'),
	(10, 2, 'Baking Powder', 'Secukupnya'),
	(11, 2, 'Margarin', 'Secukupnya');

-- Dumping structure for table ramycook.recipes
CREATE TABLE IF NOT EXISTS `recipes` (
  `recipe_id` int NOT NULL AUTO_INCREMENT,
  `user_id` int DEFAULT NULL,
  `category_id` int DEFAULT NULL,
  `recipe_name` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `url` varchar(255) COLLATE armscii8_bin DEFAULT NULL,
  `description` text CHARACTER SET armscii8 COLLATE armscii8_bin,
  `created_at` date DEFAULT NULL,
  PRIMARY KEY (`recipe_id`),
  KEY `FK__users` (`user_id`),
  KEY `FK_recipes_categories` (`category_id`),
  CONSTRAINT `FK__users` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  CONSTRAINT `FK_recipes_categories` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table ramycook.recipes: ~5 rows (approximately)
INSERT INTO `recipes` (`recipe_id`, `user_id`, `category_id`, `recipe_name`, `url`, `description`, `created_at`) VALUES
	(1, 111, 4, 'Spaghetti Carbonara', 'https://www.allrecipes.com/thmb/Y7ftij8uq7sM2VpxGt-RHZg3yaA=/1500x0/filters:no_upscale():max_bytes(150000):strip_icc()/11973-spaghetti-carbonara-mfs-042-21d5decdffde4a1faa94a21725ce9cc3.jpg', 'Pasta spaghetti dengan saus krim telur, bacon, dan keju yang lezat.', '2024-11-27'),
	(2, 111, 1, 'Pancakes', 'https://www.amandaseasyrecipes.com/wp-content/uploads/2022/07/Brown_Sugar_Pancakes_Web-36-680x680.jpg', 'Pancake lembut yang disajikan dengan sirup manis atau topping favorit.', '2024-11-27'),
	(3, 111, 1, 'Nasi Uduk', 'https://cdn.idntimes.com/content-images/post/20210907/dapur-si-bunbun-1630996768184-0-8375de89bb8c9ef71aea0a8aaa204ae9.jpg', 'Nasi yang dimasak dengan santan, disajikan dengan lauk khas Indonesia.', '2024-11-27'),
	(4, 111, 2, 'Nasi Padang', 'https://img1.wsimg.com/isteam/ip/bbb205e1-b7ae-4374-a14c-282335d5f070/POI04372.jpg/:/cr=t:0%25,l:16.64%25,w:66.72%25,h:100%25', 'Nasi putih dengan berbagai pilihan lauk-pauk pedas khas Minangkabau.', '2024-11-28'),
	(5, 111, 3, 'Omelet', 'https://img.kurio.network/v6vvnaJ6sBlNkg3GQj9EU5B5dvE=/1200x1200/filters:quality(80)/https://kurio-img.kurioapps.com/22/02/20/b4466da7-0fe6-4327-9f7b-a028c16760d0.jpe', 'Telur dadar yang diisi dengan bahan seperti sayuran, keju, atau daging.', '2024-11-28');

-- Dumping structure for table ramycook.steps
CREATE TABLE IF NOT EXISTS `steps` (
  `steps_id` int NOT NULL AUTO_INCREMENT,
  `recipe_id` int DEFAULT NULL,
  `step_description` text CHARACTER SET armscii8 COLLATE armscii8_bin,
  PRIMARY KEY (`steps_id`),
  KEY `FK_steps_recipes` (`recipe_id`),
  CONSTRAINT `FK_steps_recipes` FOREIGN KEY (`recipe_id`) REFERENCES `recipes` (`recipe_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table ramycook.steps: ~7 rows (approximately)
INSERT INTO `steps` (`steps_id`, `recipe_id`, `step_description`) VALUES
	(1, 2, 'Campur semua bahan hingga rata.'),
	(2, 2, 'Panaskan teflon, olesi dengan margarin.'),
	(3, 2, 'Tuang adonan sedikit demi sedikit, masak hingga matang kecoklatan.'),
	(4, 5, 'Kocok telur hingga berbusa.'),
	(5, 5, 'Tumis bawang bombay dan wortel hingga layu.'),
	(6, 5, 'Masukkan tumisan sayuran ke dalam kocokan telur. Bumbui dengan garam dan merica.'),
	(7, 5, 'Goreng hingga matang.');

-- Dumping structure for table ramycook.users
CREATE TABLE IF NOT EXISTS `users` (
  `user_id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `email` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  `password` varchar(50) CHARACTER SET armscii8 COLLATE armscii8_bin DEFAULT NULL,
  PRIMARY KEY (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=112 DEFAULT CHARSET=armscii8 COLLATE=armscii8_bin;

-- Dumping data for table ramycook.users: ~1 rows (approximately)
INSERT INTO `users` (`user_id`, `username`, `email`, `password`) VALUES
	(111, 'user1', 'user1@gmail.com', 'user123');

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
