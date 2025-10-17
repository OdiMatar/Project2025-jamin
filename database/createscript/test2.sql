use laravel;

DROP PROCEDURE IF EXISTS sp_Test2;

DELIMITER $$

CREATE PROCEDURE sp_Test2(
	IN p_Id INT
)
BEGIN
    SELECT PROD.Naam
		  ,PPLE.DatumLevering
          ,PPLE.Aantal
          ,PPLE.DatumEerstvolgendeLevering
          ,MAGA.AantalAanwezig
          
    FROM Product AS PROD
    
    INNER JOIN ProductPerLeverancier AS PPLE
    ON PROD.Id = PPLE.ProductId
    
    INNER JOIN Magazijn AS MAGA
    ON MAGA.ProductId = PROD.Id
    
	WHERE PROD.Id = p_Id;    
END$$

DELIMITER ;
