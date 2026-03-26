USE laravel;

DROP PROCEDURE IF EXISTS sp_ProductUitAssortimentDetails;
DELIMITER $$

CREATE PROCEDURE sp_ProductUitAssortimentDetails(
    IN p_ProductId TINYINT UNSIGNED
)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        pedl.EinddatumLevering,
        IF(EXISTS(
            SELECT 1
            FROM ProductPerAllergeen ppa
            INNER JOIN Allergeen a ON a.Id = ppa.AllergeenId
            WHERE ppa.ProductId = p.Id
              AND ppa.IsActief = b'1'
              AND a.IsActief = b'1'
              AND a.Naam = 'Gluten'
        ), 'Ja', 'Nee') AS BevatGluten,
        IF(EXISTS(
            SELECT 1
            FROM ProductPerAllergeen ppa
            INNER JOIN Allergeen a ON a.Id = ppa.AllergeenId
            WHERE ppa.ProductId = p.Id
              AND ppa.IsActief = b'1'
              AND a.IsActief = b'1'
              AND a.Naam = 'Gelatine'
        ), 'Ja', 'Nee') AS BevatGelatine,
        IF(EXISTS(
            SELECT 1
            FROM ProductPerAllergeen ppa
            INNER JOIN Allergeen a ON a.Id = ppa.AllergeenId
            WHERE ppa.ProductId = p.Id
              AND ppa.IsActief = b'1'
              AND a.IsActief = b'1'
              AND a.Naam = 'AZO-Kleurstof'
        ), 'Ja', 'Nee') AS BevatAzoKleurstof,
        IF(EXISTS(
            SELECT 1
            FROM ProductPerAllergeen ppa
            INNER JOIN Allergeen a ON a.Id = ppa.AllergeenId
            WHERE ppa.ProductId = p.Id
              AND ppa.IsActief = b'1'
              AND a.IsActief = b'1'
              AND a.Naam = 'Lactose'
        ), 'Ja', 'Nee') AS BevatLactose,
        IF(EXISTS(
            SELECT 1
            FROM ProductPerAllergeen ppa
            INNER JOIN Allergeen a ON a.Id = ppa.AllergeenId
            WHERE ppa.ProductId = p.Id
              AND ppa.IsActief = b'1'
              AND a.IsActief = b'1'
              AND a.Naam = 'Soja'
        ), 'Ja', 'Nee') AS BevatSoja
    FROM Product p
    INNER JOIN ProductEinddatumLevering pedl
        ON pedl.ProductId = p.Id
       AND pedl.IsActief = b'1'
    WHERE p.Id = p_ProductId
    LIMIT 1;
END $$

DELIMITER ;
