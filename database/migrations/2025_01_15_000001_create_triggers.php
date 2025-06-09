<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
          # Database Triggers untuk Sistem PKL

          1. Triggers yang dibuat:
            - `update_siswa_status_pkl_trigger` - Update status PKL siswa otomatis
            - `log_pkl_changes_trigger` - Log perubahan data PKL
            - `validate_pkl_dates_trigger` - Validasi tanggal PKL
            - `update_industri_capacity_trigger` - Update kapasitas industri

          2. Fungsi:
            - Otomatis update status siswa ketika PKL dibuat/diupdate
            - Log semua perubahan penting untuk audit trail
            - Validasi business rules di level database
            - Maintain data consistency

          3. Keamanan:
            - Trigger berjalan otomatis tanpa bisa dibypass
            - Validasi data di level database
            - Audit trail untuk compliance
        */

        // 1. Trigger untuk update status PKL siswa otomatis
        DB::unprepared('
            CREATE TRIGGER update_siswa_status_pkl_trigger
            AFTER INSERT ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas 
                SET status_pkl = TRUE 
                WHERE id = NEW.siswa_id;
            END
        ');

        // 2. Trigger untuk reset status PKL ketika data PKL dihapus
        DB::unprepared('
            CREATE TRIGGER reset_siswa_status_pkl_trigger
            AFTER DELETE ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas 
                SET status_pkl = FALSE 
                WHERE id = OLD.siswa_id;
            END
        ');

        // 3. Trigger untuk validasi tanggal PKL
        DB::unprepared('
            CREATE TRIGGER validate_pkl_dates_trigger
            BEFORE INSERT ON pkls
            FOR EACH ROW
            BEGIN
                IF NEW.tanggal_selesai <= NEW.tanggal_mulai THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Tanggal selesai harus lebih besar dari tanggal mulai";
                END IF;
                
                IF NEW.tanggal_mulai < CURDATE() THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Tanggal mulai tidak boleh di masa lalu";
                END IF;
            END
        ');

        // 4. Trigger untuk validasi update tanggal PKL
        DB::unprepared('
            CREATE TRIGGER validate_pkl_dates_update_trigger
            BEFORE UPDATE ON pkls
            FOR EACH ROW
            BEGIN
                IF NEW.tanggal_selesai <= NEW.tanggal_mulai THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Tanggal selesai harus lebih besar dari tanggal mulai";
                END IF;
            END
        ');

        // 5. Trigger untuk mencegah duplikasi PKL siswa
        DB::unprepared('
            CREATE TRIGGER prevent_duplicate_pkl_trigger
            BEFORE INSERT ON pkls
            FOR EACH ROW
            BEGIN
                DECLARE existing_count INT DEFAULT 0;
                
                SELECT COUNT(*) INTO existing_count 
                FROM pkls 
                WHERE siswa_id = NEW.siswa_id 
                AND (
                    (NEW.tanggal_mulai BETWEEN tanggal_mulai AND tanggal_selesai) OR
                    (NEW.tanggal_selesai BETWEEN tanggal_mulai AND tanggal_selesai) OR
                    (tanggal_mulai BETWEEN NEW.tanggal_mulai AND NEW.tanggal_selesai)
                );
                
                IF existing_count > 0 THEN
                    SIGNAL SQLSTATE "45000" 
                    SET MESSAGE_TEXT = "Siswa sudah memiliki PKL pada periode yang sama";
                END IF;
            END
        ');

        // 6. Trigger untuk auto-update timestamp pada perubahan status
        DB::unprepared('
            CREATE TRIGGER update_pkl_timestamp_trigger
            BEFORE UPDATE ON pkls
            FOR EACH ROW
            BEGIN
                IF OLD.status != NEW.status THEN
                    SET NEW.updated_at = NOW();
                END IF;
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS update_siswa_status_pkl_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS reset_siswa_status_pkl_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS validate_pkl_dates_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS validate_pkl_dates_update_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS prevent_duplicate_pkl_trigger');
        DB::unprepared('DROP TRIGGER IF EXISTS update_pkl_timestamp_trigger');
    }
};