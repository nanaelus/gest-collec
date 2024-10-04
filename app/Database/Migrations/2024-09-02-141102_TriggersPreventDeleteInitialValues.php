<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class TriggerPreventDeleteInitialValues extends Migration
{
    public function up()
    {
        $trigger_sql = "
            CREATE TRIGGER prevent_delete_initial_license
            BEFORE DELETE ON license
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La suppression de la licence \"Non classé\" est interdite.';
                END IF;
            END;
        ";
        // Exécuter le SQL brut pour créer le trigger
        $this->db->query($trigger_sql);

        $trigger_sql = "
            CREATE TRIGGER prevent_delete_initial_brand
            BEFORE DELETE ON brand
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La suppression de la marque \"Aucune marque\" est interdite.';
                END IF;
            END;
        ";
        // Exécuter le SQL brut pour créer le trigger
        $this->db->query($trigger_sql);

        $trigger_sql = "
            CREATE TRIGGER prevent_delete_initial_type
            BEFORE DELETE ON type
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La suppression du type \"Non classé\" est interdite.';
                END IF;
            END;
        ";
        // Exécuter le SQL brut pour créer le trigger
        $this->db->query($trigger_sql);

        $trigger_sql = "
            CREATE TRIGGER prevent_delete_initial_genre
            BEFORE DELETE ON genre
            FOR EACH ROW
            BEGIN
                IF OLD.id = 1 THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'La suppression du genre \"Aucun genre\" est interdite.';
                END IF;
            END;
        ";
        // Exécuter le SQL brut pour créer le trigger
        $this->db->query($trigger_sql);

        $trigger_sql = "
        CREATE TRIGGER before_delete_license
        BEFORE DELETE ON license
        FOR EACH ROW
        BEGIN
                UPDATE item SET id_license = 1 WHERE id_license = OLD.id;
        END;
    ";
        $this->db->query($trigger_sql);

        $trigger_sql = "
        CREATE TRIGGER before_delete_brand
        BEFORE DELETE ON brand
        FOR EACH ROW
        BEGIN
                UPDATE item SET id_brand = 1 WHERE id_brand = OLD.id;
        END;
    ";
        $this->db->query($trigger_sql);

        $trigger_sql = "
        CREATE TRIGGER before_delete_type
        BEFORE DELETE ON type
        FOR EACH ROW
        BEGIN
                UPDATE item SET id_type = 1 WHERE id_type = OLD.id;
        END;
    ";
        $this->db->query($trigger_sql);

        $trigger_sql = "
        CREATE TRIGGER before_delete_genre
        BEFORE DELETE ON genre
        FOR EACH ROW
        BEGIN
                UPDATE item SET id_genre = 1 WHERE id_genre = OLD.id;
        END;
    ";
        $this->db->query($trigger_sql);
    }

    public function down()
    {
        // SQL pour supprimer le trigger
        $this->db->query("DROP TRIGGER IF EXISTS prevent_delete_initial_license");
        $this->db->query("DROP TRIGGER IF EXISTS prevent_delete_initial_brand");
        $this->db->query("DROP TRIGGER IF EXISTS prevent_delete_initial_type");
        $this->db->query("DROP TRIGGER IF EXISTS prevent_delete_initial_genre");
        $this->db->query("DROP TRIGGER IF EXISTS before_delete_license");
        $this->db->query("DROP TRIGGER IF EXISTS before_delete_brand");
        $this->db->query("DROP TRIGGER IF EXISTS before_delete_type");
        $this->db->query("DROP TRIGGER IF EXISTS before_delete_genre");
    }
}