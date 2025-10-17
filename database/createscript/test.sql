USE laravel;

DROP PROCEDURE IF EXISTS sp_Test;

DELIMITER $$

CREATE PROCEDURE sp_Test(
	IN p_Id INT
)
BEGIN
    SELECT LEVE.Naam
		  ,LEVE.Contactpersoon
          ,LEVE.LeverancierNummer
          ,LEVE.Mobiel
          
    FROM Leverancier AS LEVE
    
    INNER JOIN ProductPerLeverancier AS PPLE
    ON PPLE.LeverancierId = LEVE.Id
	WHERE PPLE.ProductId = p_Id;    
END$$

DELIMITER ;
