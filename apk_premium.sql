/*
SQLyog Community v13.3.0 (64 bit)
MySQL - 8.0.43 : Database - apk_premium
*********************************************************************
*/

/*!40101 SET NAMES utf8 */;

/*!40101 SET SQL_MODE=''*/;

/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;
CREATE DATABASE /*!32312 IF NOT EXISTS*/`apk_premium` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;

USE `apk_premium`;

/*Table structure for table `cache` */

DROP TABLE IF EXISTS `cache`;

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache` */

insert  into `cache`(`key`,`value`,`expiration`) values 
('9af87ea73f5172744a2843b45030288a','i:1;',1765848544),
('9af87ea73f5172744a2843b45030288a:timer','i:1765848544;',1765848544),
('a4837483f320ab85ca01621a4e1eb15b','i:1;',1766194798),
('a4837483f320ab85ca01621a4e1eb15b:timer','i:1766194798;',1766194798);

/*Table structure for table `cache_locks` */

DROP TABLE IF EXISTS `cache_locks`;

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL,
  PRIMARY KEY (`key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `cache_locks` */

/*Table structure for table `chats` */

DROP TABLE IF EXISTS `chats`;

CREATE TABLE `chats` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `chats_order_id_unique` (`order_id`),
  CONSTRAINT `chats_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `chats` */

insert  into `chats`(`id`,`order_id`,`created_at`,`updated_at`) values 
(1,6,'2025-12-15 17:31:49','2025-12-15 17:31:49'),
(2,3,'2025-12-15 20:53:33','2025-12-15 20:53:33');

/*Table structure for table `customers` */

DROP TABLE IF EXISTS `customers`;

CREATE TABLE `customers` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `user_id` bigint unsigned DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `phone` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `customers_email_unique` (`email`),
  KEY `customers_user_id_foreign` (`user_id`),
  CONSTRAINT `customers_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `customers` */

insert  into `customers`(`id`,`user_id`,`name`,`email`,`phone`,`address`,`created_at`,`updated_at`) values 
(1,2,'Nova Auliya','nova@gmail.com','086371927682','kediri','2025-12-13 10:46:32','2025-12-13 10:46:32'),
(2,3,'zody','zody@gmail.com','086371927682','kediri','2025-12-15 13:15:39','2025-12-15 14:42:54'),
(3,4,'Silvia Zahrani','silviazahrani4@gmail.com','0987654321','jl. Mawar','2025-12-15 15:29:03','2025-12-15 15:29:03'),
(4,5,'gina','gina@gmail.com','01','kediri','2025-12-16 00:50:02','2025-12-16 00:50:02'),
(5,6,'Dera Amanda','dera@gmail.com','986','Jln. Mawar','2025-12-16 01:45:51','2025-12-16 01:45:51');

/*Table structure for table `failed_jobs` */

DROP TABLE IF EXISTS `failed_jobs`;

CREATE TABLE `failed_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `failed_jobs` */

/*Table structure for table `job_batches` */

DROP TABLE IF EXISTS `job_batches`;

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `job_batches` */

/*Table structure for table `jobs` */

DROP TABLE IF EXISTS `jobs`;

CREATE TABLE `jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint unsigned NOT NULL,
  `reserved_at` int unsigned DEFAULT NULL,
  `available_at` int unsigned NOT NULL,
  `created_at` int unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `jobs_queue_index` (`queue`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `jobs` */

/*Table structure for table `messages` */

DROP TABLE IF EXISTS `messages`;

CREATE TABLE `messages` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `chat_id` bigint unsigned NOT NULL,
  `sender` enum('buyer','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `sender_id` bigint unsigned DEFAULT NULL,
  `content` text COLLATE utf8mb4_unicode_ci,
  `attachment` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'text',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `read_by_admin` tinyint(1) NOT NULL DEFAULT '0',
  `read_by_buyer` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `messages_chat_id_foreign` (`chat_id`),
  CONSTRAINT `messages_chat_id_foreign` FOREIGN KEY (`chat_id`) REFERENCES `chats` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `messages` */

insert  into `messages`(`id`,`chat_id`,`sender`,`sender_id`,`content`,`attachment`,`type`,`created_at`,`updated_at`,`read_by_admin`,`read_by_buyer`) values 
(1,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:54:45','2025-12-15 20:54:45',0,0),
(2,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:57:24','2025-12-15 20:57:24',0,0),
(3,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:57:38','2025-12-15 20:57:38',0,0),
(4,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:57:42','2025-12-15 20:57:42',0,0),
(5,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:57:46','2025-12-15 20:57:46',0,0),
(6,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:57:50','2025-12-15 20:57:50',0,0),
(7,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:58:39','2025-12-15 20:58:39',0,0),
(8,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 20:59:12','2025-12-15 20:59:12',0,0),
(9,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 21:01:12','2025-12-15 21:01:12',0,0),
(10,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 21:01:45','2025-12-15 21:01:45',0,0),
(11,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 21:03:43','2025-12-15 21:03:43',0,0),
(12,2,'buyer',4,'100000000000/10',NULL,'testimonial','2025-12-15 21:04:32','2025-12-15 21:04:32',0,0);

/*Table structure for table `migrations` */

DROP TABLE IF EXISTS `migrations`;

CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `migrations` */

insert  into `migrations`(`id`,`migration`,`batch`) values 
(1,'0001_01_01_000000_create_users_table',1),
(2,'0001_01_01_000001_create_cache_table',1),
(3,'0001_01_01_000002_create_jobs_table',1),
(4,'2025_12_09_053347_create_products_table',1),
(5,'2025_12_09_053348_create_customers_table',1),
(6,'2025_12_09_053348_create_orders_table',1),
(7,'2025_12_09_053349_create_order_items_table',1),
(8,'2025_12_09_065937_add_payment_fields_to_orders_table',1),
(9,'2025_12_09_075316_add_order_fields_to_orders_table',1),
(10,'2025_12_09_084525_add_two_factor_columns_to_users_table',1),
(11,'2025_12_13_090407_add_user_id_to_customers_table',2),
(12,'2025_12_13_103349_add_features_packages_to_products_table',3),
(13,'2025_12_13_104727_remove_old_columns_from_orders_table',4),
(14,'2025_12_15_072800_add_notes_and_verified_at_to_orders_table',5),
(15,'2025_12_15_105212_create_product_variants_table',5),
(16,'2025_12_15_105228_create_promos_table',5),
(17,'2025_12_15_112940_add_variant_id_to_order_items_table',6),
(18,'2025_12_16_000001_create_chats_table',7),
(19,'2025_12_16_000002_create_messages_table',7),
(20,'2025_12_16_000003_create_testimonials_table',7),
(21,'2025_12_16_000004_add_chat_started_at_to_orders_table',7),
(22,'2025_12_16_000005_create_notifications_table',8),
(23,'2025_12_16_000010_create_websockets_statistics_entries_table',9),
(24,'2025_12_16_000011_add_read_flags_to_messages_table',10),
(25,'2025_12_15_225931_add_payment_status_to_orders_table',11);

/*Table structure for table `notifications` */

DROP TABLE IF EXISTS `notifications`;

CREATE TABLE `notifications` (
  `id` char(36) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `notifiable_id` bigint unsigned NOT NULL,
  `data` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `read_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `notifications_notifiable_type_notifiable_id_index` (`notifiable_type`,`notifiable_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `notifications` */

/*Table structure for table `order_items` */

DROP TABLE IF EXISTS `order_items`;

CREATE TABLE `order_items` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `product_id` bigint unsigned NOT NULL,
  `variant_id` bigint unsigned DEFAULT NULL,
  `variant_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `quantity` int NOT NULL DEFAULT '1',
  `price` decimal(12,2) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `order_items_order_id_foreign` (`order_id`),
  KEY `order_items_product_id_foreign` (`product_id`),
  KEY `order_items_variant_id_foreign` (`variant_id`),
  CONSTRAINT `order_items_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE,
  CONSTRAINT `order_items_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `order_items` */

insert  into `order_items`(`id`,`order_id`,`product_id`,`variant_id`,`variant_name`,`quantity`,`price`,`created_at`,`updated_at`) values 
(8,6,11,44,'3 Bulan (Anlim)',1,20000.00,'2025-12-15 17:27:08','2025-12-15 17:27:08'),
(9,7,11,43,'1 Bulan (Anlim)',4,10000.00,'2025-12-15 22:51:28','2025-12-15 22:51:28'),
(10,8,6,13,'1P1U - 6 Hari',3,12000.00,'2025-12-15 22:53:48','2025-12-15 22:53:48'),
(11,9,10,37,'Sharing - 3 Hari',2,6000.00,'2025-12-15 23:06:58','2025-12-15 23:06:58'),
(12,10,8,21,'1 Hari',2,1000.00,'2025-12-15 23:15:59','2025-12-15 23:15:59'),
(13,11,11,40,'1 Hari',1,3000.00,'2025-12-16 00:50:02','2025-12-16 00:50:02'),
(14,12,8,27,'1 Tahun',1,30000.00,'2025-12-16 01:45:51','2025-12-16 01:45:51');

/*Table structure for table `orders` */

DROP TABLE IF EXISTS `orders`;

CREATE TABLE `orders` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_number` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `subtotal` decimal(12,2) NOT NULL,
  `shipping` decimal(12,2) NOT NULL DEFAULT '0.00',
  `total` decimal(12,2) NOT NULL,
  `payment_proof` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_verified_at` timestamp NULL DEFAULT NULL,
  `premium_access_sent` tinyint(1) NOT NULL DEFAULT '0',
  `status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `payment_method` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payment_info` text COLLATE utf8mb4_unicode_ci,
  `notes` text COLLATE utf8mb4_unicode_ci,
  `verified_at` timestamp NULL DEFAULT NULL,
  `chat_started_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `orders_order_number_unique` (`order_number`),
  KEY `orders_customer_id_foreign` (`customer_id`),
  CONSTRAINT `orders_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `orders` */

insert  into `orders`(`id`,`order_number`,`customer_id`,`subtotal`,`shipping`,`total`,`payment_proof`,`payment_verified_at`,`premium_access_sent`,`status`,`payment_status`,`payment_method`,`payment_info`,`notes`,`verified_at`,`chat_started_at`,`created_at`,`updated_at`) values 
(1,'ORD-AVMYFR37',2,30000.00,0.00,30000.00,'payment_proof/JQnEEDTpBLoA6Qq3nqRRXfhDCkueOJcAULkzKtKe.jpg',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:09:17',NULL,'2025-12-15 13:15:39','2025-12-15 23:09:17'),
(2,'ORD-KH5TLJMA',2,237000.00,0.00,237000.00,'payment_proof/hYu8WrR8jH7Bfxh54qKawS0X8zFDKpQdK6HELM2s.png',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:09:16',NULL,'2025-12-15 14:42:54','2025-12-15 23:09:16'),
(3,'ORD-AGOKUB9G',3,50000.00,0.00,50000.00,'payment_proof/yJgAYYTBqWjhXYYlJ7Pkwrk14Rfr1byOVDLdbyhD.jpg',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:09:09','2025-12-15 20:53:32','2025-12-15 15:29:03','2025-12-15 23:09:09'),
(4,'ORD-NOV-001',1,30000.00,0.00,30000.00,NULL,NULL,0,'paid','pending',NULL,NULL,NULL,NULL,NULL,'2025-11-15 23:40:31','2025-11-15 23:40:31'),
(5,'ORD-NOV-002',2,30000.00,0.00,30000.00,NULL,NULL,0,'paid','pending',NULL,NULL,NULL,'2025-12-16 01:22:22',NULL,'2025-11-20 23:40:31','2025-12-16 01:22:22'),
(6,'ORD-EXUBTCTY',3,20000.00,0.00,20000.00,'payment_proof/a60sb351trxBiOdjSbjjNG799riHQqKZgmGanKtP.jpg',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:09:14','2025-12-15 17:31:48','2025-12-15 17:27:08','2025-12-15 23:09:14'),
(7,'ORD-Q4UP44EZ',2,40000.00,0.00,40000.00,'payment_proof/aawKe4K9JOsIXSm0iufaEVwCFRGYcdLpDlibnWTH.png',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:09:32',NULL,'2025-12-15 22:51:28','2025-12-15 23:09:32'),
(8,'ORD-ZFV0ZPSH',2,36000.00,0.00,36000.00,'payment_proof/Mv8lum1NisFCSm1qBO0IIQViFlmuz7SmKtnJ6e8i.png',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:08:42',NULL,'2025-12-15 22:53:48','2025-12-15 23:08:42'),
(9,'ORD-RQYKMRZA',2,12000.00,0.00,12000.00,'payment_proof/sJVGpe0QLoE8zjBLA2r0IFxMExjDqdQRfM4n5qcm.png',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:09:43',NULL,'2025-12-15 23:06:58','2025-12-15 23:09:43'),
(10,'ORD-HQIS8ZXA',2,2000.00,0.00,2000.00,'payment_proof/JH3Jm3Rv2M63lbggQOwODEoz3RjUAbrIEfmg72bH.png',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-15 23:26:10',NULL,'2025-12-15 23:15:59','2025-12-15 23:26:10'),
(11,'ORD-WR1JFXJ8',4,3000.00,0.00,3000.00,'payment_proof/dKEVleacqpzL1jaq3kPIe9DAhhzTGsCsrkCPMWkw.png',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-16 00:54:14',NULL,'2025-12-16 00:50:02','2025-12-16 00:54:14'),
(12,'ORD-EKYYOO9X',5,30000.00,0.00,30000.00,'payment_proof/SngTk4aC3gZCQ5NCgbHgKGcpeJxou8fcuxjMEj4l.jpg',NULL,0,'paid','verified',NULL,NULL,NULL,'2025-12-16 01:49:42',NULL,'2025-12-16 01:45:51','2025-12-16 01:49:42');

/*Table structure for table `password_reset_tokens` */

DROP TABLE IF EXISTS `password_reset_tokens`;

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `password_reset_tokens` */

/*Table structure for table `product_variants` */

DROP TABLE IF EXISTS `product_variants`;

CREATE TABLE `product_variants` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `product_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` decimal(12,2) NOT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `product_variants_product_id_foreign` (`product_id`),
  CONSTRAINT `product_variants_product_id_foreign` FOREIGN KEY (`product_id`) REFERENCES `products` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `product_variants` */

insert  into `product_variants`(`id`,`product_id`,`name`,`price`,`stock`,`is_active`,`created_at`,`updated_at`) values 
(11,6,'1P1U - 3 Hari',9000.00,10,1,'2025-12-15 16:04:58','2025-12-15 16:04:58'),
(12,6,'1P1U - 5 Hari',11000.00,5,1,'2025-12-15 16:04:58','2025-12-15 16:04:58'),
(13,6,'1P1U - 6 Hari',12000.00,0,1,'2025-12-15 16:04:58','2025-12-15 22:53:47'),
(14,6,'1P1U - 7 Hari',13000.00,12,1,'2025-12-15 16:04:58','2025-12-15 16:04:58'),
(15,6,'1P1U - 1 Bulan',40000.00,1,1,'2025-12-15 16:04:58','2025-12-15 16:04:58'),
(16,6,'1P2U - 1 Bulan',22000.00,20,1,'2025-12-15 16:04:58','2025-12-15 16:04:58'),
(17,7,'Sharing - 1 Hari',5000.00,20,1,'2025-12-15 16:11:15','2025-12-15 16:11:15'),
(18,7,'Sharing - 7 Hari',7000.00,20,1,'2025-12-15 16:11:15','2025-12-15 16:11:15'),
(19,7,'Sharing ANLIM - 1 Bulan',15000.00,10,1,'2025-12-15 16:11:15','2025-12-15 16:11:15'),
(20,7,'Private - 1 Bulan',35000.00,10,1,'2025-12-15 16:11:15','2025-12-15 16:11:15'),
(21,8,'1 Hari',1000.00,98,1,'2025-12-15 16:15:45','2025-12-15 23:15:59'),
(22,8,'3 Hari',2000.00,100,1,'2025-12-15 16:15:45','2025-12-15 16:15:45'),
(23,8,'7 Hari',5000.00,100,1,'2025-12-15 16:15:45','2025-12-15 16:15:45'),
(24,8,'1 Bulan',10000.00,80,1,'2025-12-15 16:15:45','2025-12-15 16:15:45'),
(25,8,'2 Bulan',12000.00,50,1,'2025-12-15 16:15:45','2025-12-15 16:15:45'),
(26,8,'3 Bulan',14000.00,50,1,'2025-12-15 16:15:45','2025-12-15 16:15:45'),
(27,8,'1 Tahun',30000.00,49,1,'2025-12-15 16:15:45','2025-12-16 01:45:51'),
(28,9,'5 User - 1 Hari',4000.00,5,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(29,9,'5 User - 3 Hari',8000.00,10,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(30,9,'5 User - 7 Hari',13000.00,6,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(31,9,'5 User - 1 Bulan',35000.00,2,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(32,9,'3 User - 1 Hari',6000.00,10,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(33,9,'3 User - 3 Hari',13000.00,20,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(34,9,'3 User - 7 Hari',23000.00,4,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(35,9,'3 User - 1 Bulan',50000.00,10,1,'2025-12-15 16:21:12','2025-12-15 16:21:12'),
(36,10,'Sharing - 1 Hari',3000.00,10,1,'2025-12-15 16:24:56','2025-12-15 16:24:56'),
(37,10,'Sharing - 3 Hari',6000.00,6,1,'2025-12-15 16:24:56','2025-12-15 23:06:58'),
(38,10,'Sharing - 7 Hari',8000.00,10,1,'2025-12-15 16:24:56','2025-12-15 16:24:56'),
(39,10,'Sharing - 1 Bulan',15000.00,10,1,'2025-12-15 16:24:56','2025-12-15 16:24:56'),
(40,11,'1 Hari',5000.00,4,1,'2025-12-15 16:29:34','2025-12-16 01:19:31'),
(41,11,'3 Hari',4000.00,10,1,'2025-12-15 16:29:34','2025-12-15 16:29:34'),
(42,11,'7 Hari',6000.00,6,1,'2025-12-15 16:29:34','2025-12-15 16:29:34'),
(43,11,'1 Bulan (Anlim)',10000.00,1,1,'2025-12-15 16:29:34','2025-12-15 22:51:28'),
(44,11,'3 Bulan (Anlim)',20000.00,4,1,'2025-12-15 16:29:34','2025-12-15 17:27:08');

/*Table structure for table `products` */

DROP TABLE IF EXISTS `products`;

CREATE TABLE `products` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci,
  `features` text COLLATE utf8mb4_unicode_ci,
  `packages` text COLLATE utf8mb4_unicode_ci,
  `price` decimal(12,2) NOT NULL,
  `package` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stock` int NOT NULL DEFAULT '0',
  `image` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `products_slug_unique` (`slug`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `products` */

insert  into `products`(`id`,`name`,`slug`,`description`,`features`,`packages`,`price`,`package`,`stock`,`image`,`created_at`,`updated_at`) values 
(6,'Netflix Premium','netflix-premium','Nikmati pengalaman streaming Netflix Premium dengan kualitas terbaik tanpa ribet. Cocok buat kamu yang mau nonton film, series, dan anime favorit dengan harga hemat dan proses cepat.','✨ Keunggulan:\r\n\r\n1. Akun legal & aman\r\n2. Kualitas HD / Full HD\r\n3. Bisa dipakai di berbagai perangkat\r\n4. Proses cepat & praktis\r\n5. Harga ramah kantong\r\n\r\n? Pilihan Paket:\r\n\r\n1P1U → 1 profil khusus untuk 1 user (lebih private)\r\n1P2U → 1 profil bisa dipakai 2 user (lebih hemat)\r\n\r\n⏳ Durasi fleksibel, mulai dari harian sampai bulanan, tinggal pilih sesuai kebutuhanmu.','[{\"name\":\"1P1U - 3 Hari\",\"price\":9000,\"stock\":10},{\"name\":\"1P1U - 5 Hari\",\"price\":11000,\"stock\":5},{\"name\":\"1P1U - 6 Hari\",\"price\":12000,\"stock\":3},{\"name\":\"1P1U - 7 Hari\",\"price\":13000,\"stock\":12},{\"name\":\"1P1U - 1 Bulan\",\"price\":40000,\"stock\":1},{\"name\":\"1P2U - 1 Bulan\",\"price\":22000,\"stock\":20}]',9000.00,NULL,0,'products/OKLV5hFfZHeJ4ZxPzTu8gJf2MV2WtA8qFXbVPua1.jpg','2025-12-15 16:04:58','2025-12-15 16:04:58'),
(7,'WeTV Premium','wetv-premium','Nikmati berbagai drama Asia, anime, dan variety show favorit dengan WeTV Premium. Nonton lebih nyaman tanpa gangguan iklan, kualitas jernih, dan update cepat.','✨ Keunggulan WeTV Premium:\r\n\r\n1. Akun aman & terpercaya\r\n2. Tanpa iklan\r\n3. Kualitas video jernih\r\n4. Update episode lebih cepat\r\n5. Cocok untuk nonton harian maupun bulanan\r\n\r\n? Pilihan Paket:\r\n\r\n? Sharing\r\n❌ Tidak bisa login di TV\r\n\r\n? Private\r\n1. Lebih aman & eksklusif\r\n2. Bebas login di semua device\r\n\r\n⚠️ Catatan Penting:\r\n- Paket harian bersifat limited stock\r\n- Paket sharing tidak support login TV','[{\"name\":\"Sharing - 1 Hari\",\"price\":5000,\"stock\":20},{\"name\":\"Sharing - 7 Hari\",\"price\":7000,\"stock\":20},{\"name\":\"Sharing ANLIM - 1 Bulan\",\"price\":15000,\"stock\":10},{\"name\":\"Private - 1 Bulan\",\"price\":35000,\"stock\":10}]',5000.00,NULL,0,'products/tXIgv2zKAUX9LjZRhttIrfrM223ZsvSW3zL6sElN.jpg','2025-12-15 16:11:15','2025-12-15 16:11:15'),
(8,'Canva Pro','canva-pro','Tingkatkan kualitas desainmu dengan Canva Pro. Akses ribuan template premium, elemen eksklusif, dan fitur desain lengkap tanpa batas. Cocok untuk pelajar, UMKM, content creator, sampai admin media sosial.','✨ Keunggulan Canva Pro:\r\n\r\n1. Akses template & elemen premium\r\n2. Background remover & resize instan\r\n3. Font eksklusif & stok foto premium\r\n4. Bisa kolaborasi tim\r\n5. Praktis & mudah digunakan','[{\"name\":\"1 Hari\",\"price\":1000,\"stock\":100},{\"name\":\"3 Hari\",\"price\":2000,\"stock\":100},{\"name\":\"7 Hari\",\"price\":5000,\"stock\":100},{\"name\":\"1 Bulan\",\"price\":10000,\"stock\":80},{\"name\":\"2 Bulan\",\"price\":12000,\"stock\":50},{\"name\":\"3 Bulan\",\"price\":14000,\"stock\":50},{\"name\":\"1 Tahun\",\"price\":30000,\"stock\":50}]',1000.00,NULL,0,'products/eW1jDLDoa6uFmYqjMstnM3N4Ft0R5Vjd4l6JJdt2.jpg','2025-12-15 16:15:45','2025-12-15 16:15:45'),
(9,'Disney+ Premium','disney-premium','Nikmati berbagai film dan series terbaik dari Disney, Pixar, Marvel, Star Wars, hingga National Geographic dengan Disney+ Premium. Cocok untuk nonton sendiri, bareng teman, atau keluarga.','✨ Keunggulan Disney+ Premium:\r\n1. Akses konten eksklusif Disney & Marvel\r\n2. Kualitas HD / Full HD\r\n4. Aman & nyaman digunakan\r\n5. Bisa dipakai di berbagai perangkat\r\n6. Update film & series terbaru','[{\"name\":\"5 User - 1 Hari\",\"price\":4000,\"stock\":5},{\"name\":\"5 User - 3 Hari\",\"price\":8000,\"stock\":10},{\"name\":\"5 User - 7 Hari\",\"price\":13000,\"stock\":6},{\"name\":\"5 User - 1 Bulan\",\"price\":35000,\"stock\":2},{\"name\":\"3 User - 1 Hari\",\"price\":6000,\"stock\":10},{\"name\":\"3 User - 3 Hari\",\"price\":13000,\"stock\":20},{\"name\":\"3 User - 7 Hari\",\"price\":23000,\"stock\":4},{\"name\":\"3 User - 1 Bulan\",\"price\":50000,\"stock\":10}]',4000.00,NULL,0,'products/vrgqDFrbKyKOiTFR4bzwBceKy3044Vw7fYhVJgsk.jpg','2025-12-15 16:21:12','2025-12-15 16:21:12'),
(10,'iQIYI Premium','iqiyi-premium','Nikmati berbagai drama China, Korea, anime, dan variety show favorit dengan iQIYI Premium. Streaming lebih nyaman tanpa iklan dengan kualitas video jernih dan update episode lebih cepat.','✨ Keunggulan iQIYI Premium:\r\n1. Akses konten VIP eksklusif\r\n2. Tanpa iklan\r\n3. Kualitas HD\r\n4. Update episode lebih cepat\r\n5. Aman & nyaman digunakan','[{\"name\":\"Sharing - 1 Hari\",\"price\":3000,\"stock\":10},{\"name\":\"Sharing - 3 Hari\",\"price\":6000,\"stock\":8},{\"name\":\"Sharing - 7 Hari\",\"price\":8000,\"stock\":10},{\"name\":\"Sharing - 1 Bulan\",\"price\":15000,\"stock\":10}]',3000.00,NULL,0,'products/LVtADocUOWcql5hXaA4WAuyyfug11ftfmWRYakwr.jpg','2025-12-15 16:24:56','2025-12-15 16:24:56'),
(11,'Viu Premium','viu-premium','Nikmati berbagai drama Korea, Jepang, China, dan Asia lainnya dengan Viu Premium. Streaming lebih nyaman tanpa iklan, kualitas video jernih, dan episode terbaru bisa ditonton lebih cepat.','✨ Keunggulan Viu Premium:\r\n1. Tanpa iklan\r\n2. Akses episode terbaru lebih cepat\r\n3. Kualitas HD\r\n4. Aman & mudah digunakan\r\n5. Bisa ditonton di berbagai perangkat','[{\"name\":\"1 Hari\",\"price\":3000,\"stock\":10},{\"name\":\"3 Hari\",\"price\":4000,\"stock\":10},{\"name\":\"7 Hari\",\"price\":6000,\"stock\":6},{\"name\":\"1 Bulan (Anlim)\",\"price\":10000,\"stock\":5},{\"name\":\"3 Bulan (Anlim)\",\"price\":20000,\"stock\":5}]',3000.00,NULL,0,'products/aHcLF13jdPzWE7XJNNbcPemEkJReeuciM51TGuRq.png','2025-12-15 16:29:34','2025-12-20 01:40:17');

/*Table structure for table `promos` */

DROP TABLE IF EXISTS `promos`;

CREATE TABLE `promos` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `variant_id` bigint unsigned NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` enum('nominal','percent') COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` decimal(12,2) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `promos_variant_id_foreign` (`variant_id`),
  CONSTRAINT `promos_variant_id_foreign` FOREIGN KEY (`variant_id`) REFERENCES `product_variants` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `promos` */

insert  into `promos`(`id`,`variant_id`,`name`,`type`,`value`,`start_date`,`end_date`,`is_active`,`created_at`,`updated_at`) values 
(3,43,'Pemula','nominal',2000.00,'2025-12-20','2025-12-25',1,'2025-12-20 01:39:56','2025-12-20 01:39:56');

/*Table structure for table `sessions` */

DROP TABLE IF EXISTS `sessions`;

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint unsigned DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `sessions_user_id_index` (`user_id`),
  KEY `sessions_last_activity_index` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `sessions` */

insert  into `sessions`(`id`,`user_id`,`ip_address`,`user_agent`,`payload`,`last_activity`) values 
('rp6mrcemSTSQr0sWCb7TTRjOhXHgBoOpWCrNWSV5',1,'127.0.0.1','Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/143.0.0.0 Safari/537.36 Edg/143.0.0.0','YTo0OntzOjY6Il90b2tlbiI7czo0MDoibUFsWEhKbEoyV1JYVHVCSnRIWEZkc1ljTlF2QVhBN21rQU9FUmVYRyI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MzQ6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9hZG1pbi9vcmRlcnMiO3M6NToicm91dGUiO3M6MTg6ImFkbWluLm9yZGVycy5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjE7fQ==',1766194842);

/*Table structure for table `testimonials` */

DROP TABLE IF EXISTS `testimonials`;

CREATE TABLE `testimonials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `order_id` bigint unsigned NOT NULL,
  `customer_id` bigint unsigned NOT NULL,
  `content` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('pending','approved','rejected') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'pending',
  `approved_by` bigint unsigned DEFAULT NULL,
  `approved_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `testimonials_order_id_foreign` (`order_id`),
  KEY `testimonials_customer_id_foreign` (`customer_id`),
  CONSTRAINT `testimonials_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`) ON DELETE CASCADE,
  CONSTRAINT `testimonials_order_id_foreign` FOREIGN KEY (`order_id`) REFERENCES `orders` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `testimonials` */

/*Table structure for table `users` */

DROP TABLE IF EXISTS `users`;

CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `two_factor_secret` text COLLATE utf8mb4_unicode_ci,
  `two_factor_recovery_codes` text COLLATE utf8mb4_unicode_ci,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'buyer',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `users` */

insert  into `users`(`id`,`name`,`email`,`email_verified_at`,`password`,`two_factor_secret`,`two_factor_recovery_codes`,`two_factor_confirmed_at`,`role`,`remember_token`,`created_at`,`updated_at`) values 
(1,'Admin APK Premium','admin@apkpremium.com','2025-12-13 08:36:54','$2y$12$ufyzVo0DSQlki2HXShOXR.7cNKkpfrqGU9avyZu9FrShxUMIWdC.C',NULL,NULL,NULL,'admin','oq3QIzsJ5lEkzK5Kg3AZnGxg90Akdugt0xCCw1XLaNInMFsH7h4qWU9xjvnc','2025-12-13 08:36:54','2025-12-13 08:36:54'),
(2,'aku','aku@email.com',NULL,'$2y$12$jWNGFTj/TfEu8WRD07Kl6.2Kx55EdnCcdmqJQpE0ySmyhFa9V6p9S',NULL,NULL,NULL,'buyer',NULL,'2025-12-13 08:59:18','2025-12-13 08:59:18'),
(3,'zody','zody@gmail.com',NULL,'$2y$12$sBxAmtF0lIR2MPTsCCOCXeQbPoIjY20u2d7uuBOiS30S5ZAkpG5W6',NULL,NULL,NULL,'buyer',NULL,'2025-12-15 13:14:37','2025-12-15 13:14:37'),
(4,'Silvia','silviazahrani4@gmail.com',NULL,'$2y$12$RWCtCIjStR9cIynr3gIjTO8HYCoeTNwoQwIjcdKV.i0Yuwj/0J3y2',NULL,NULL,NULL,'buyer',NULL,'2025-12-15 15:27:43','2025-12-15 15:27:43'),
(5,'gina','gina@gmail.com',NULL,'$2y$12$/0Hku4Q5kRXI5O2xQuLPseN8m8/pjYYgcbrSjlJGTg.XDjg5vXwkm',NULL,NULL,NULL,'buyer',NULL,'2025-12-16 00:48:36','2025-12-16 00:48:36'),
(6,'Dera Amanda','dera@gmail.com',NULL,'$2y$12$zPp0TbCrKs8.s73ZF2ZYTOzBkinxIuL5nRW4pVfbfZ5WnSBqF5N6i',NULL,NULL,NULL,'buyer',NULL,'2025-12-16 01:43:30','2025-12-16 01:43:30');

/*Table structure for table `websockets_statistics_entries` */

DROP TABLE IF EXISTS `websockets_statistics_entries`;

CREATE TABLE `websockets_statistics_entries` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `connection_id` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ip_address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `payload` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `websockets_statistics_entries_app_id_index` (`app_id`),
  KEY `websockets_statistics_entries_connection_id_index` (`connection_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

/*Data for the table `websockets_statistics_entries` */

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
