-- MySQL dump 10.13  Distrib 8.0.20, for Linux (x86_64)
--
-- Host: 127.0.0.1    Database: smartvalue
-- ------------------------------------------------------
-- Server version	8.0.20-0ubuntu0.20.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `locations_countries`
--

DROP TABLE IF EXISTS `locations_countries`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `locations_countries` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `prefix` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code_index` (`code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=257 DEFAULT CHARSET=utf8;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `locations_countries`
--

LOCK TABLES `locations_countries` WRITE;
/*!40000 ALTER TABLE `locations_countries` DISABLE KEYS */;
INSERT INTO `locations_countries` VALUES (1,'Romania','RO','+40'),(2,'France','FR','+33'),(3,'Australia','AU','+61'),(4,'Belgium','BE','+32'),(5,'Canada','CA','+1'),(6,'China','CN','+86'),(7,'Finland','FI','+358'),(8,'Germany','DE','+49'),(9,'Greece','GR','+30'),(10,'Italy','IT','+39'),(11,'Spain','ES','+34'),(12,'United Kingdom','GB','+44'),(13,'United States','US','+1'),(14,'Afghanistan','AF','+93'),(15,'Albania','AL','+355'),(16,'Algeria','DZ','+213'),(17,'American Samoa','AS','+1684'),(18,'Andorra','AD','+376'),(19,'Angola','AO','+244'),(20,'Anguilla','AI','+1264'),(21,'Antarctica','AQ','+672'),(22,'Antigua and Barbuda','AG','+1268'),(23,'Argentina','AR','+54'),(24,'Armenia','AM','+374'),(25,'Aruba','AW','+297'),(26,'Austria','AT','+43'),(27,'Azerbaijan','AZ','+994'),(28,'Bahamas','BS','+1242'),(29,'Bahrain','BH','+973'),(30,'Bangladesh','BD','+880'),(31,'Barbados','BB','+1246'),(32,'Belarus','BY','+375'),(33,'Belize','BZ','+501'),(34,'Benin','BJ','+229'),(35,'Bermuda','BM','+1441'),(36,'Bhutan','BT','+975'),(37,'Bolivia','BO','+591'),(38,'Bosnia and Herzegovina','BA','+387'),(39,'Botswana','BW','+267'),(40,'Brazil','BR','+55'),(41,'British Virgin Islands','VG','+1284'),(42,'Brunei','BN','+673'),(43,'Bulgaria','BG','+359'),(44,'Burkina Faso','BF','+226'),(45,'Burma (Myanmar)','MM','+95'),(46,'Burundi','BI','+257'),(47,'Cambodia','KH','+855'),(48,'Cameroon','CM','+237'),(49,'Cape Verde','CV','+238'),(50,'Cayman Islands','KY','+1345'),(51,'Central African Republic','CF','+236'),(52,'Chad','TD','+235'),(53,'Chile','CL','+56'),(54,'Christmas Island','CX','+61'),(55,'Cocos (Keeling) Islands','CC','+61'),(56,'Colombia','CO','+57'),(57,'Comoros','KM','+269'),(58,'Cook Islands','CK','+682'),(59,'Costa Rica','CR','+506'),(60,'Croatia','HR','+385'),(61,'Cuba','CU','+53'),(62,'Cyprus','CY','+357'),(63,'Czech Republic','CZ','+420'),(64,'Democratic Republic of the Congo','CD','+243'),(65,'Denmark','DK','+45'),(66,'Djibouti','DJ','+253'),(67,'Dominica','DM','+1767'),(68,'Dominican Republic','DO','+1809'),(69,'Ecuador','EC','+593'),(70,'Egypt','EG','+20'),(71,'El Salvador','SV','+503'),(72,'Equatorial Guinea','GQ','+240'),(73,'Eritrea','ER','+291'),(74,'Estonia','EE','+372'),(75,'Ethiopia','ET','+251'),(76,'Falkland Islands','FK','+500'),(77,'Faroe Islands','FO','+298'),(78,'Fiji','FJ','+679'),(79,'French Polynesia','PF','+689'),(80,'Gabon','GA','+241'),(81,'Gambia','GM','+220'),(82,'Gaza Strip','','+970'),(83,'Georgia','GE','+995'),(84,'Ghana','GH','+233'),(85,'Gibraltar','GI','+350'),(86,'Greenland','GL','+299'),(87,'Grenada','GD','+1473'),(88,'Guam','GU','+1671'),(89,'Guatemala','GT','+502'),(90,'Guinea','GN','+224'),(91,'Guinea-Bissau','GW','+245'),(92,'Guyana','GY','+592'),(93,'Haiti','HT','+509'),(94,'Holy See (Vatican City)','VA','+39'),(95,'Honduras','HN','+504'),(96,'Hong Kong','HK','+852'),(97,'Hungary','HU','+36'),(98,'Iceland','IS','+354'),(99,'India','IN','+91'),(100,'Indonesia','ID','+62'),(101,'Iran','IR','+98'),(102,'Iraq','IQ','+964'),(103,'Ireland','IE','+353'),(104,'Isle of Man','IM','+44'),(105,'Israel','IL','+972'),(106,'Ivory Coast','CI','+225'),(107,'Jamaica','JM','+1876'),(108,'Japan','JP','+81'),(109,'Jordan','JO','+962'),(110,'Kazakhstan','KZ','+7'),(111,'Kenya','KE','+254'),(112,'Kiribati','KI','+686'),(113,'Kosovo','','+381'),(114,'Kuwait','KW','+965'),(115,'Kyrgyzstan','KG','+996'),(116,'Laos','LA','+856'),(117,'Latvia','LV','+371'),(118,'Lebanon','LB','+961'),(119,'Lesotho','LS','+266'),(120,'Liberia','LR','+231'),(121,'Libya','LY','+218'),(122,'Liechtenstein','LI','+423'),(123,'Lithuania','LT','+370'),(124,'Luxembourg','LU','+352'),(125,'Macau','MO','+853'),(126,'Macedonia','MK','+389'),(127,'Madagascar','MG','+261'),(128,'Malawi','MW','+265'),(129,'Malaysia','MY','+60'),(130,'Maldives','MV','+960'),(131,'Mali','ML','+223'),(132,'Malta','MT','+356'),(133,'Marshall Islands','MH','+692'),(134,'Mauritania','MR','+222'),(135,'Mauritius','MU','+230'),(136,'Mayotte','YT','+262'),(137,'Mexico','MX','+52'),(138,'Micronesia','FM','+691'),(139,'Moldova','MD','+373'),(140,'Monaco','MC','+377'),(141,'Mongolia','MN','+976'),(142,'Montenegro','ME','+382'),(143,'Montserrat','MS','+1664'),(144,'Morocco','MA','+212'),(145,'Mozambique','MZ','+258'),(146,'Namibia','NA','+264'),(147,'Nauru','NR','+674'),(148,'Nepal','NP','+977'),(149,'Netherlands','NL','+31'),(150,'Netherlands Antilles','AN','+599'),(151,'New Caledonia','NC','+687'),(152,'New Zealand','NZ','+64'),(153,'Nicaragua','NI','+505'),(154,'Niger','NE','+227'),(155,'Nigeria','NG','+234'),(156,'Niue','NU','+683'),(157,'Norfolk Island','','+672'),(158,'North Korea','KP','+850'),(159,'Northern Mariana Islands','MP','+1670'),(160,'Norway','NO','+47'),(161,'Oman','OM','+968'),(162,'Pakistan','PK','+92'),(163,'Palau','PW','+680'),(164,'Panama','PA','+507'),(165,'Papua New Guinea','PG','+675'),(166,'Paraguay','PY','+595'),(167,'Peru','PE','+51'),(168,'Philippines','PH','+63'),(169,'Pitcairn Islands','PN','+870'),(170,'Poland','PL','+48'),(171,'Portugal','PT','+351'),(172,'Puerto Rico','PR','+1'),(173,'Qatar','QA','+974'),(174,'Republic of the Congo','CG','+242'),(175,'Russia','RU','+7'),(176,'Rwanda','RW','+250'),(177,'Saint Barthelemy','BL','+590'),(178,'Saint Helena','SH','+290'),(179,'Saint Kitts and Nevis','KN','+1869'),(180,'Saint Lucia','LC','+1758'),(181,'Saint Martin','MF','+1599'),(182,'Saint Pierre and Miquelon','PM','+508'),(183,'Saint Vincent and the Grenadines','VC','+1784'),(184,'Samoa','WS','+685'),(185,'San Marino','SM','+378'),(186,'Sao Tome and Principe','ST','+239'),(187,'Saudi Arabia','SA','+966'),(188,'Senegal','SN','+221'),(189,'Serbia','RS','+381'),(190,'Seychelles','SC','+248'),(191,'Sierra Leone','SL','+232'),(192,'Singapore','SG','+65'),(193,'Slovakia','SK','+421'),(194,'Slovenia','SI','+386'),(195,'Solomon Islands','SB','+677'),(196,'Somalia','SO','+252'),(197,'South Africa','ZA','+27'),(198,'South Korea','KR','+82'),(199,'Sri Lanka','LK','+94'),(200,'Sudan','SD','+249'),(201,'Suriname','SR','+597'),(202,'Swaziland','SZ','+268'),(203,'Sweden','SE','+46'),(204,'Switzerland','CH','+41'),(205,'Syria','SY','+963'),(206,'Taiwan','TW','+886'),(207,'Tajikistan','TJ','+992'),(208,'Tanzania','TZ','+255'),(209,'Thailand','TH','+66'),(210,'Timor-Leste','TL','+670'),(211,'Togo','TG','+228'),(212,'Tokelau','TK','+690'),(213,'Tonga','TO','+676'),(214,'Trinidad and Tobago','TT','+1868'),(215,'Tunisia','TN','+216'),(216,'Turkey','TR','+90'),(217,'Turkmenistan','TM','+993'),(218,'Turks and Caicos Islands','TC','+1649'),(219,'Tuvalu','TV','+688'),(220,'Uganda','UG','+256'),(221,'Ukraine','UA','+380'),(222,'United Arab Emirates','AE','+971'),(223,'Uruguay','UY','+598'),(224,'US Virgin Islands','VI','+1340'),(225,'Uzbekistan','UZ','+998'),(226,'Vanuatu','VU','+678'),(227,'Venezuela','VE','+58'),(228,'Vietnam','VN','+84'),(229,'Wallis and Futuna','WF','+681'),(230,'West Bank','','+970'),(231,'Yemen','YE','+967'),(232,'Zambia','ZM','+260'),(233,'Zimbabwe','ZW','+263');
/*!40000 ALTER TABLE `locations_countries` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-07-28 12:18:15
