USE laravel;

DROP PROCEDURE IF EXISTS sp_ProductenUitAssortimentInPeriode;
DELIMITER $$

CREATE PROCEDURE sp_ProductenUitAssortimentInPeriode(
    IN p_Start DATE,
    IN p_Eind DATE
)
BEGIN
    SELECT
        p.Id AS ProductId,
        p.Naam AS ProductNaam,
        p.Barcode,
        pedl.EinddatumLevering,
        l.Naam AS LeverancierNaam,
        l.ContactPersoon,
        l.Stad
    FROM ProductEinddatumLevering pedl
    INNER JOIN Product p
        ON p.Id = pedl.ProductId
    LEFT JOIN ProductPerLeverancier ppl
        ON ppl.Id = (
            SELECT ppl2.Id
            FROM ProductPerLeverancier ppl2
            WHERE ppl2.ProductId = p.Id
              AND ppl2.IsActief = b'1'
            ORDER BY ppl2.DatumLevering DESC, ppl2.Id DESC
            LIMIT 1
        )
    LEFT JOIN Leverancier l
        ON l.Id = ppl.LeverancierId
    WHERE pedl.IsActief = b'1'
      AND pedl.EinddatumLevering BETWEEN p_Start AND p_Eind
    ORDER BY pedl.EinddatumLevering DESC, p.Naam ASC;
END $$

DELIMITER ;
