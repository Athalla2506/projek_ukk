<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        /*
          # Audit Log Table untuk Tracking Perubahan

          1. Tabel audit_logs:
            - `id` (primary key)
            - `table_name` (nama tabel yang diubah)
            - `record_id` (ID record yang diubah)
            - `action` (INSERT, UPDATE, DELETE)
            - `old_values` (nilai lama dalam JSON)
            - `new_values` (nilai baru dalam JSON)
            - `user_id` (user yang melakukan perubahan)
            - `created_at` (timestamp)

          2. Kegunaan:
            - Audit trail untuk compliance
            - Tracking perubahan data penting
            - Debugging dan troubleshooting
            - Reporting dan analytics
        */

        Schema::create('audit_logs', function (Blueprint $table) {
            $table->id();
            $table->string('table_name', 50);
            $table->unsignedBigInteger('record_id');
            $table->enum('action', ['INSERT', 'UPDATE', 'DELETE']);
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->index(['table_name', 'record_id']);
            $table->index(['action', 'created_at']);
            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('audit_logs');
    }
};