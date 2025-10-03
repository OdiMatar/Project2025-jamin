-- Step: 01
-- Goal: Create a new database Laravel
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            04-04-2023      Arjan de Ruijter            New
-- **********************************************************************************/

-- Check if the database exists
DROP DATABASE IF EXISTS `laravel`;

-- Create a new Database
CREATE DATABASE IF NOT EXISTS `laravel` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Use database laravel
USE `laravel`;


-- Database kiezen
USE `laravel`;


CREATE TABLE `Allergeen` (
  `Id`               SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam`             VARCHAR(30)       NOT NULL,
  `Omschrijving`     VARCHAR(80)       NOT NULL,
  `IsActief`         BIT               NOT NULL DEFAULT b'1',
  `Opmerkingen`      VARCHAR(250)               DEFAULT NULL,
  `DatumAangemaakt`  DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd`   DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  CONSTRAINT `PK_Allergeen_Id` PRIMARY KEY (`Id`)
) ENGINE=InnoDB;


INSERT INTO `Allergeen` (`Naam`, `Omschrijving`) VALUES
  ('Gluten',        'Dit product bevat gluten'),
  ('Gelatine',      'Dit product bevat gelatine'),
  ('AZO-Kleurstof', 'Dit product bevat AZO-kleurstoffen'),
  ('Lactose',       'Dit product bevat lactose'),
  ('Soja',          'Dit product bevat soja');



-- Step: 04
-- Goal: Create a new table Product
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            17-09-2025      Odi Matar                   New
-- **********************************************************************************/


CREATE TABLE IF NOT EXISTS `Product` (
  `Id`                TINYINT UNSIGNED  NOT NULL AUTO_INCREMENT,
  `Naam`              VARCHAR(30)       NOT NULL,
  `Barcode`           VARCHAR(13)       NOT NULL,
  `IsActief`          BIT               NOT NULL DEFAULT b'1',
  `Opmerkingen`       VARCHAR(250)               DEFAULT NULL,
  `DatumAangemaakt`   DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd`    DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  CONSTRAINT `PK_Product_Id` PRIMARY KEY (`Id`)
) ENGINE=InnoDB;


-- Step: 05
-- Goal: Fill table Product with data
-- **********************************************************************************

-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01          17-09-2025       Odi Matar                     New
-- **********************************************************************************/

INSERT INTO `Product` (`Naam`, `Barcode`) VALUES
('Mintnopjes', '8719587231278'),
('Schoolkrijt', '8719587326713'),
('Honingdrop', '8719587327836'),
('Zure Beren', '8719587321441'),
('Cola Flesjes', '8719587321237'),
('Turtles', '8719587322245'),
('Witte Muizen', '8719587328256'),
('Reuzen Slangen', '8719587325641'),
('Zoute Rijen', '8719587322739'),
('Winegums', '8719587327527'),
('Drop Munten', '8719587322345'),
('Kruis Drop', '8719587322265'),
('Zoute Ruitjes', '8719587323256');

    -- Step: 06
-- Goal: Create a new table Magazijn
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            17-09-2025      Odi Matar                    New
-- **********************************************************************************/

-- Drop table Magazijn


CREATE TABLE IF NOT EXISTS `Magazijn` (
  `Id`                 TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `ProductId`          TINYINT UNSIGNED NOT NULL,
  `VerpakkingsEenheid` DECIMAL(5,2)     NOT NULL,
  `AantalAanwezig`     INT                      DEFAULT NULL,
  `IsActief`           BIT               NOT NULL DEFAULT b'1',
  `Opmerkingen`        VARCHAR(250)               DEFAULT NULL,
  `DatumAangemaakt`    DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd`     DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  CONSTRAINT `PK_Magazijn_Id` PRIMARY KEY (`Id`),
  CONSTRAINT `FK_Magazijn_Product` FOREIGN KEY (`ProductId`) REFERENCES `Product`(`Id`)
) ENGINE=InnoDB;

-- Step: 07
-- Goal: Fill table Magazijn with data
-- **********************************************************************************

-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            17-09-2025      Odi Matar                    New
-- **********************************************************************************/
INSERT INTO `Magazijn` (`Id`, `ProductId`, `VerpakkingsEenheid`, `AantalAanwezig`) VALUES
 (1, 1, 5.00, 453),
 (2, 2, 2.50, 400),
 (3, 3, 5.00, 1),
 (4, 4, 1.00, 800),
 (5, 5, 3.00, 234),
 (6, 6, 2.00, 345),
 (7, 7, 1.00, 795),
 (8, 8, 3.00, 233),
 (9, 9, 2.50, 123),
 (10, 10, 3.00, NULL),
 (11, 11, 2.00, 367),
 (12, 12, 1.00, 467),
 (13, 13, 5.00, 20);


-- Step: 08
-- Goal: Create a new table Leverancier
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            17-09-2025      Odi Matar			          New
-- **********************************************************************************/



CREATE TABLE IF NOT EXISTS `Leverancier` (
  `Id`                 TINYINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `Naam`               VARCHAR(50)      NOT NULL,
  `ContactPersoon`     VARCHAR(50)      NOT NULL,
  `LeverancierNummer`  VARCHAR(20)      NOT NULL,
  `Mobiel`             VARCHAR(15)      NOT NULL,
  `IsActief`           BIT              NOT NULL DEFAULT b'1',
  `Opmerkingen`        VARCHAR(250)               DEFAULT NULL,
  `DatumAangemaakt`    DATETIME(6)      NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd`     DATETIME(6)      NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  CONSTRAINT `PK_Leverancier_Id` PRIMARY KEY (`Id`)
) ENGINE=InnoDB;





-- Step: 09
-- Goal: Fill table Levernacier with data
-- **********************************************************************************

-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01           17-09-2025      Odi Matar			          New
-- **********************************************************************************/



INSERT INTO `Leverancier` (`Id`, `Naam`, `ContactPersoon`, `LeverancierNummer`, `Mobiel`) VALUES
(1, 'Venco',         'Bert van Linge',    'L1029384719', '06-28493827'),
(2, 'Astra Sweets',  'Jasper del Monte',  'L1029284315', '06-39398734'),
(3, 'Haribo',        'Sven Stalman',      'L1029324748', '06-24383291'),
(4, 'Basset',        'Joyce Stelterberg', 'L1023845773', '06-48293823'),
(5, 'De Bron',       'Remco Veenstra',    'L1023857736', '06-34291234');



-- Step: 12
-- Goal: Create a new table ProductPerAllergeen
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            18-09-2025      Odi Matar                   New
-- **********************************************************************************/

CREATE TABLE IF NOT EXISTS `ProductPerAllergeen` (
  `Id`               INT                 NOT NULL AUTO_INCREMENT,
  `ProductId`        TINYINT  UNSIGNED   NOT NULL,
  `AllergeenId`      SMALLINT UNSIGNED   NOT NULL,
  `IsActief`         BIT                 NOT NULL DEFAULT b'1',
  `Opmerkingen`      VARCHAR(250)                 DEFAULT NULL,
  `DatumAangemaakt`  DATETIME(6)         NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd`   DATETIME(6)         NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  CONSTRAINT `PK_ProductPerAllergeen_Id` PRIMARY KEY (`Id`),
  CONSTRAINT `FK_PpA_Product`   FOREIGN KEY (`ProductId`)  REFERENCES `Product`(`Id`),
  CONSTRAINT `FK_PpA_Allergeen` FOREIGN KEY (`AllergeenId`) REFERENCES `Allergeen`(`Id`),
  CONSTRAINT `UQ_ProductPerAllergeen` UNIQUE (`ProductId`, `AllergeenId`)
) ENGINE=InnoDB;


-- Step: 13
-- Goal: Fill table ProductPerAllergeen with data
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            18-09-2025      Odi Matar                   New
-- **********************************************************************************/

INSERT INTO `ProductPerAllergeen` (`Id`, `ProductId`, `AllergeenId`) VALUES
(1, 1, 2),
(2, 1, 1),
(3, 1, 3),
(4, 3, 4),
(5, 6, 5),
(6, 9, 2),
(7, 9, 5),
(8, 10, 2),
(9, 12, 4),
(10, 13, 1),
(11, 13, 4),
(12, 13, 5);

-- Step: 08
-- Goal: Create a new table Productleverancier
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            17-09-2025      Odi Matar			          New
-- **********************************************************************************/


CREATE TABLE IF NOT EXISTS `ProductPerLeverancier` (
  `Id`                         INT               NOT NULL AUTO_INCREMENT,
  `LeverancierId`              TINYINT UNSIGNED  NOT NULL,
  `ProductId`                  TINYINT UNSIGNED  NOT NULL,
  `DatumLevering`              DATE              NOT NULL,
  `Aantal`                     INT               NOT NULL,
  `DatumEerstVolgendeLevering` DATE                       DEFAULT NULL,
  `IsActief`                   BIT               NOT NULL DEFAULT b'1',
  `Opmerkingen`                VARCHAR(250)               DEFAULT NULL,
  `DatumAangemaakt`            DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6),
  `DatumGewijzigd`             DATETIME(6)       NOT NULL DEFAULT CURRENT_TIMESTAMP(6) ON UPDATE CURRENT_TIMESTAMP(6),
  CONSTRAINT `PK_ProductPerLeverancier_Id` PRIMARY KEY (`Id`),
  CONSTRAINT `FK_PpL_Product`     FOREIGN KEY (`ProductId`)     REFERENCES `Product`(`Id`),
  CONSTRAINT `FK_PpL_Leverancier` FOREIGN KEY (`LeverancierId`) REFERENCES `Leverancier`(`Id`)
) ENGINE=InnoDB;

-- Step: 08
-- Goal: Create a new table ProductPerLeveracier
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            17-09-2025      Odi Matar                   New
-- **********************************************************************************/


INSERT INTO `ProductPerLeverancier`
(`Id`, `LeverancierId`, `ProductId`, `DatumLevering`, `Aantal`, `DatumEerstVolgendeLevering`) VALUES
(1,  1,  1,  '2024-10-09', 23, '2024-10-16'),
(2,  1,  1,  '2024-10-18', 21, '2024-10-25'),
(3,  1,  2,  '2024-10-09', 12, '2024-10-16'),
(4,  1,  3,  '2024-10-10', 11, '2024-10-17'),
(5,  2,  4,  '2024-10-14', 16, '2024-10-21'),
(6,  2,  4,  '2024-10-21', 23, '2024-10-28'),
(7,  2,  5,  '2024-10-14', 45, '2024-10-21'),
(8,  2,  6,  '2024-10-14', 30, '2024-10-21'),
(9,  2,  7,  '2024-10-12', 12, '2024-10-19'),
(10, 3,  7,  '2024-10-19', 23, '2024-10-26'),
(11, 3,  8,  '2024-10-10', 12, '2024-10-17'),
(12, 3,  9,  '2024-10-11',  1, '2024-10-18'),
(13, 4, 10,  '2024-10-16', 24, '2024-10-30'),
(14, 5, 11,  '2024-10-10', 47, '2024-10-17'),
(15, 5, 11,  '2024-10-19', 60, '2024-10-26'),
(16, 5, 12,  '2024-10-11', 45, NULL);









	


   
