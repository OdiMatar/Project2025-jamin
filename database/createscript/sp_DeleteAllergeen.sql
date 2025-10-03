USE laravel;
DROP PROCEDURE IF EXISTS sp_DeleteAllergeen;
DELIMITER $$

CREATE PROCEDURE sp_DeleteAllergeen(IN p_Id SMALLINT UNSIGNED)
BEGIN
    DECLARE EXIT HANDLER FOR SQLEXCEPTION
    BEGIN
        ROLLBACK;
        SELECT 0 AS ParentDeleted, 0 AS ChildDeleted, 'rolled back' AS Status;
    END;

    START TRANSACTION;
        DELETE FROM ProductPerAllergeen
        WHERE AllergeenId = p_Id;
        SET @child_deleted = ROW_COUNT();

        DELETE FROM Allergeen
        WHERE Id = p_Id;
        SET @parent_deleted = ROW_COUNT();
    COMMIT;

    SELECT @parent_deleted AS ParentDeleted, @child_deleted AS ChildDeleted, 'ok' AS Status;
END $$

DELIMITER ;
