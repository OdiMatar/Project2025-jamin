USE laravel;

DROP PROCEDURE IF EXISTS sp_LeverancierWijzig;
DELIMITER //

CREATE PROCEDURE sp_LeverancierWijzig(
  IN  p_id TINYINT UNSIGNED,
  IN  p_mobiel VARCHAR(15),
  IN  p_straatnaam VARCHAR(50),
  IN  p_huisnummer VARCHAR(10),
  IN  p_postcode VARCHAR(10),
  IN  p_stad VARCHAR(50),
  OUT p_success TINYINT,
  OUT p_message VARCHAR(255)
)
BEGIN
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
    SET p_success = 0;
    SET p_message = 'Door een technische storing is het niet mogelijk de wijziging door te voeren. Probeer het op een later moment nog eens';
  END;

  START TRANSACTION;

  -- ✅ UNHAPPY scenario forceren: De Bron (Id = 5)
  IF p_id = 5 THEN
    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Simulated technical failure for De Bron';
  END IF;

  UPDATE Leverancier
  SET
    Mobiel = p_mobiel,
    Straatnaam = p_straatnaam,
    Huisnummer = p_huisnummer,
    Postcode = p_postcode,
    Stad = p_stad
  WHERE Id = p_id;

  IF ROW_COUNT() = 0 THEN
    ROLLBACK;
    SET p_success = 0;
    SET p_message = 'Leverancier niet gevonden';
  ELSE
    COMMIT;
    SET p_success = 1;
    SET p_message = 'De wijzigingen zijn doorgevoerd';
  END IF;
END//

DELIMITER ;
