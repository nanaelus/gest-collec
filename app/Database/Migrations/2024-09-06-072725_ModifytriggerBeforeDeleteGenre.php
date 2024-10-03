<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ModifyTriggerBeforeDeleteGenre extends Migration
{
    public function up()
    {
        $this->db->query("DROP TRIGGER IF EXISTS before_delete_genre");

        $trigger_sql = "
        CREATE TRIGGER before_delete_genre
        BEFORE DELETE ON genre
        FOR EACH ROW
        BEGIN
            UPDATE genre_item SET id_genre = 1 WHERE id_genre = OLD.id;
            DELETE FROM genre_item
            WHERE id_genre = 1
            AND id IN (
                SELECT MIN(id) 
                FROM genre_item 
                WHERE id_genre = 1
                GROUP BY id_item
                HAVING COUNT(*) > 1
            );
        END;
        ";
        $this->db->query($trigger_sql);
    }

    public function down()
    {
        $this->db->query("DROP TRIGGER IF EXISTS before_delete_genre");
    }
}