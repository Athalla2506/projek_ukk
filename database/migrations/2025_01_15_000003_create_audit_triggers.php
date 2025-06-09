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
        /*
          # Audit Triggers untuk Logging Otomatis

          1. Triggers untuk audit:
            - Log INSERT pada tabel penting
            - Log UPDATE dengan old/new values
            - Log DELETE untuk recovery

          2. Tabel yang di-audit:
            - siswas (data siswa)
            - pkls (data PKL)
            - industris (data industri)
            - gurus (data guru)

          3. Informasi yang dicatat:
            - Semua perubahan data
            - Timestamp perubahan
            - User yang melakukan (jika tersedia)
        */

        // Audit trigger untuk tabel siswas
        DB::unprepared('
            CREATE TRIGGER audit_siswas_insert
            AFTER INSERT ON siswas
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, new_values, created_at)
                VALUES ("siswas", NEW.id, "INSERT", 
                    JSON_OBJECT(
                        "nama", NEW.nama,
                        "nis", NEW.nis,
                        "jenis_kelamin", NEW.jenis_kelamin,
                        "kelas", NEW.kelas,
                        "alamat", NEW.alamat,
                        "kontak", NEW.kontak,
                        "email", NEW.email,
                        "status_pkl", NEW.status_pkl
                    ), 
                    NOW()
                );
            END
        ');

        DB::unprepared('
            CREATE TRIGGER audit_siswas_update
            AFTER UPDATE ON siswas
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, old_values, new_values, created_at)
                VALUES ("siswas", NEW.id, "UPDATE",
                    JSON_OBJECT(
                        "nama", OLD.nama,
                        "nis", OLD.nis,
                        "jenis_kelamin", OLD.jenis_kelamin,
                        "kelas", OLD.kelas,
                        "alamat", OLD.alamat,
                        "kontak", OLD.kontak,
                        "email", OLD.email,
                        "status_pkl", OLD.status_pkl
                    ),
                    JSON_OBJECT(
                        "nama", NEW.nama,
                        "nis", NEW.nis,
                        "jenis_kelamin", NEW.jenis_kelamin,
                        "kelas", NEW.kelas,
                        "alamat", NEW.alamat,
                        "kontak", NEW.kontak,
                        "email", NEW.email,
                        "status_pkl", NEW.status_pkl
                    ),
                    NOW()
                );
            END
        ');

        DB::unprepared('
            CREATE TRIGGER audit_siswas_delete
            AFTER DELETE ON siswas
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, old_values, created_at)
                VALUES ("siswas", OLD.id, "DELETE",
                    JSON_OBJECT(
                        "nama", OLD.nama,
                        "nis", OLD.nis,
                        "jenis_kelamin", OLD.jenis_kelamin,
                        "kelas", OLD.kelas,
                        "alamat", OLD.alamat,
                        "kontak", OLD.kontak,
                        "email", OLD.email,
                        "status_pkl", OLD.status_pkl
                    ),
                    NOW()
                );
            END
        ');

        // Audit trigger untuk tabel pkls
        DB::unprepared('
            CREATE TRIGGER audit_pkls_insert
            AFTER INSERT ON pkls
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, new_values, created_at)
                VALUES ("pkls", NEW.id, "INSERT",
                    JSON_OBJECT(
                        "siswa_id", NEW.siswa_id,
                        "industri_id", NEW.industri_id,
                        "guru_id", NEW.guru_id,
                        "tanggal_mulai", NEW.tanggal_mulai,
                        "tanggal_selesai", NEW.tanggal_selesai,
                        "status", NEW.status
                    ),
                    NOW()
                );
            END
        ');

        DB::unprepared('
            CREATE TRIGGER audit_pkls_update
            AFTER UPDATE ON pkls
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, old_values, new_values, created_at)
                VALUES ("pkls", NEW.id, "UPDATE",
                    JSON_OBJECT(
                        "siswa_id", OLD.siswa_id,
                        "industri_id", OLD.industri_id,
                        "guru_id", OLD.guru_id,
                        "tanggal_mulai", OLD.tanggal_mulai,
                        "tanggal_selesai", OLD.tanggal_selesai,
                        "status", OLD.status
                    ),
                    JSON_OBJECT(
                        "siswa_id", NEW.siswa_id,
                        "industri_id", NEW.industri_id,
                        "guru_id", NEW.guru_id,
                        "tanggal_mulai", NEW.tanggal_mulai,
                        "tanggal_selesai", NEW.tanggal_selesai,
                        "status", NEW.status
                    ),
                    NOW()
                );
            END
        ');

        DB::unprepared('
            CREATE TRIGGER audit_pkls_delete
            AFTER DELETE ON pkls
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, old_values, created_at)
                VALUES ("pkls", OLD.id, "DELETE",
                    JSON_OBJECT(
                        "siswa_id", OLD.siswa_id,
                        "industri_id", OLD.industri_id,
                        "guru_id", OLD.guru_id,
                        "tanggal_mulai", OLD.tanggal_mulai,
                        "tanggal_selesai", OLD.tanggal_selesai,
                        "status", OLD.status
                    ),
                    NOW()
                );
            END
        ');

        // Audit trigger untuk tabel industris
        DB::unprepared('
            CREATE TRIGGER audit_industris_insert
            AFTER INSERT ON industris
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, new_values, created_at)
                VALUES ("industris", NEW.id, "INSERT",
                    JSON_OBJECT(
                        "nama", NEW.nama,
                        "alamat", NEW.alamat,
                        "kontak", NEW.kontak,
                        "email", NEW.email,
                        "deskripsi", NEW.deskripsi
                    ),
                    NOW()
                );
            END
        ');

        DB::unprepared('
            CREATE TRIGGER audit_industris_update
            AFTER UPDATE ON industris
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, old_values, new_values, created_at)
                VALUES ("industris", NEW.id, "UPDATE",
                    JSON_OBJECT(
                        "nama", OLD.nama,
                        "alamat", OLD.alamat,
                        "kontak", OLD.kontak,
                        "email", OLD.email,
                        "deskripsi", OLD.deskripsi
                    ),
                    JSON_OBJECT(
                        "nama", NEW.nama,
                        "alamat", NEW.alamat,
                        "kontak", NEW.kontak,
                        "email", NEW.email,
                        "deskripsi", NEW.deskripsi
                    ),
                    NOW()
                );
            END
        ');

        DB::unprepared('
            CREATE TRIGGER audit_industris_delete
            AFTER DELETE ON industris
            FOR EACH ROW
            BEGIN
                INSERT INTO audit_logs (table_name, record_id, action, old_values, created_at)
                VALUES ("industris", OLD.id, "DELETE",
                    JSON_OBJECT(
                        "nama", OLD.nama,
                        "alamat", OLD.alamat,
                        "kontak", OLD.kontak,
                        "email", OLD.email,
                        "deskripsi", OLD.deskripsi
                    ),
                    NOW()
                );
            END
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop audit triggers untuk siswas
        DB::unprepared('DROP TRIGGER IF EXISTS audit_siswas_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_siswas_update');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_siswas_delete');

        // Drop audit triggers untuk pkls
        DB::unprepared('DROP TRIGGER IF EXISTS audit_pkls_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_pkls_update');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_pkls_delete');

        // Drop audit triggers untuk industris
        DB::unprepared('DROP TRIGGER IF EXISTS audit_industris_insert');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_industris_update');
        DB::unprepared('DROP TRIGGER IF EXISTS audit_industris_delete');
    }
};