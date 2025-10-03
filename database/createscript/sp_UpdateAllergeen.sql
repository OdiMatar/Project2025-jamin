USE laravel;

DROP PROCEDURE IF EXISTS sp_UpdateAllergeen;
DELIMITER $$

CREATE PROCEDURE sp_UpdateAllergeen(
    IN p_id INT,
    IN p_naam VARCHAR(50),
    IN p_description VARCHAR(255)
)
BEGIN
    UPDATE Allergeen
    SET Naam = p_naam,
        Omschrijving = p_description,
        DatumGewijzigd = NOW(6)
    WHERE Id = p_id;

    SELECT ROW_COUNT() AS Affected;
END$$
DELIMITER ;
