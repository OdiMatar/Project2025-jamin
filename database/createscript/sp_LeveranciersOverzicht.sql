USE laravel;
/* ============================================================
   Overzicht leveranciers + aantal verschillende producten
   (Userstory 1 – Wireframe 1)
   ============================================================ */
DROP PROCEDURE IF EXISTS sp_LeveranciersOverzicht;
DELIMITER $$

CREATE PROCEDURE sp_LeveranciersOverzicht()
BEGIN
    SELECT  l.Id,
            l.Naam,
            l.ContactPersoon,
            l.LeverancierNummer,
            l.Mobiel,
            COUNT(DISTINCT ppl.ProductId) AS AantalProducten
    FROM Leverancier l
    LEFT JOIN ProductPerLeverancier ppl
        ON ppl.LeverancierId = l.Id
       AND ppl.IsActief = b'1'
    GROUP BY l.Id, l.Naam, l.ContactPersoon, l.LeverancierNummer, l.Mobiel
    ORDER BY AantalProducten DESC, l.Naam;
END $$
DELIMITER ;