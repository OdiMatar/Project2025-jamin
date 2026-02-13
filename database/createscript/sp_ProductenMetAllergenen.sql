-- Step: 14
-- Goal: Create stored procedure to get products with allergens and supplier info
-- **********************************************************************************
-- Version       Date:           Author:                     Description:
-- *******       **********      ****************            ******************
-- 01            13-02-2026      Generated                   New
-- **********************************************************************************/

DROP PROCEDURE IF EXISTS sp_ProductenMetAllergenen;

DELIMITER $$

CREATE PROCEDURE sp_ProductenMetAllergenen(
    IN p_AllergeenId SMALLINT UNSIGNED
)
BEGIN
    SELECT DISTINCT
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        GROUP_CONCAT(DISTINCT a.Naam ORDER BY a.Naam SEPARATOR ', ') AS Allergenen,
        m.AantalAanwezig,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.Mobiel,
        l.LeverancierNummer
    FROM Product p
    INNER JOIN ProductPerAllergeen ppa ON p.Id = ppa.ProductId
    INNER JOIN Allergeen a ON ppa.AllergeenId = a.Id
    LEFT JOIN Magazijn m ON p.Id = m.ProductId
    LEFT JOIN ProductPerLeverancier ppl ON p.Id = ppl.ProductId
    LEFT JOIN Leverancier l ON ppl.LeverancierId = l.Id
    WHERE 
        (p_AllergeenId IS NULL OR ppa.AllergeenId = p_AllergeenId)
        AND p.IsActief = 1
        AND a.IsActief = 1
    GROUP BY 
        p.Id, p.Naam, p.Barcode, m.AantalAanwezig, 
        l.Naam, l.ContactPersoon, l.Mobiel, l.LeverancierNummer
    ORDER BY p.Naam ASC;
END$$

DELIMITER ;
