USE laravel;
DROP PROCEDURE IF EXISTS sp_GeleverdeProducten;
DELIMITER $$

CREATE PROCEDURE sp_GeleverdeProducten(IN p_LeverancierId TINYINT)
BEGIN
    SELECT
        p.Id                              AS ProductId,
        p.Naam                            AS ProductNaam,
        m.AantalAanwezig,
        m.VerpakkingsEenheid,
        DATE_FORMAT(MAX(ppl.DatumLevering), '%d-%m-%Y')            AS LaatsteLevering,
        DATE_FORMAT(MAX(ppl.DatumEerstVolgendeLevering), '%d-%m-%Y') AS VerwachteEerstvolgende
    FROM ProductPerLeverancier ppl
    JOIN Product   p ON p.Id = ppl.ProductId
    LEFT JOIN Magazijn m ON m.ProductId = p.Id
    WHERE ppl.LeverancierId = p_LeverancierId
    GROUP BY
        p.Id,
        p.Naam,
        m.AantalAanwezig,
        m.VerpakkingsEenheid
    ORDER BY m.AantalAanwezig DESC, p.Naam;
END $$

DELIMITER ;

