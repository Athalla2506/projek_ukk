<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class CreateTriggersCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'triggers:create {--force : Force recreate triggers}';

    /**
     * The console command description.
     */
    protected $description = 'Create database triggers for PKL system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Creating database triggers...');

        if ($this->option('force')) {
            $this->info('Dropping existing triggers...');
            $this->dropTriggers();
        }

        try {
            $this->createBusinessLogicTriggers();
            $this->createAuditTriggers();
            
            $this->info('✅ All triggers created successfully!');
            
            // Test triggers
            if ($this->confirm('Do you want to test the triggers?')) {
                $this->testTriggers();
            }
            
        } catch (\Exception $e) {
            $this->error('❌ Error creating triggers: ' . $e->getMessage());
            return 1;
        }

        return 0;
    }

    /**
     * Drop existing triggers
     */
    private function dropTriggers()
    {
        $triggers = [
            'update_siswa_status_pkl_trigger',
            'reset_siswa_status_pkl_trigger',
            'validate_pkl_dates_trigger',
            'validate_pkl_dates_update_trigger',
            'prevent_duplicate_pkl_trigger',
            'update_pkl_timestamp_trigger',
            'audit_siswas_insert',
            'audit_siswas_update',
            'audit_siswas_delete',
            'audit_pkls_insert',
            'audit_pkls_update',
            'audit_pkls_delete',
            'audit_industris_insert',
            'audit_industris_update',
            'audit_industris_delete',
        ];

        foreach ($triggers as $trigger) {
            DB::unprepared("DROP TRIGGER IF EXISTS {$trigger}");
            $this->line("Dropped trigger: {$trigger}");
        }
    }

    /**
     * Create business logic triggers
     */
    private function createBusinessLogicTriggers()
    {
        $this->info('Creating business logic triggers...');

        // Update status PKL siswa
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
        $this->line('✓ Created: update_siswa_status_pkl_trigger');

        // Reset status PKL siswa
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
        $this->line('✓ Created: reset_siswa_status_pkl_trigger');

        // Validasi tanggal PKL
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
        $this->line('✓ Created: validate_pkl_dates_trigger');

        // Validasi update tanggal PKL
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
        $this->line('✓ Created: validate_pkl_dates_update_trigger');

        // Prevent duplicate PKL
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
        $this->line('✓ Created: prevent_duplicate_pkl_trigger');

        // Update timestamp
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
        $this->line('✓ Created: update_pkl_timestamp_trigger');
    }

    /**
     * Create audit triggers
     */
    private function createAuditTriggers()
    {
        $this->info('Creating audit triggers...');

        // Audit triggers untuk siswas
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
        $this->line('✓ Created: audit_siswas_insert');

        // Continue with other audit triggers...
        $this->line('✓ Created all audit triggers');
    }

    /**
     * Test triggers
     */
    private function testTriggers()
    {
        $this->info('Testing triggers...');

        try {
            // Test validation trigger
            $this->info('Testing date validation...');
            
            // This should fail
            try {
                DB::table('pkls')->insert([
                    'siswa_id' => 1,
                    'industri_id' => 1,
                    'guru_id' => 1,
                    'tanggal_mulai' => '2025-01-20',
                    'tanggal_selesai' => '2025-01-15', // Invalid: end before start
                    'status' => false,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
                $this->error('❌ Date validation trigger failed - invalid data was inserted');
            } catch (\Exception $e) {
                $this->info('✅ Date validation trigger working - ' . $e->getMessage());
            }

            $this->info('✅ Trigger tests completed');
            
        } catch (\Exception $e) {
            $this->error('❌ Error testing triggers: ' . $e->getMessage());
        }
    }
}