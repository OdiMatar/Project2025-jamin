USE laravel;

DROP PROCEDURE IF EXISTS sp_LeverancierDetails;
DELIMITER //
CREATE PROCEDURE sp_LeverancierDetails(IN p_id TINYINT UNSIGNED)
BEGIN
  SELECT
    Id, Naam, ContactPersoon, LeverancierNummer, Mobiel,
    Straatnaam, Huisnummer, Postcode, Stad
  FROM Leverancier
  WHERE Id = p_id
  LIMIT 1;
END//
DELIMITER ;
