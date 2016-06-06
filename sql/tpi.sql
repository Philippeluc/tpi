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
-- Table structure for table `commentaire`
--

DROP TABLE IF EXISTS `commentaire`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `commentaire` (
  `time` datetime NOT NULL,
  `texte` text NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  `id_evenement` int(11) NOT NULL,
  PRIMARY KEY (`time`,`id_utilisateur`,`id_evenement`),
  KEY `fk_utilisateur_idx` (`id_utilisateur`),
  KEY `fk_commentaire_utilisateur_idx` (`id_utilisateur`),
  KEY `fk_commentaire_evenement_idx` (`id_evenement`),
  CONSTRAINT `fk_commentaire_evenement` FOREIGN KEY (`id_evenement`) REFERENCES `evenement` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  CONSTRAINT `fk_commentaire_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `commentaire`
--

LOCK TABLES `commentaire` WRITE;
/*!40000 ALTER TABLE `commentaire` DISABLE KEYS */;
INSERT INTO `commentaire` VALUES ('2016-06-06 15:46:37','dfvhkfhsdf',6,1),('2016-06-06 16:02:40','dfdsfdsfdsf',6,1),('2016-06-06 16:22:45','gjhgjhgjghk',10,1),('2016-06-06 16:26:35','dddddddd',10,1),('2016-06-06 16:26:54','e5z hzdtz',6,6),('2016-06-06 16:27:13','123',10,1),('2016-06-06 16:27:24','123',10,6);
/*!40000 ALTER TABLE `commentaire` ENABLE KEYS */;
UNLOCK TABLES;

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
  `iso_pays` varchar(2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_pays_idx` (`iso_pays`),
  CONSTRAINT `fk_pays` FOREIGN KEY (`iso_pays`) REFERENCES `pays` (`iso`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `endroit`
--

LOCK TABLES `endroit` WRITE;
/*!40000 ALTER TABLE `endroit` DISABLE KEYS */;
INSERT INTO `endroit` VALUES (1,'26 Rue Peillonnex','Genève','BG'),(2,'44 Rue du Lys','Paris','BG'),(31,'33 Bourbon Street','Los Angeles','BG'),(39,'aaaa','aaaa','BG'),(40,'33 Place de la gare','Vevey','BG');
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
  `status` int(11) DEFAULT '1' COMMENT '1 = UNBAN\n2 = BAN',
  `id_endroit` int(11) NOT NULL,
  `id_utilisateur` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_endroit_idx` (`id_endroit`),
  KEY `fk_utilisateur_idx` (`id_utilisateur`),
  CONSTRAINT `fk_endroit` FOREIGN KEY (`id_endroit`) REFERENCES `endroit` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_utilisateur` FOREIGN KEY (`id_utilisateur`) REFERENCES `utilisateur` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `evenement`
--

LOCK TABLES `evenement` WRITE;
/*!40000 ALTER TABLE `evenement` DISABLE KEYS */;
INSERT INTO `evenement` VALUES (1,'Tournois','Championnats genevois de badminton','2016-05-05','2016-05-05','badminton.jpg',1,1,6),(2,'Vernissage','Vernissage de l\'exposition d\'art abstrait','2016-06-05','2016-06-05','abstract.jpg',1,2,6),(5,'Festival du film','20 ème festival du films de Sundance','2016-06-17','2016-06-25','5.jpg',1,31,6),(6,'aaaa','aaaa','2016-06-03','2016-06-04','6.jpg',1,39,6),(7,'Concert','Préstation de musique écossaise','2016-06-15','2016-06-21','7.png',1,40,7);
/*!40000 ALTER TABLE `evenement` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `pays`
--

DROP TABLE IF EXISTS `pays`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pays` (
  `iso` varchar(2) NOT NULL,
  `name` varchar(45) NOT NULL,
  PRIMARY KEY (`iso`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `pays`
--

LOCK TABLES `pays` WRITE;
/*!40000 ALTER TABLE `pays` DISABLE KEYS */;
INSERT INTO `pays` VALUES ('AD','Andorra'),('AE','United Arab Emirates'),('AF','Afghanistan'),('AG','Antigua and Barbuda'),('AI','Anguilla'),('AL','Albania'),('AM','Armenia'),('AO','Angola'),('AQ','Antarctica'),('AR','Argentina'),('AS','American Samoa'),('AT','Austria'),('AU','Australia'),('AW','Aruba'),('AX','Aland Islands'),('AZ','Azerbaijan'),('BA','Bosnia and Herzegovina'),('BB','Barbados'),('BD','Bangladesh'),('BE','Belgium'),('BF','Burkina Faso'),('BG','Bulgaria'),('BH','Bahrain'),('BI','Burundi'),('BJ','Benin'),('BL','Saint Barthélemy'),('BM','Bermuda'),('BN','Brunei Darussalam'),('BO','Bolivia, Plurinational State of'),('BQ','Bonaire, Sint Eustatius and Saba'),('BR','Brazil'),('BS','Bahamas'),('BT','Bhutan'),('BV','Bouvet Island'),('BW','Botswana'),('BY','Belarus'),('BZ','Belize'),('CA','Canada'),('CC','Cocos (Keeling) Islands'),('CD','Congo, the Democratic Republic of the'),('CF','Central African Republic'),('CG','Congo'),('CH','Switzerland'),('CI','Côte d\'Ivoire'),('CK','Cook Islands'),('CL','Chile'),('CM','Cameroon'),('CN','China'),('CO','Colombia'),('CR','Costa Rica'),('CU','Cuba'),('CV','Cape Verde'),('CW','Curaçao'),('CX','Christmas Island'),('CY','Cyprus'),('CZ','Czech Republic'),('DE','Germany'),('DJ','Djibouti'),('DK','Denmark'),('DM','Dominica'),('DO','Dominican Republic'),('DZ','Algeria'),('EC','Ecuador'),('EE','Estonia'),('EG','Egypt'),('EH','Western Sahara'),('ER','Eritrea'),('ES','Spain'),('ET','Ethiopia'),('FI','Finland'),('FJ','Fiji'),('FK','Falkland Islands (Malvinas)'),('FM','Micronesia, Federated States of'),('FO','Faroe Islands'),('FR','France'),('GA','Gabon'),('GB','United Kingdom'),('GD','Grenada'),('GE','Georgia'),('GF','French Guiana'),('GG','Guernsey'),('GH','Ghana'),('GI','Gibraltar'),('GL','Greenland'),('GM','Gambia'),('GN','Guinea'),('GP','Guadeloupe'),('GQ','Equatorial Guinea'),('GR','Greece'),('GS','South Georgia and the South Sandwich Islands'),('GT','Guatemala'),('GU','Guam'),('GW','Guinea-Bissau'),('GY','Guyana'),('HK','Hong Kong'),('HM','Heard Island and McDonald Islands'),('HN','Honduras'),('HR','Croatia'),('HT','Haiti'),('HU','Hungary'),('ID','Indonesia'),('IE','Ireland'),('IL','Israel'),('IM','Isle of Man'),('IN','India'),('IO','British Indian Ocean Territory'),('IQ','Iraq'),('IR','Iran, Islamic Republic of'),('IS','Iceland'),('IT','Italy'),('JE','Jersey'),('JM','Jamaica'),('JO','Jordan'),('JP','Japan'),('KE','Kenya'),('KG','Kyrgyzstan'),('KH','Cambodia'),('KI','Kiribati'),('KM','Comoros'),('KN','Saint Kitts and Nevis'),('KP','Korea, Democratic People\'s Republic of'),('KR','Korea, Republic of'),('KW','Kuwait'),('KY','Cayman Islands'),('KZ','Kazakhstan'),('LA','Lao People\'s Democratic Republic'),('LB','Lebanon'),('LC','Saint Lucia'),('LI','Liechtenstein'),('LK','Sri Lanka'),('LR','Liberia'),('LS','Lesotho'),('LT','Lithuania'),('LU','Luxembourg'),('LV','Latvia'),('LY','Libya'),('MA','Morocco'),('MC','Monaco'),('MD','Moldova, Republic of'),('ME','Montenegro'),('MF','Saint Martin (French part)'),('MG','Madagascar'),('MH','Marshall Islands'),('MK','Macedonia, the Former Yugoslav Republic of'),('ML','Mali'),('MM','Myanmar'),('MN','Mongolia'),('MO','Macao'),('MP','Northern Mariana Islands'),('MQ','Martinique'),('MR','Mauritania'),('MS','Montserrat'),('MT','Malta'),('MU','Mauritius'),('MV','Maldives'),('MW','Malawi'),('MX','Mexico'),('MY','Malaysia'),('MZ','Mozambique'),('NA','Namibia'),('NC','New Caledonia'),('NE','Niger'),('NF','Norfolk Island'),('NG','Nigeria'),('NI','Nicaragua'),('NL','Netherlands'),('NO','Norway'),('NP','Nepal'),('NR','Nauru'),('NU','Niue'),('NZ','New Zealand'),('OM','Oman'),('PA','Panama'),('PE','Peru'),('PF','French Polynesia'),('PG','Papua New Guinea'),('PH','Philippines'),('PK','Pakistan'),('PL','Poland'),('PM','Saint Pierre and Miquelon'),('PN','Pitcairn'),('PR','Puerto Rico'),('PS','Palestine, State of'),('PT','Portugal'),('PW','Palau'),('PY','Paraguay'),('QA','Qatar'),('RE','Réunion'),('RO','Romania'),('RS','Serbia'),('RU','Russian Federation'),('RW','Rwanda'),('SA','Saudi Arabia'),('SB','Solomon Islands'),('SC','Seychelles'),('SD','Sudan'),('SE','Sweden'),('SG','Singapore'),('SH','Saint Helena, Ascension and Tristan da Cunha'),('SI','Slovenia'),('SJ','Svalbard and Jan Mayen'),('SK','Slovakia'),('SL','Sierra Leone'),('SM','San Marino'),('SN','Senegal'),('SO','Somalia'),('SR','Suriname'),('SS','South Sudan'),('ST','Sao Tome and Principe'),('SV','El Salvador'),('SX','Sint Maarten (Dutch part)'),('SY','Syrian Arab Republic'),('SZ','Swaziland'),('TC','Turks and Caicos Islands'),('TD','Chad'),('TF','French Southern Territories'),('TG','Togo'),('TH','Thailand'),('TJ','Tajikistan'),('TK','Tokelau'),('TL','Timor-Leste'),('TM','Turkmenistan'),('TN','Tunisia'),('TO','Tonga'),('TR','Turkey'),('TT','Trinidad and Tobago'),('TV','Tuvalu'),('TW','Taiwan, Province of China'),('TZ','Tanzania, United Republic of'),('UA','Ukraine'),('UG','Uganda'),('UM','United States Minor Outlying Islands'),('US','United States'),('UY','Uruguay'),('UZ','Uzbekistan'),('VA','Holy See (Vatican City State)'),('VC','Saint Vincent and the Grenadines'),('VE','Venezuela, Bolivarian Republic of'),('VG','Virgin Islands, British'),('VI','Virgin Islands, U.S.'),('VN','Viet Nam'),('VU','Vanuatu'),('WF','Wallis and Futuna'),('WS','Samoa'),('YE','Yemen'),('YT','Mayotte'),('ZA','South Africa'),('ZM','Zambia'),('ZW','Zimbabwe');
/*!40000 ALTER TABLE `pays` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `utilisateur` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `pseudo` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `status` int(11) NOT NULL DEFAULT '1' COMMENT '1 = UNBAN\n2 = BAN',
  `privilege` int(11) NOT NULL DEFAULT '1' COMMENT '1 = USER\n2 = ADMIN',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (6,'toto@gmail.com','totototo','40bd001563085fc35165329ea1ff5c5ecbdbbeef',1,2),(7,'sebastien.crrt@eduge.ch','seboll13','51eac6b471a284d3341d8c0c63d0f1a286262a18',1,1),(8,'philippe.k@eduge.ch','Philippeluc','40bd001563085fc35165329ea1ff5c5ecbdbbeef',1,2),(9,'linda.k@eduge.ch','Linda56789','51eac6b471a284d3341d8c0c63d0f1a286262a18',1,1),(10,'bonjour@haha.com','Superhahaha','f6889fc97e14b42dec11a8c183ea791c5465b658',1,1);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2016-06-06 16:42:38