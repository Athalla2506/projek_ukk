<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

return new class extends Migration
{
    public function up(): void
    {
        // Drop function jika sudah ada
        DB::unprepared('DROP FUNCTION IF EXISTS format_jenis_kelamin');

        // Buat function konversi gender
        DB::unprepared("
            CREATE FUNCTION format_jenis_kelamin(kode CHAR(1))
            RETURNS VARCHAR(20)
            DETERMINISTIC
            BEGIN
                IF kode = 'L' THEN
                    RETURN 'Laki-laki';
                ELSEIF kode = 'P' THEN
                    RETURN 'Perempuan';
                ELSE
                    RETURN 'Tidak diketahui';
                END IF;
            END
        ");

        // Drop trigger jika sudah ada
        DB::unprepared('DROP TRIGGER IF EXISTS after_pkl_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_pkl_delete');

        // Trigger setelah insert ke PKL
        DB::unprepared('
            CREATE TRIGGER after_pkl_insert
            AFTER INSERT ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas 
                SET status_lapor_pkl = TRUE 
                WHERE id = NEW.siswa_id;
            END;
        ');

        // Trigger setelah delete dari PKL
        DB::unprepared('
            CREATE TRIGGER after_pkl_delete
            AFTER DELETE ON pkls
            FOR EACH ROW
            BEGIN
                UPDATE siswas 
                SET status_lapor_pkl = FALSE 
                WHERE id = OLD.siswa_id;
            END;
        ');
    }

    public function down(): void
    {
        // Harus sesuai dengan nama yang dibuat di atas
        DB::unprepared('DROP TRIGGER IF EXISTS after_pkl_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS after_pkl_delete');
        DB::unprepared('DROP FUNCTION IF EXISTS format_jenis_kelamin');
    }
};
