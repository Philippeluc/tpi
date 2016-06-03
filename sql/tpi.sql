CREATE DATABASE  IF NOT EXISTS `tpi` /*!40100 DEFAULT CHARACTER SET utf8 */;
USE `tpi`;
-- MySQL dump 10.13  Distrib 5.7.9, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: tpi
-- ------------------------------------------------------
-- Server version	5.6.15-log

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `endroit`
--

DROP TABLE IF EXISTS `endroit`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `endroit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rue` varchar(255) NOT NULL,
  `ville` varchar(255) NOT NULL,
  `pays` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endroit`
--

LOCK TABLES `endroit` WRITE;
/*!40000 ALTER TABLE `endroit` DISABLE KEYS */;
INSERT INTO `endroit` VALUES (6,'26 Rue du Lyon','Genève ','Suisse'),(7,'26 Rue du Lyon','Genève ','Suisse');
/*!40000 ALTER TABLE `endroit` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `evenement`
--

DROP TABLE IF EXISTS `evenement`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `evenement` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL,
  `dateDebut` date NOT NULL,
  `dateFin` date DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `status` int(11) DEFAULT '1' COMMENT '1 correspond ',
  `id_endroit` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_endroit_idx` (`id_endroit`),
  CONSTRAINT `fk_endroit` FOREIGN KEY (`id_endroit`) REFERENCES `endroit` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenement`
--

LOCK TABLES `evenement` WRITE;
/*!40000 ALTER TABLE `evenement` DISABLE KEYS */;
INSERT INTO `evenement` VALUES (2,'Tournois','Tournois de foot junior','2016-06-03','2016-06-04','exempleconcert.jpg',NULL,6),(3,'Tournois','Tournois de foot junior','2016-06-03','2016-06-04','exempleconcert.jpg',1,6);
/*!40000 ALTER TABLE `evenement` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-03 16:22:19
