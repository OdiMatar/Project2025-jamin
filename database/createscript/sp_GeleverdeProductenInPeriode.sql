USE laravel;

/* ============================================================
   Overzicht geleverde producten binnen een tijdvak (Userstory 1)
   ============================================================ */
DROP PROCEDURE IF EXISTS sp_GeleverdeProductenInPeriode;
DELIMITER $$

CREATE PROCEDURE sp_GeleverdeProductenInPeriode(
    IN p_Start DATE,
    IN p_Eind DATE
)
BEGIN
    SELECT
        l.Id                              AS LeverancierId,
        l.Naam                            AS LeverancierNaam,
        l.ContactPersoon                  AS ContactPersoon,
        p.Id                              AS ProductId,
        p.Naam                            AS ProductNaam,
        SUM(ppl.Aantal)                   AS TotaalGeleverd
    FROM ProductPerLeverancier ppl
    JOIN Leverancier l ON l.Id = ppl.LeverancierId
    JOIN Product p ON p.Id = ppl.ProductId
    WHERE ppl.IsActief = b'1'
      AND ppl.DatumLevering BETWEEN p_Start AND p_Eind
    GROUP BY
        l.Id, l.Naam, l.ContactPersoon,
        p.Id, p.Naam
    ORDER BY l.Naam, p.Naam;
END $$

DELIMITER ;
