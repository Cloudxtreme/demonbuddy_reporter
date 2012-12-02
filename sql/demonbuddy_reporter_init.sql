-- --------------------------------------------------------
-- Host:                         localhost
-- Server version:               5.5.27 - MySQL Community Server (GPL)
-- Server OS:                    Win32
-- HeidiSQL version:             7.0.0.4053
-- Date/time:                    2012-12-01 20:01:17
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET FOREIGN_KEY_CHECKS=0 */;

-- Dumping structure for table demonbuddy_reporter.ci_sessions
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `session_id` varchar(40) NOT NULL DEFAULT '0',
  `ip_address` varchar(45) NOT NULL DEFAULT '0',
  `user_agent` varchar(120) NOT NULL,
  `last_activity` int(10) unsigned NOT NULL DEFAULT '0',
  `user_data` text NOT NULL,
  PRIMARY KEY (`session_id`),
  KEY `last_activity_idx` (`last_activity`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping data for table demonbuddy_reporter.ci_sessions: ~0 rows (approximately)
/*!40000 ALTER TABLE `ci_sessions` DISABLE KEYS */;
/*!40000 ALTER TABLE `ci_sessions` ENABLE KEYS */;


-- Dumping structure for table demonbuddy_reporter.db_characters
CREATE TABLE IF NOT EXISTS `db_characters` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `class` varchar(15) DEFAULT NULL,
  `color` varchar(10) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=latin1;

-- Dumping structure for table demonbuddy_reporter.db_items
CREATE TABLE IF NOT EXISTS `db_items` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  `item_slot_id` int(11) NOT NULL,
  `item_type_id` int(11) NOT NULL,
  `score` int(11) NOT NULL,
  `legendary` tinyint(1) NOT NULL,
  `character_id` int(10) NOT NULL,
  `date_added` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_db_items_db_item_types` (`item_type_id`),
  KEY `FK_db_items_db_item_slots` (`item_slot_id`),
  CONSTRAINT `FK_db_items_db_item_slots` FOREIGN KEY (`item_slot_id`) REFERENCES `db_item_slots` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  CONSTRAINT `FK_db_items_db_item_types` FOREIGN KEY (`item_type_id`) REFERENCES `db_item_types` (`id`) ON DELETE CASCADE ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=602 DEFAULT CHARSET=latin1;


-- Dumping structure for table demonbuddy_reporter.db_item_slots
CREATE TABLE IF NOT EXISTS `db_item_slots` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=32 DEFAULT CHARSET=latin1;

-- Dumping data for table demonbuddy_reporter.db_item_slots: ~7 rows (approximately)
/*!40000 ALTER TABLE `db_item_slots` DISABLE KEYS */;
INSERT INTO `db_item_slots` (`id`, `name`) VALUES
	(11, 'WeaponTwoHand'),
	(12, 'WeaponOneHand'),
	(13, 'Jewelry'),
	(14, 'WeaponRange'),
	(15, 'Armor'),
	(16, 'FollowerItem'),
	(17, 'Offhand');
/*!40000 ALTER TABLE `db_item_slots` ENABLE KEYS */;

-- Dumping structure for table demonbuddy_reporter.db_item_stats
CREATE TABLE IF NOT EXISTS `db_item_stats` (
  `item_id` int(10) NOT NULL,
  `stat_id` int(10) NOT NULL,
  `value` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Dumping structure for table demonbuddy_reporter.db_item_types
CREATE TABLE IF NOT EXISTS `db_item_types` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

-- Dumping data for table demonbuddy_reporter.db_item_types: ~42 rows (approximately)
/*!40000 ALTER TABLE `db_item_types` DISABLE KEYS */;
INSERT INTO `db_item_types` (`id`, `name`) VALUES
	(15, 'TwoHandDaibo'),
	(16, 'Axe'),
	(17, 'CeremonialKnife'),
	(18, 'Ring'),
	(19, 'HandCrossbow'),
	(20, 'SpiritStone'),
	(21, 'TwoHandMace'),
	(22, 'Shoulders'),
	(23, 'FollowerEnchantress'),
	(24, 'FistWeapon'),
	(25, 'Dagger'),
	(26, 'VoodooMask'),
	(27, 'TwoHandCrossbow'),
	(28, 'Bracers'),
	(29, 'TwoHandStaff'),
	(30, 'Sword'),
	(31, 'Mojo'),
	(32, 'FollowerScoundrel'),
	(33, 'Boots'),
	(34, 'TwoHandMighty'),
	(35, 'Spear'),
	(36, 'Chest'),
	(37, 'Wand'),
	(38, 'WizardHat'),
	(39, 'Gloves'),
	(40, 'TwoHandAxe'),
	(41, 'Mace'),
	(42, 'Source'),
	(43, 'MightyBelt'),
	(44, 'Amulet'),
	(45, 'TwoHandBow'),
	(46, 'Cloak'),
	(47, 'Belt'),
	(48, 'Helm'),
	(49, 'TwoHandSword'),
	(51, 'Shield'),
	(52, 'Pants'),
	(53, 'FollowerTemplar'),
	(55, 'Quiver'),
	(56, 'MightyWeapon'),
	(57, 'TwoHandPolearm');
/*!40000 ALTER TABLE `db_item_types` ENABLE KEYS */;


-- Dumping structure for table demonbuddy_reporter.db_stats
CREATE TABLE IF NOT EXISTS `db_stats` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=198 DEFAULT CHARSET=latin1;

-- Dumping data for table demonbuddy_reporter.db_stats: ~28 rows (approximately)
/*!40000 ALTER TABLE `db_stats` DISABLE KEYS */;
INSERT INTO `db_stats` (`id`, `name`) VALUES
	(29, 'Dexterity'),
	(30, 'DPS'),
	(31, 'Vitality'),
	(32, 'Life On Hit'),
	(33, 'Intelligence'),
	(34, 'Max Mana'),
	(35, '+Min Damage'),
	(36, '+Max Damage'),
	(37, '+All Resist'),
	(38, 'Globe Bonus'),
	(39, 'Life Steal %'),
	(40, 'Sockets'),
	(41, 'Crit Damage %'),
	(42, 'Life %'),
	(43, 'Life Regen'),
	(44, 'Thorns'),
	(45, '+Highest Single Resist'),
	(46, 'Armor'),
	(47, 'Arcane-On-Crit'),
	(48, 'Mana Regen'),
	(49, 'Strength'),
	(50, 'Gold Find   %'),
	(51, 'Movement Speed %'),
	(52, 'Crit Chance %'),
	(53, 'Pickup Radius'),
	(54, 'Magic Find %'),
	(55, 'Attack Speed %'),
	(57, 'Total Block %');
/*!40000 ALTER TABLE `db_stats` ENABLE KEYS */;
/*!40014 SET FOREIGN_KEY_CHECKS=1 */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
