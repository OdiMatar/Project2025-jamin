USE laravel;

DROP PROCEDURE IF EXISTS sp_CreateAllergeen;
DELIMITER $$

CREATE PROCEDURE sp_CreateAllergeen(
    IN p_Naam VARCHAR(50),
    IN p_Omschrijving VARCHAR(255)
)
BEGIN
    INSERT INTO Allergeen (Naam, Omschrijving)
    VALUES (p_Naam, p_Omschrijving);

    SELECT LAST_INSERT_ID() AS NewID;
END$$

DELIMITER ;
