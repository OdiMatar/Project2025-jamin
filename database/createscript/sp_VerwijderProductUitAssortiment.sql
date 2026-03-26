USE laravel;

DROP PROCEDURE IF EXISTS sp_VerwijderProductUitAssortiment;
DELIMITER $$

CREATE PROCEDURE sp_VerwijderProductUitAssortiment(
    IN p_ProductId TINYINT UNSIGNED,
    OUT p_Success TINYINT,
    OUT p_Message VARCHAR(255)
)
proc: BEGIN
    DECLARE v_EndDate DATE;
    DECLARE v_ProductExists INT DEFAULT 0;

    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SET p_Success = 0;
        SET p_Message = 'Product kan niet worden verwijdert door een technische fout';
    END;

    SET p_Success = 0;
    SET p_Message = 'Product niet gevonden';

    SELECT COUNT(*)
    INTO v_ProductExists
    FROM Product
    WHERE Id = p_ProductId;

    IF v_ProductExists = 0 THEN
        LEAVE proc;
    END IF;

    SELECT pedl.EinddatumLevering
    INTO v_EndDate
    FROM ProductEinddatumLevering pedl
    WHERE pedl.ProductId = p_ProductId
      AND pedl.IsActief = b'1'
    LIMIT 1;

    IF v_EndDate IS NULL THEN
        SET p_Message = 'Product heeft geen einddatum levering en kan niet worden verwijdert';
        LEAVE proc;
    END IF;

    IF CURDATE() < v_EndDate THEN
        SET p_Message = 'Product kan niet worden verwijdert, datum van vandaag ligt voor einddatum levering';
        LEAVE proc;
    END IF;

    START TRANSACTION;

    DELETE FROM ProductPerAllergeen WHERE ProductId = p_ProductId;
    DELETE FROM ProductPerLeverancier WHERE ProductId = p_ProductId;
    DELETE FROM Magazijn WHERE ProductId = p_ProductId;
    DELETE FROM ProductEinddatumLevering WHERE ProductId = p_ProductId;
    DELETE FROM Product WHERE Id = p_ProductId;

    COMMIT;

    SET p_Success = 1;
    SET p_Message = 'Product is succesvol verwijdert';
END proc $$

DELIMITER ;
