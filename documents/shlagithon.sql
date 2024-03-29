SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

DROP SCHEMA IF EXISTS `shlagithon`;
CREATE SCHEMA IF NOT EXISTS `shlagithon`;

USE `shlagithon`; /*thomaslaure_shlagithon*/

DROP TABLE IF EXISTS `step`;
CREATE TABLE IF NOT EXISTS `step` (
    `s_id` int(11) NOT NULL AUTO_INCREMENT,
    `s_description` text NOT NULL,
    `s_order` int(11) NOT NULL,
    `s_fk_recipe_id` int(11) NOT NULL,
    PRIMARY KEY(`s_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `comment`;
CREATE TABLE IF NOT EXISTS `comment` (
    `c_id` int(11) NOT NULL AUTO_INCREMENT,
    `c_text` text NOT NULL,
    `c_writing_date` datetime NOT NULL DEFAULT current_timestamp(),
    `c_fk_member_id` int(11) NOT NULL,
    `c_fk_recipe_id` int(11) NOT NULL,
    PRIMARY KEY (`c_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `recipe_tag`;
CREATE TABLE IF NOT EXISTS `recipe_tag` (
    `rt_fk_recipe_id` int(11) NOT NULL,
    `rt_fk_tag_id` int(11) NOT NULL,
    PRIMARY KEY(`rt_fk_recipe_id`, `rt_fk_tag_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `tag`;
CREATE TABLE IF NOT EXISTS `tag` (
    `t_id` int(11) NOT NULL AUTO_INCREMENT,
    `t_label` varchar(255) NOT NULL,
    PRIMARY KEY(`t_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `requirement_allergen`;
CREATE TABLE IF NOT EXISTS `requirement_allergen` (
    `ra_fk_requirement_id` int(11) NOT NULL,
    `ra_fk_allergen_id` int(11) NOT NULL,
    PRIMARY KEY(`ra_fk_requirement_id`, `ra_fk_allergen_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `allergen`;
CREATE TABLE IF NOT EXISTS `allergen` (
    `a_id` int(11) NOT NULL AUTO_INCREMENT,
    `a_label` varchar(255) NOT NULL,
    PRIMARY KEY(`a_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `recipe_requirement`;
CREATE TABLE IF NOT EXISTS `recipe_requirement` (
    `rr_fk_recipe_id` int(11) NOT NULL,
    `rr_fk_requirement_id` int(11) NOT NULL,
    `rr_quantity` varchar(255) NOT NULL,
    PRIMARY KEY (`rr_fk_recipe_id`, `rr_fk_requirement_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `requirement`;
CREATE TABLE IF NOT EXISTS `requirement` (
    `req_id` int(11) NOT NULL AUTO_INCREMENT,
    `req_label` varchar(255) NOT NULL,
    `req_type` ENUM('USTENCIL', 'INGREDIENT') NOT NULL,
    PRIMARY KEY (`req_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `recipe_member`;
CREATE TABLE IF NOT EXISTS `recipe_member` (
    `rm_fk_recipe_id` int(11) NOT NULL,
    `rm_fk_member_id` int(11) NOT NULL,
    PRIMARY KEY(`rm_fk_recipe_id`, `rm_fk_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `recipe`;
CREATE TABLE IF NOT EXISTS `recipe` (
    `rec_id` int(11) NOT NULL AUTO_INCREMENT,
    `rec_name` varchar(255) NOT NULL,
    `rec_description` text NOT NULL,
    `rec_image` varchar(255) NOT NULL,
    `rec_difficulty` ENUM('1', '2', '3', '4', '5') NOT NULL,
    `rec_time` int(11) NOT NULL,
    `rec_nb_persons` int(11) NOT NULL,
    `rec_advice` text NULL,
    `rec_type` ENUM('ENTREE', 'PLAT', 'DESSERT', 'AUTRE') NOT NULL,
    `rec_fk_member_id` int(11) NOT NULL,
    PRIMARY KEY (`rec_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `ticket_answer`;
CREATE TABLE IF NOT EXISTS `ticket_answer` (
  `ti_a_id` int(11) NOT NULL AUTO_INCREMENT,
  `ti_a_text` text COLLATE utf8_unicode_ci NOT NULL,
  `ti_a_writing_date` datetime NOT NULL,
  `ti_a_fk_ticket_id` int(11) NOT NULL,
  `ti_a_fk_member_id`int(11) NOT NULL,
  PRIMARY KEY (`ti_a_id`),
  KEY `fk_ticket_answer_ticket` (`ti_a_fk_ticket_id`),
  KEY `fk_ticket_answer_member` (`ti_a_fk_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `ti_id` int(11) NOT NULL AUTO_INCREMENT,
  `ti_subject` text COLLATE utf8_unicode_ci NOT NULL,
  `ti_text` text COLLATE utf8_unicode_ci NOT NULL,
  `ti_writing_date` datetime NOT NULL,
  `ti_last_update` datetime NOT NULL,
  `ti_is_resolved` tinyint(4) NOT NULL DEFAULT 0,
  `ti_fk_member_id` int(11) NOT NULL,
  PRIMARY KEY (`ti_id`),
  KEY `fk_ticket_member` (`ti_fk_member_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

DROP TABLE IF EXISTS `member`;
CREATE TABLE IF NOT EXISTS `member` (
    `m_id` int(11) NOT NULL AUTO_INCREMENT,
    `m_name` varchar(255) NOT NULL,
    `m_firstname` varchar(255) NOT NULL,
    `m_email` varchar(255) NOT NULL,
    `m_password` varchar(255) NOT NULL,
    `m_type` ENUM('MEMBER', 'ADMIN') NOT NULL DEFAULT 'MEMBER',
    `m_is_confirmed` boolean NOT NULL DEFAULT 0,
    `m_is_deleted` boolean NOT NULL DEFAULT 0,
    `m_creation_date` datetime NOT NULL,
    `m_last_connection_date` datetime NULL,
    PRIMARY KEY (`m_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_roman_ci;

-- ALTER TABLE `requirement_allergen` DROP FOREIGN KEY `fk_requirement_allergen_allergen`;
ALTER TABLE `requirement_allergen` ADD CONSTRAINT `fk_requirement_allergen_allergen` FOREIGN KEY (`ra_fk_allergen_id`) REFERENCES `allergen`(`a_id`) ON DELETE CASCADE;

-- ALTER TABLE `requirement_allergen` DROP FOREIGN KEY `fk_requirement_allergen_requirement`;
ALTER TABLE `requirement_allergen` ADD CONSTRAINT `fk_requirement_allergen_requirement` FOREIGN KEY (`ra_fk_requirement_id`) REFERENCES `requirement`(`req_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe_requirement` DROP FOREIGN KEY `fk_recipe_requirement_requirement`;
ALTER TABLE `recipe_requirement` ADD CONSTRAINT `fk_recipe_requirement_requirement` FOREIGN KEY (`rr_fk_requirement_id`) REFERENCES `requirement`(`req_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe_requirement` DROP FOREIGN KEY `fk_recipe_requirement_recipe`;
ALTER TABLE `recipe_requirement` ADD CONSTRAINT `fk_recipe_requirement_recipe` FOREIGN KEY (`rr_fk_recipe_id`) REFERENCES `recipe`(`rec_id`) ON DELETE CASCADE;

-- ALTER TABLE `step` DROP FOREIGN KEY `fk_step`;
ALTER TABLE `step` ADD CONSTRAINT `fk_step` FOREIGN KEY (`s_fk_recipe_id`) REFERENCES `recipe`(`rec_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe_tag` DROP FOREIGN KEY `fk_recipe_tag_tag`;
ALTER TABLE `recipe_tag` ADD CONSTRAINT `fk_recipe_tag_tag` FOREIGN KEY (`rt_fk_tag_id`) REFERENCES `tag`(`t_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe_tag` DROP FOREIGN KEY `fk_recipe_tag_recipe`;
ALTER TABLE `recipe_tag` ADD CONSTRAINT `fk_recipe_tag_recipe` FOREIGN KEY (`rt_fk_recipe_id`) REFERENCES `recipe`(`rec_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe` DROP FOREIGN KEY `fk_recipe`;
ALTER TABLE `recipe` ADD CONSTRAINT `fk_recipe` FOREIGN KEY (`rec_fk_member_id`) REFERENCES `member`(`m_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe_member` DROP FOREIGN KEY `fk_recipe_member_recipe`;
ALTER TABLE `recipe_member` ADD CONSTRAINT `fk_recipe_member_recipe` FOREIGN KEY (`rm_fk_recipe_id`) REFERENCES `recipe`(`rec_id`) ON DELETE CASCADE;

-- ALTER TABLE `recipe_member` DROP FOREIGN KEY `fk_recipe_member_member`;
ALTER TABLE `recipe_member` ADD CONSTRAINT `fk_recipe_member_member` FOREIGN KEY (`rm_fk_member_id`) REFERENCES `member`(`m_id`) ON DELETE CASCADE;

-- ALTER TABLE `comment` DROP FOREIGN KEY `fk_comment_member`;
ALTER TABLE `comment` ADD CONSTRAINT `fk_comment_member` FOREIGN KEY (`c_fk_member_id`) REFERENCES `member`(`m_id`) ON DELETE CASCADE;

-- ALTER TABLE `comment` DROP FOREIGN KEY `fk_comment_recipe`;
ALTER TABLE `comment` ADD CONSTRAINT `fk_comment_recipe` FOREIGN KEY (`c_fk_recipe_id`) REFERENCES `recipe`(`rec_id`) ON DELETE CASCADE;

-- ALTER TABLE `ticket` DROP FOREIGN KEY `fk_ticket_member_id`;
ALTER TABLE `ticket` ADD CONSTRAINT `fk_ticket_member_id` FOREIGN KEY (`ti_fk_member_id`) REFERENCES `member` (`m_id`) ON DELETE CASCADE;

-- ALTER TABLE `ticket_answer` DROP FOREIGN KEY `fk_ticket_answer_ticket`;
ALTER TABLE `ticket_answer` ADD CONSTRAINT `fk_ticket_answer_ticket` FOREIGN KEY (`ti_a_fk_ticket_id`) REFERENCES `ticket` (`ti_id`) ON DELETE CASCADE;

-- ALTER TABLE `ticket_answer` DROP FOREIGN KEY `fk_ticket_answer_member`;
ALTER TABLE `ticket_answer` ADD CONSTRAINT `fk_ticket_answer_member` FOREIGN KEY (`ti_a_fk_member_id`) REFERENCES `member` (`m_id`) ON DELETE CASCADE;