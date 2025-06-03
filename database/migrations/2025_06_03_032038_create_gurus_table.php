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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama', length: 50);
            $table->string('nip', length: 18)->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('kontak', length: 15)->nullable();
            $table->string('email', length: 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gurus');
    }
};
