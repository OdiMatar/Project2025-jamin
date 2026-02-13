-- Update stored procedure sp_ProductenMetAllergenen
-- Run this file to update the stored procedure

USE laravel;

DROP PROCEDURE IF EXISTS sp_ProductenMetAllergenen;

DELIMITER $$

CREATE PROCEDURE sp_ProductenMetAllergenen(
    IN p_AllergeenId SMALLINT UNSIGNED
)
BEGIN
    IF p_AllergeenId IS NULL OR p_AllergeenId = 0 THEN
        -- Alle producten met allergenen
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
        WHERE a.IsActief = 1
        GROUP BY 
            p.Id, p.Naam, p.Barcode, m.AantalAanwezig, 
            l.Naam, l.ContactPersoon, l.Mobiel, l.LeverancierNummer
        ORDER BY p.Naam ASC;
    ELSE
        -- Gefilterd op specifiek allergeen
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
        WHERE ppa.AllergeenId = p_AllergeenId
          AND a.IsActief = 1
        GROUP BY 
            p.Id, p.Naam, p.Barcode, m.AantalAanwezig, 
            l.Naam, l.ContactPersoon, l.Mobiel, l.LeverancierNummer
        ORDER BY p.Naam ASC;
    END IF;
END$$

DELIMITER ;

-- Test de stored procedure
CALL sp_ProductenMetAllergenen(NULL);
