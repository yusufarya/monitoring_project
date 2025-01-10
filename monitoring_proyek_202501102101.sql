-- MySQL dump 10.13  Distrib 8.0.19, for Win64 (x86_64)
--
-- Host: localhost    Database: monitoring_project
-- ------------------------------------------------------
-- Server version	9.0.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `daily_job_report_details`
--

DROP TABLE IF EXISTS `daily_job_report_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_job_report_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `daily_report_id` bigint unsigned NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
  `weight` double NOT NULL DEFAULT '0',
  `total_weight` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_job_report_details_daily_report_id_foreign` (`daily_report_id`),
  CONSTRAINT `daily_job_report_details_daily_report_id_foreign` FOREIGN KEY (`daily_report_id`) REFERENCES `daily_job_reports` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_job_report_details`
--

LOCK TABLES `daily_job_report_details` WRITE;
/*!40000 ALTER TABLE `daily_job_report_details` DISABLE KEYS */;
INSERT INTO `daily_job_report_details` VALUES (8,3,'2.23.01','Penahan tanah galian dari papan kayu, dolken, balok kayu /Trench support or retaining wll (wooden)','M2',5,87899.68,439498.4,3.22,0,'2024-12-13 18:32:16','2024-12-13 18:32:16'),(9,3,'6.2.01','Manual Boring  / road crossing Ø 50 - 80 mm','M\'',20,269015.12,5380302.4,39.44,0,'2024-12-13 18:32:34','2024-12-13 18:32:34'),(10,3,'5.2.04','Sambung pipa baru ke jaringan yang ada - Ø 200 mm','Buah',1,771454.91,771454.91,5.66,0,'2024-12-13 18:32:54','2024-12-13 18:32:54'),(11,3,'4.2.03','Pasang Valve Ø 80 mm','Buah',1,534015.78,534015.78,3.91,0,'2024-12-13 18:33:05','2024-12-13 18:33:05'),(13,3,'10.3.10','Pasang Paving /interblock lama / installing exisiting of paving / interblock','M2',10,48827.46,488274.6,3.58,0,'2024-12-18 01:30:41','2024-12-18 01:30:41'),(14,3,'10.2.02','Galian Tanah Keras termasuk pembuangan bekas galian dan angkutan dengan dump truk / excavation of hard soil include disposal (authorized land field) of excavated and transportation with dump truck','M3',30,168475.36,5054260.8,37.05,0,'2024-12-18 01:31:06','2024-12-18 01:31:06'),(15,4,'10.2.02','Galian Tanah Keras termasuk pembuangan bekas galian dan angkutan dengan dump truk / excavation of hard soil include disposal (authorized land field) of excavated and transportation with dump truck','M3',10,168475.36,1684753.6,12.35,0,'2024-12-21 14:02:04','2024-12-21 14:02:04');
/*!40000 ALTER TABLE `daily_job_report_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_job_reports`
--

DROP TABLE IF EXISTS `daily_job_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_job_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `spk_number` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractor_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_project` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_contract` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_total_job` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_total_material` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-13',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_job_reports`
--

LOCK TABLES `daily_job_reports` WRITE;
/*!40000 ALTER TABLE `daily_job_reports` DISABLE KEYS */;
INSERT INTO `daily_job_reports` VALUES (3,'SPK/909090909','Proyek ABC','Carolyn Torres','Tangerang','23719516.14','13641321.07','10078195.07','2024-12-13','2024-12-13 18:31:54','2024-12-13 18:31:54'),(4,'SPK/909090909','Proyek ABC','Carolyn Torres','Tangerang','23719516.14','13641321.07','10078195.07','2024-12-21','2024-12-21 14:01:56','2024-12-21 14:01:56');
/*!40000 ALTER TABLE `daily_job_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_material_report_details`
--

DROP TABLE IF EXISTS `daily_material_report_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_material_report_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `daily_report_id` bigint unsigned NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
  `weight` double NOT NULL DEFAULT '0',
  `total_weight` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `daily_material_report_details_daily_report_id_foreign` (`daily_report_id`),
  CONSTRAINT `daily_material_report_details_daily_report_id_foreign` FOREIGN KEY (`daily_report_id`) REFERENCES `daily_material_reports` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_material_report_details`
--

LOCK TABLES `daily_material_report_details` WRITE;
/*!40000 ALTER TABLE `daily_material_report_details` DISABLE KEYS */;
INSERT INTO `daily_material_report_details` VALUES (7,1,'AA2060G095','TEE DCI ALL FLANGE,PN-10,ND 200X200X80 MM','EA',1,2269668.8,2269668.8,22.52,0,'2024-12-13 17:59:28','2024-12-13 17:59:28'),(8,1,'AJ0032C087','GATE VALVE DCI,ND   80 MM,FL-FL,PN-10,(SHORT BODY C/W OPR CAP)','EA',1,2125056.36,2125056.36,21.09,0,'2024-12-13 17:59:45','2024-12-13 17:59:45'),(9,1,'AA5151J035','FLANGE ADAPTOR UNIV.DCI,ID RANGE 200 -225 MM,PN-10,MECH.JOINT','EA',2,1149301.19,2298602.38,22.81,0,'2024-12-13 17:59:57','2024-12-13 17:59:57'),(10,1,'AJ6010D281','SURFACE BOX DCI,ND 160X80 MM','EA',1,271260.37,271260.37,2.69,0,'2024-12-13 18:00:05','2024-12-13 18:00:05'),(12,2,'AC0310C089','PIPE HDPE Sp-Sp, PE-100, PN-10, OD   90 MM','M',20,49427.54,988550.8,9.81,0,'2024-12-14 18:27:30','2024-12-14 18:27:30'),(13,2,'AJ6010D281','SURFACE BOX DCI,ND 160X80 MM','EA',1,271260.37,271260.37,2.69,0,'2024-12-21 14:00:57','2024-12-21 14:00:57');
/*!40000 ALTER TABLE `daily_material_report_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `daily_material_reports`
--

DROP TABLE IF EXISTS `daily_material_reports`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `daily_material_reports` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint NOT NULL,
  `spk_number` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractor_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_project` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_contract` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_total_job` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_total_material` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-13',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `daily_material_reports`
--

LOCK TABLES `daily_material_reports` WRITE;
/*!40000 ALTER TABLE `daily_material_reports` DISABLE KEYS */;
INSERT INTO `daily_material_reports` VALUES (1,1,'SPK/909090909','Proyek ABC','Carolyn Torres','Tangerang','23719516.14','13641321.07','10078195.07','2024-12-13','2024-12-13 17:53:01','2024-12-13 17:58:35'),(2,1,'SPK/909090909','Proyek ABC','Carolyn Torres','Tangerang','23719516.14','13641321.07','10078195.07','2024-12-14','2024-12-14 18:27:24','2024-12-14 18:28:24');
/*!40000 ALTER TABLE `daily_material_reports` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_jobs`
--

DROP TABLE IF EXISTS `m_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_jobs_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_jobs`
--

LOCK TABLES `m_jobs` WRITE;
/*!40000 ALTER TABLE `m_jobs` DISABLE KEYS */;
INSERT INTO `m_jobs` VALUES (1,'10.2.02','Galian Tanah Keras termasuk pembuangan bekas galian dan angkutan dengan dump truk / excavation of hard soil include disposal (authorized land field) of excavated and transportation with dump truck','M3',168475.36,'2024-12-13 17:39:05','2024-12-13 17:39:05'),(2,'2.23.01','Penahan tanah galian dari papan kayu, dolken, balok kayu /Trench support or retaining wll (wooden)','M2',87899.68,'2024-12-13 17:39:20','2024-12-13 17:39:20'),(3,'6.2.01','Manual Boring  / road crossing Ø 50 - 80 mm','M\'',269015.12,'2024-12-13 17:39:38','2024-12-13 17:39:38'),(4,'5.2.04','Sambung pipa baru ke jaringan yang ada - Ø 200 mm','Buah',771454.91,'2024-12-13 17:39:57','2024-12-13 17:39:57'),(5,'4.2.03','Pasang Valve Ø 80 mm','Buah',534015.78,'2024-12-13 17:40:17','2024-12-13 17:40:17'),(6,'10.3.10','Pasang Paving /interblock lama / installing exisiting of paving / interblock','M2',48827.46,'2024-12-13 17:40:36','2024-12-13 17:40:36');
/*!40000 ALTER TABLE `m_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `m_materials`
--

DROP TABLE IF EXISTS `m_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `m_materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `price` double(15,2) NOT NULL DEFAULT '0.00',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `m_materials_code_unique` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `m_materials`
--

LOCK TABLES `m_materials` WRITE;
/*!40000 ALTER TABLE `m_materials` DISABLE KEYS */;
INSERT INTO `m_materials` VALUES (1,'AC0310C089','PIPE HDPE Sp-Sp, PE-100, PN-10, OD   90 MM','M',49427.54,'2024-12-13 17:40:56','2024-12-13 17:40:56'),(2,'AA2060G095','TEE DCI ALL FLANGE,PN-10,ND 200X200X80 MM','EA',2269668.80,'2024-12-13 17:41:32','2024-12-13 17:41:32'),(3,'AJ0032C087','GATE VALVE DCI,ND   80 MM,FL-FL,PN-10,(SHORT BODY C/W OPR CAP)','EA',2125056.36,'2024-12-13 17:41:55','2024-12-13 17:41:55'),(4,'AA5151J035','FLANGE ADAPTOR UNIV.DCI,ID RANGE 200 -225 MM,PN-10,MECH.JOINT','EA',1149301.19,'2024-12-13 17:42:26','2024-12-13 17:42:26'),(5,'AJ6010D281','SURFACE BOX DCI,ND 160X80 MM','EA',271260.37,'2024-12-13 17:42:52','2024-12-13 17:42:52');
/*!40000 ALTER TABLE `m_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material_pickup_details`
--

DROP TABLE IF EXISTS `material_pickup_details`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_pickup_details` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `material_pickup_id` bigint unsigned NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `material_pickup_details_material_pickup_id_foreign` (`material_pickup_id`),
  CONSTRAINT `material_pickup_details_material_pickup_id_foreign` FOREIGN KEY (`material_pickup_id`) REFERENCES `material_pickups` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_pickup_details`
--

LOCK TABLES `material_pickup_details` WRITE;
/*!40000 ALTER TABLE `material_pickup_details` DISABLE KEYS */;
INSERT INTO `material_pickup_details` VALUES (1,1,'AC0310C089','PIPE HDPE Sp-Sp, PE-100, PN-10, OD   90 MM','M',20,'2024-12-13 18:04:22','2024-12-13 18:04:22'),(2,1,'AA2060G095','TEE DCI ALL FLANGE,PN-10,ND 200X200X80 MM','EA',1,'2024-12-13 18:04:31','2024-12-13 18:04:31'),(4,1,'AA5151J035','FLANGE ADAPTOR UNIV.DCI,ID RANGE 200 -225 MM,PN-10,MECH.JOINT','EA',2,'2024-12-13 18:04:54','2024-12-13 18:04:54'),(9,4,'AJ6010D281','SURFACE BOX DCI,ND 160X80 MM','EA',1,'2024-12-13 19:50:56','2024-12-13 19:50:56'),(11,1,'AJ0032C087','GATE VALVE DCI,ND   80 MM,FL-FL,PN-10,(SHORT BODY C/W OPR CAP)','EA',2,'2025-01-05 12:01:58','2025-01-05 12:01:58');
/*!40000 ALTER TABLE `material_pickup_details` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `material_pickups`
--

DROP TABLE IF EXISTS `material_pickups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `material_pickups` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint NOT NULL,
  `spk_number` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `contractor_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_project` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_contract` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_total_job` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_total_material` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date` date NOT NULL DEFAULT '2024-12-13',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `material_pickups`
--

LOCK TABLES `material_pickups` WRITE;
/*!40000 ALTER TABLE `material_pickups` DISABLE KEYS */;
INSERT INTO `material_pickups` VALUES (1,1,'SPK/909090909','Proyek ABC','Carolyn Torres','Tangerang','23719516.14','13641321.07','10078195.07','2024-12-13','2024-12-13 18:04:05','2024-12-13 18:04:05'),(4,1,'SPK/909090909','Proyek ABC','Carolyn Torres','Tangerang','23719516.14','13641321.07','10078195.07','2024-12-12','2024-12-13 19:09:08','2024-12-13 19:09:08');
/*!40000 ALTER TABLE `material_pickups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `migrations` (
  `id` int unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=21 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `migrations`
--

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2014_10_12_000000_create_user_levels_table',1),(2,'2014_10_12_000001_create_users_table',1),(3,'2014_10_12_100000_create_password_reset_tokens_table',1),(4,'2019_08_19_000000_create_failed_jobs_table',1),(5,'2019_12_14_000001_create_personal_access_tokens_table',1),(6,'2023_11_01_180721_create_admin_levels_table copy',1),(7,'2023_11_01_181900_create_admins_table',1),(8,'2024_09_13_161210_create_projects_table',1),(9,'2024_09_13_205702_create_m_jobs_table',1),(10,'2024_09_13_205702_create_m_materials_table',1),(11,'2024_09_13_211211_create_t_jobs_table',1),(12,'2024_09_13_211211_create_t_materials_table',1),(13,'2024_10_02_222133_create_daily_job_reports_table',1),(14,'2024_10_02_222154_create_daily_material_reports_table',1),(15,'2024_10_03_002150_create_daily_job_report_details_table',1),(16,'2024_10_03_002204_create_daily_material_report_details_table',1),(17,'2024_11_09_180827_create_balance_reports_table',1),(18,'2024_11_09_180923_create_balance_report_details_table',1),(19,'2024_11_10_140720_create_material_pickups_table',1),(20,'2024_11_10_141115_create_material_pickup_details_table',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `projects`
--

DROP TABLE IF EXISTS `projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `projects` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `date` date NOT NULL DEFAULT '2024-12-13',
  `supervisor_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `operator_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `spk_number` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `project_name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `start_date` date NOT NULL DEFAULT '2024-12-13',
  `end_date` date NOT NULL DEFAULT '2024-12-13',
  `contractor_name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `location_project` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value_contract` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `projects`
--

LOCK TABLES `projects` WRITE;
/*!40000 ALTER TABLE `projects` DISABLE KEYS */;
INSERT INTO `projects` VALUES (1,'2024-12-07','Nadi','Nana','SPK/909090909','Proyek ABC','2024-12-07','2024-12-09','Carolyn Torres','Tangerang','23719516.14','2024-12-13 17:44:28','2024-12-13 17:44:28');
/*!40000 ALTER TABLE `projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_jobs`
--

DROP TABLE IF EXISTS `t_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_jobs` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_jobs_project_id_foreign` (`project_id`),
  CONSTRAINT `t_jobs_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_jobs`
--

LOCK TABLES `t_jobs` WRITE;
/*!40000 ALTER TABLE `t_jobs` DISABLE KEYS */;
INSERT INTO `t_jobs` VALUES (1,1,'10.2.02','Galian Tanah Keras termasuk pembuangan bekas galian dan angkutan dengan dump truk / excavation of hard soil include disposal (authorized land field) of excavated and transportation with dump truck','M3',30,168475.36,5054260.8,'2024-12-13 17:44:55','2024-12-13 17:44:55'),(2,1,'2.23.01','Penahan tanah galian dari papan kayu, dolken, balok kayu /Trench support or retaining wll (wooden)','M2',10,87899.68,878996.8,'2024-12-13 17:45:15','2024-12-13 17:45:15'),(3,1,'6.2.01','Manual Boring  / road crossing Ø 50 - 80 mm','M\'',20,269015.12,5380302.4,'2024-12-13 17:45:27','2024-12-13 17:45:27'),(4,1,'5.2.04','Sambung pipa baru ke jaringan yang ada - Ø 200 mm','Buah',1,771454.91,771454.91,'2024-12-13 17:45:38','2024-12-13 17:45:38'),(5,1,'4.2.03','Pasang Valve Ø 80 mm','Buah',2,534015.78,1068031.56,'2024-12-13 17:45:48','2024-12-13 17:45:48'),(6,1,'10.3.10','Pasang Paving /interblock lama / installing exisiting of paving / interblock','M2',10,48827.46,488274.6,'2024-12-13 17:45:56','2024-12-13 17:45:56');
/*!40000 ALTER TABLE `t_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `t_materials`
--

DROP TABLE IF EXISTS `t_materials`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `t_materials` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `project_id` bigint unsigned NOT NULL,
  `code` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `unit` char(10) COLLATE utf8mb4_unicode_ci NOT NULL,
  `qty` double NOT NULL DEFAULT '0',
  `price` double NOT NULL DEFAULT '0',
  `total_price` double NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `t_materials_project_id_foreign` (`project_id`),
  CONSTRAINT `t_materials_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `projects` (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `t_materials`
--

LOCK TABLES `t_materials` WRITE;
/*!40000 ALTER TABLE `t_materials` DISABLE KEYS */;
INSERT INTO `t_materials` VALUES (1,1,'AC0310C089','PIPE HDPE Sp-Sp, PE-100, PN-10, OD   90 MM','M',20,49427.54,988550.8,'2024-12-13 17:46:13','2024-12-13 17:46:13'),(2,1,'AA2060G095','TEE DCI ALL FLANGE,PN-10,ND 200X200X80 MM','EA',1,2269668.8,2269668.8,'2024-12-13 17:46:21','2024-12-13 17:46:21'),(3,1,'AJ0032C087','GATE VALVE DCI,ND   80 MM,FL-FL,PN-10,(SHORT BODY C/W OPR CAP)','EA',2,2125056.36,4250112.72,'2024-12-13 17:46:31','2024-12-13 17:46:31'),(4,1,'AA5151J035','FLANGE ADAPTOR UNIV.DCI,ID RANGE 200 -225 MM,PN-10,MECH.JOINT','EA',2,1149301.19,2298602.38,'2024-12-13 17:46:35','2024-12-13 17:46:35'),(6,1,'AJ6010D281','SURFACE BOX DCI,ND 160X80 MM','EA',1,271260.37,271260.37,'2024-12-13 17:58:10','2024-12-13 17:58:10');
/*!40000 ALTER TABLE `t_materials` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `user_levels`
--

DROP TABLE IF EXISTS `user_levels`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `user_levels` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `user_levels`
--

LOCK TABLES `user_levels` WRITE;
/*!40000 ALTER TABLE `user_levels` DISABLE KEYS */;
INSERT INTO `user_levels` VALUES (1,'Manager'),(2,'Operator'),(3,'Admin');
/*!40000 ALTER TABLE `user_levels` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `users` (
  `number` char(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` char(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `gender` enum('M','F') COLLATE utf8mb4_unicode_ci NOT NULL,
  `place_of_birth` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `no_telp` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `address` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `level_id` bigint unsigned NOT NULL,
  `is_active` enum('Y','N') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'N',
  `images` text COLLATE utf8mb4_unicode_ci,
  `created_at` datetime DEFAULT '2024-12-13 17:33:30',
  `created_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  `updated_by` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`number`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  KEY `users_level_id_foreign` (`level_id`),
  CONSTRAINT `users_level_id_foreign` FOREIGN KEY (`level_id`) REFERENCES `user_levels` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `users`
--

LOCK TABLES `users` WRITE;
/*!40000 ALTER TABLE `users` DISABLE KEYS */;
INSERT INTO `users` VALUES ('ADM202411050001','Admin','admin','M',NULL,NULL,'08986564321',NULL,'admin@gmail.com','$2y$10$JrSOx3/nWt.YPDCjo7vVdezrYhneaK8tSVBBFShCqJsvmw3lRBDcC',3,'Y',NULL,'2024-12-13 17:33:31','admin',NULL,NULL),('ADM202412210002','Herby','herby','M','Tangerang','2024-12-21','08122346789','Kp. Kondang Rt04 Rw02 Kec. Sukadiri Kab. Tng\r\n12','aryaherby29nov2k@gmail.com','$2y$10$SjAy0rnll3vWKgvVKMgQteN6FKgoyaHq5L9WXX8ozKqlRHBdXO2ea',3,'Y','profile-images/tuEMYoBkLpPnZFRAUTALclqyvf0eA6qZ3EDLB4Ml.png','2024-12-21 14:10:15','admin','2024-12-21 14:10:35','admin'),('MNG202411050001','Manager','manager','F',NULL,NULL,'08986564321',NULL,'manager@gmail.com','$2y$10$Udzm0lIg0wl/z5FQv1rJpuHyDzTuYFrxrp3ZJuAK3fngCE7pIGav2',1,'Y',NULL,'2024-12-13 17:33:31','admin',NULL,NULL),('OPR202411050001','Operator','operator','M',NULL,NULL,'08986564321',NULL,'operator@gmail.com','$2y$10$Nbkz3dh.sSC9VtcexMJBa.Q847oDxSmKoucP2LJXGq373YM.QVnma',2,'Y',NULL,'2024-12-13 17:33:31','admin',NULL,NULL);
/*!40000 ALTER TABLE `users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Dumping routines for database 'monitoring_project'
--
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-10 21:01:47
