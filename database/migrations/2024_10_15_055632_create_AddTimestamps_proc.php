<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared("CREATE DEFINER=`root`@`localhost` PROCEDURE `AddTimestamps`()
BEGIN
    DECLARE done INT DEFAULT FALSE;
    DECLARE tbl_name VARCHAR(255);
    DECLARE cur CURSOR FOR
        SELECT table_name
        FROM information_schema.tables
        WHERE table_schema = 'desarrollo'  -- Asegúrate de usar el esquema correcto
        AND table_type = 'BASE TABLE';

    DECLARE CONTINUE HANDLER FOR NOT FOUND SET done = TRUE;

    OPEN cur;

    read_loop: LOOP
        FETCH cur INTO tbl_name;
        IF done THEN
            LEAVE read_loop;
        END IF;

        -- Verificar y agregar la columna created_at
        IF NOT EXISTS (
            SELECT 1 FROM information_schema.columns
            WHERE table_schema = 'desarrollo'  -- Asegúrate de usar el esquema correcto
            AND table_name = tbl_name
            AND column_name = 'created_at'
        ) THEN
            SET @query1 = CONCAT('ALTER TABLE ', tbl_name, ' ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP;');
            PREPARE stmt1 FROM @query1;
            EXECUTE stmt1;
            DEALLOCATE PREPARE stmt1;
        END IF;

        -- Verificar y agregar la columna updated_at
        IF NOT EXISTS (
            SELECT 1 FROM information_schema.columns
            WHERE table_schema = 'desarrollo'  -- Asegúrate de usar el esquema correcto
            AND table_name = tbl_name
            AND column_name = 'updated_at'
        ) THEN
            SET @query2 = CONCAT('ALTER TABLE ', tbl_name, ' ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;');
            PREPARE stmt2 FROM @query2;
            EXECUTE stmt2;
            DEALLOCATE PREPARE stmt2;
        END IF;

        -- Verificar y agregar la columna deleted_at
        IF NOT EXISTS (
            SELECT 1 FROM information_schema.columns
            WHERE table_schema = 'desarrollo'  -- Asegúrate de usar el esquema correcto
            AND table_name = tbl_name
            AND column_name = 'deleted_at'
        ) THEN
            SET @query3 = CONCAT('ALTER TABLE ', tbl_name, ' ADD COLUMN deleted_at TIMESTAMP NULL;');
            PREPARE stmt3 FROM @query3;
            EXECUTE stmt3;
            DEALLOCATE PREPARE stmt3;
        END IF;

    END LOOP;

    CLOSE cur;
END");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared("DROP PROCEDURE IF EXISTS AddTimestamps");
    }
};
