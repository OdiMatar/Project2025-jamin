USE laravel;

DROP PROCEDURE IF EXISTS sp_NieuweLevering;
DELIMITER $$

CREATE PROCEDURE sp_NieuweLevering(
    IN  p_LeverancierId          TINYINT,
    IN  p_ProductId              TINYINT,
    IN  p_Aantal                 INT,
    IN  p_DatumEerstVolgende     DATE,
    OUT p_Foutcode               VARCHAR(50)
)
BEGIN
    DECLARE v_IsActief        TINYINT;
    DECLARE v_MagazijnId      TINYINT;
    DECLARE v_AantalAanwezig  INT DEFAULT 0;

    SET p_Foutcode = NULL;

    -- Is het product actief?
    SELECT (IsActief + 0)
    INTO   v_IsActief
    FROM   Product
    WHERE  Id = p_ProductId;

    IF v_IsActief = 0 THEN
        SET p_Foutcode = 'PRODUCT_INACTIEF';
    ELSE
        -- 1. Nieuwe levering vastleggen
        INSERT INTO ProductPerLeverancier
            (LeverancierId, ProductId, DatumLevering, Aantal, DatumEerstVolgendeLevering)
        VALUES
            (p_LeverancierId, p_ProductId, CURDATE(), p_Aantal, p_DatumEerstVolgende);

        -- 2. Voorraad magazijn ophogen
        SELECT Id, COALESCE(AantalAanwezig, 0)
        INTO   v_MagazijnId, v_AantalAanwezig
        FROM   Magazijn
        WHERE  ProductId = p_ProductId
        LIMIT 1;

        IF v_MagazijnId IS NULL THEN
            INSERT INTO Magazijn (ProductId, VerpakkingsEenheid, AantalAanwezig)
            VALUES (p_ProductId, 1.00, p_Aantal);
        ELSE
            UPDATE Magazijn
            SET AantalAanwezig = v_AantalAanwezig + p_Aantal
            WHERE Id = v_MagazijnId;
        END IF;
    END IF;
END $$

DELIMITER ;
