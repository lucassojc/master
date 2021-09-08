/*
 Navicat Premium Data Transfer

 Source Server         : PlanJavnihNabavki
 Source Server Type    : MySQL
 Source Server Version : 100136
 Source Host           : localhost:3306
 Source Schema         : pjn

 Target Server Type    : MySQL
 Target Server Version : 100136
 File Encoding         : 65001

 Date: 16/09/2019 09:09:47
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for administrator
-- ----------------------------
DROP TABLE IF EXISTS `administrator`;
CREATE TABLE `administrator`  (
  `administrator_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `username` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `password` varchar(128) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  PRIMARY KEY (`administrator_id`) USING BTREE,
  UNIQUE INDEX `uk_administrator_username`(`username`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 8 CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of administrator
-- ----------------------------
INSERT INTO `administrator` VALUES (1, 'Admin', 'admin');
INSERT INTO `administrator` VALUES (2, 'Kvalitet', 'kvalitet');
INSERT INTO `administrator` VALUES (3, 'ITS', 'its');
INSERT INTO `administrator` VALUES (4, 'Baze podataka', 'baze');
INSERT INTO `administrator` VALUES (5, 'Održavanje sistema', 'odrzavanje');
INSERT INTO `administrator` VALUES (6, 'Informativni centar', 'info');
INSERT INTO `administrator` VALUES (7, 'BZR', 'bzr');

-- ----------------------------
-- Table structure for plan_javnih_nabavki
-- ----------------------------
DROP TABLE IF EXISTS `plan_javnih_nabavki`;
CREATE TABLE `plan_javnih_nabavki`  (
  `plan_javnih_nabavki_id` int(10) NOT NULL AUTO_INCREMENT,
  `vrsta_predmeta` enum('Добра','Услуге','Радови') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `vrsta_postupka` enum('Отворени поступак','Набавка мале вредности','Преговарачки поступак') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `opis_pjn` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `iznos_sa_pdv` decimal(10, 2) NULL DEFAULT NULL,
  `iznos_bez_pdv` decimal(10, 2) NULL DEFAULT NULL,
  `godina_2019` decimal(10, 2) NULL DEFAULT NULL,
  `godina_2020` decimal(10, 2) NULL DEFAULT NULL,
  `godina_2021` decimal(10, 2) NULL DEFAULT NULL,
  `postupak_pokrenut_at` date NULL DEFAULT NULL,
  `ugovor_zakljucen_at` date NULL DEFAULT NULL,
  `ugovor_izvrsen_at` date NULL DEFAULT NULL,
  `napomena` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `razlog` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `program_poslovanja_id` int(10) NULL DEFAULT NULL,
  `administrator_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`plan_javnih_nabavki_id`) USING BTREE,
  INDEX `fk_plan_javnih_nabavki_administrator_id`(`administrator_id`) USING BTREE,
  INDEX `fk_plan_javnih_nabavki_program_poslovanja_id`(`program_poslovanja_id`) USING BTREE,
  CONSTRAINT `fk_plan_javnih_nabavki_administrator_id` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`administrator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_plan_javnih_nabavki_program_poslovanja_id` FOREIGN KEY (`program_poslovanja_id`) REFERENCES `program_poslovanja` (`program_poslovanja_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 35 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of plan_javnih_nabavki
-- ----------------------------
INSERT INTO `plan_javnih_nabavki` VALUES (28, 'Услуге', 'Набавка мале вредности', 'Neki opis za ovu nabavku', 1200000.00, 1000000.00, 1000000.00, 0.00, 0.00, '2019-08-14', '2019-08-14', '2019-08-06', 'Napomena za javnu nabavku', 'neki razlog', 2, 1);
INSERT INTO `plan_javnih_nabavki` VALUES (30, 'Добра', 'Отворени поступак', 'dasasdasd', 1200000.00, 2000000.00, 1000000.00, 0.00, 0.00, '2019-09-13', '2019-09-13', '2019-09-19', 'fffffffff', 'fffff', 6, 1);
INSERT INTO `plan_javnih_nabavki` VALUES (31, 'Добра', 'Отворени поступак', 'rrrrrrrr', 240000.00, 99999999.99, 200000.00, 100000.00, 700000.00, '2019-09-18', '2019-09-11', '2019-09-17', '', '', 3, 1);
INSERT INTO `plan_javnih_nabavki` VALUES (32, 'Услуге', 'Отворени поступак', 'predmet', 60000.00, 5000000.00, 50000.00, 8000.00, 0.00, '2019-09-27', '2019-09-19', '2019-09-19', '', 'razloggg', 4, 1);
INSERT INTO `plan_javnih_nabavki` VALUES (33, 'Услуге', 'Набавка мале вредности', 'dsasdsda', 1200000.00, 2000000.00, 1000000.00, 0.00, 0.00, '2019-09-20', '2019-09-18', '2019-09-12', 'asdds', 'saddsa', 2, 1);
INSERT INTO `plan_javnih_nabavki` VALUES (34, 'Радови', 'Набавка мале вредности', 'neki ', 60000.00, 99999999.99, 50000.00, 100000.00, 700000.00, '2019-09-20', '2019-09-19', '2019-09-19', 'asdasds', 'asdasd', 6, 1);

-- ----------------------------
-- Table structure for plan_javnih_nabavki_godina
-- ----------------------------
DROP TABLE IF EXISTS `plan_javnih_nabavki_godina`;
CREATE TABLE `plan_javnih_nabavki_godina`  (
  `plan_javnih_nabavki_id` int(10) NOT NULL,
  `godina_2019` decimal(10, 2) NULL DEFAULT NULL,
  `godina_2020` decimal(10, 2) NULL DEFAULT NULL,
  `godina_2021` decimal(10, 2) NULL DEFAULT NULL,
  INDEX `fk_godina_plan_javnih_nabavki_id`(`plan_javnih_nabavki_id`) USING BTREE,
  CONSTRAINT `fk_godina_plan_javnih_nabavki_id` FOREIGN KEY (`plan_javnih_nabavki_id`) REFERENCES `plan_javnih_nabavki` (`plan_javnih_nabavki_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB CHARACTER SET = latin1 COLLATE = latin1_swedish_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of plan_javnih_nabavki_godina
-- ----------------------------
INSERT INTO `plan_javnih_nabavki_godina` VALUES (30, NULL, NULL, NULL);

-- ----------------------------
-- Table structure for program_poslovanja
-- ----------------------------
DROP TABLE IF EXISTS `program_poslovanja`;
CREATE TABLE `program_poslovanja`  (
  `program_poslovanja_id` int(10) NOT NULL AUTO_INCREMENT,
  `konto` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `opis_pp` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `iznos` decimal(10, 2) NOT NULL,
  PRIMARY KEY (`program_poslovanja_id`) USING BTREE,
  UNIQUE INDEX `uk_konto`(`konto`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 74 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of program_poslovanja
-- ----------------------------
INSERT INTO `program_poslovanja` VALUES (1, '1.1.6.', 'Opis za ovaj plan poslovanja', 1200000.00);
INSERT INTO `program_poslovanja` VALUES (2, '2.2.6.1.', 'Program poslovanja za odredjene planove javnih nabavki', 5000000.00);
INSERT INTO `program_poslovanja` VALUES (3, '5.5.56.', 'Opisno za ovaj program poslovanja', 500000.00);
INSERT INTO `program_poslovanja` VALUES (4, '1.1.5.6.8.', 'Opis za edit probu', 120000.00);
INSERT INTO `program_poslovanja` VALUES (5, '5.5.56.    sd', 'Opisno za ovaj program poslovanja', 500000.00);
INSERT INTO `program_poslovanja` VALUES (6, '1.1.5.6.8.8.', 'Opis za edit probu', 120000.00);
INSERT INTO `program_poslovanja` VALUES (47, '2.23.123.124', 'opiss dasdsasddddsss', 100000.00);
INSERT INTO `program_poslovanja` VALUES (48, '2.23.123.45', 'sd a s asa sd ', 200000.00);
INSERT INTO `program_poslovanja` VALUES (49, '2.23.122.3.3.', 'ddd', 30000.00);
INSERT INTO `program_poslovanja` VALUES (50, '2.234.123.6', '', 4000.00);
INSERT INTO `program_poslovanja` VALUES (51, '2.23.123.7', '', 500000.00);
INSERT INTO `program_poslovanja` VALUES (53, '2.23.123.1246', 'opiss dasdsasddddsss', 100000.00);
INSERT INTO `program_poslovanja` VALUES (54, '6', 'sd a s asa sd ', 200000.00);
INSERT INTO `program_poslovanja` VALUES (55, '434', 'ddd', 30000.00);
INSERT INTO `program_poslovanja` VALUES (56, '432342442', 'dsadds s sa', 4000.00);
INSERT INTO `program_poslovanja` VALUES (57, '342324', 'sd sa sa sd ', 500000.00);
INSERT INTO `program_poslovanja` VALUES (58, '5', 'opiss dasdsasddddsss', 100000.00);
INSERT INTO `program_poslovanja` VALUES (59, '4', 'sd a s asa sd ', 200000.00);
INSERT INTO `program_poslovanja` VALUES (60, '3', 'ddd', 30000.00);
INSERT INTO `program_poslovanja` VALUES (61, '2', 'dsadds s sas', 4000.00);
INSERT INTO `program_poslovanja` VALUES (62, '1', 'sd sa sa sd ', 500000.00);
INSERT INTO `program_poslovanja` VALUES (63, '25', 'opiss dasdsasddddsss', 100000.00);
INSERT INTO `program_poslovanja` VALUES (64, '24', 'sd a s asa sd ', 200000.00);
INSERT INTO `program_poslovanja` VALUES (65, '233', 'ddd', 30000.00);
INSERT INTO `program_poslovanja` VALUES (66, '222', 'dsadds s sa', 4000.00);
INSERT INTO `program_poslovanja` VALUES (67, '21', 'sd sa sa sd ', 500000.00);
INSERT INTO `program_poslovanja` VALUES (69, '1111111', 'opiss dasdsasddddsss', 100000.00);
INSERT INTO `program_poslovanja` VALUES (70, '22222222', 'sd a s asa sd ', 200000.00);
INSERT INTO `program_poslovanja` VALUES (71, '33333333333', 'ddd', 30000.00);
INSERT INTO `program_poslovanja` VALUES (72, '44444444444', 'dsadds s sa', 4000.00);
INSERT INTO `program_poslovanja` VALUES (73, '5555555555', 'sd sa sa sd ', 500000.00);

-- ----------------------------
-- Table structure for realizacija_sprovodjenja_nabavke
-- ----------------------------
DROP TABLE IF EXISTS `realizacija_sprovodjenja_nabavke`;
CREATE TABLE `realizacija_sprovodjenja_nabavke`  (
  `realizacija_sprovodjenja_nabavke_id` int(10) NOT NULL AUTO_INCREMENT,
  `plan_javnih_nabavki_id` int(10) NOT NULL,
  `broj` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `zahtev_pokrenut_at` date NULL DEFAULT NULL,
  `odluka_donesena_at` date NULL DEFAULT NULL,
  `resenje_at` date NULL DEFAULT NULL,
  `izjava_at` date NULL DEFAULT NULL,
  `dokumentacija_direktor_at` date NULL DEFAULT NULL,
  `dokumentacija_ojn_at` date NULL DEFAULT NULL,
  `ponuda_otvorena_at` date NULL DEFAULT NULL,
  `administrator_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`realizacija_sprovodjenja_nabavke_id`) USING BTREE,
  INDEX `fk_realizacija_sprovodjenja_nabavke_administrator_id`(`administrator_id`) USING BTREE,
  INDEX `fk_realizacija_sprovodjenja_nabavke_pjn_id`(`plan_javnih_nabavki_id`) USING BTREE,
  CONSTRAINT `fk_realizacija_sprovodjenja_nabavke_administrator_id` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`administrator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_realizacija_sprovodjenja_nabavke_pjn_id` FOREIGN KEY (`plan_javnih_nabavki_id`) REFERENCES `plan_javnih_nabavki` (`plan_javnih_nabavki_id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 21 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of realizacija_sprovodjenja_nabavke
-- ----------------------------
INSERT INTO `realizacija_sprovodjenja_nabavke` VALUES (19, 28, '12/12', '2019-09-09', '2019-09-16', '2019-09-03', '2019-09-09', '2019-09-15', '2019-09-01', '2019-09-24', 1);
INSERT INTO `realizacija_sprovodjenja_nabavke` VALUES (20, 33, '54/82', '2019-09-06', '2019-09-06', '2019-09-06', '2019-09-03', '2019-09-10', '2019-09-13', '2019-09-28', 1);

-- ----------------------------
-- Table structure for realizacija_ugovora
-- ----------------------------
DROP TABLE IF EXISTS `realizacija_ugovora`;
CREATE TABLE `realizacija_ugovora`  (
  `realizacija_ugovora_id` int(10) NOT NULL AUTO_INCREMENT,
  `plan_javnih_nabavki_id` int(10) NULL DEFAULT NULL,
  `broj` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `datum_ugovora_at` date NULL DEFAULT NULL,
  `suma` decimal(10, 2) NULL DEFAULT NULL,
  `dobavljac` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `trajanje` int(10) NULL DEFAULT NULL,
  `realizacija` decimal(10, 2) NULL DEFAULT NULL,
  `ugovor_realizovan_at` date NULL DEFAULT NULL,
  `cilj` varchar(128) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `potroseno_planirano` decimal(10, 2) NULL DEFAULT NULL,
  `status` enum('Није реализован','Реализован','Реализација у току') CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
  `napomena` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `razlog_neizvrsenja` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL,
  `administrator_id` int(10) UNSIGNED NULL DEFAULT NULL,
  PRIMARY KEY (`realizacija_ugovora_id`) USING BTREE,
  INDEX `fk_realizacija_ugovora_pjn_id`(`plan_javnih_nabavki_id`) USING BTREE,
  INDEX `administrator_id`(`administrator_id`) USING BTREE,
  CONSTRAINT `fk_realizacija_ugovora_administrator_id` FOREIGN KEY (`administrator_id`) REFERENCES `administrator` (`administrator_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_realizacija_ugovora_plan_javnih_nabavki_id` FOREIGN KEY (`plan_javnih_nabavki_id`) REFERENCES `plan_javnih_nabavki` (`plan_javnih_nabavki_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE = InnoDB AUTO_INCREMENT = 40 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Compact;

-- ----------------------------
-- Records of realizacija_ugovora
-- ----------------------------
INSERT INTO `realizacija_ugovora` VALUES (38, 28, '1/52', '2019-09-03', 120000.00, 'sdasad', 36, 20000.00, '2019-09-17', '10000.00', 25000.00, 'Реализација у току', 'dsdas', 'dsas', 1);
INSERT INTO `realizacija_ugovora` VALUES (39, 28, '25/85', '2019-09-17', 20000.00, 'kkkk', 24, 10000.00, '2019-09-10', '50%', 10000.00, 'Реализација у току', '', '', 1);

SET FOREIGN_KEY_CHECKS = 1;
