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
        Schema::create('siswas', function (Blueprint $table) {
            $table->id();
            $table->string('nama',length:50);
            $table->string('nis',length:5)->unique();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->text('alamat');
            $table->string('kontak',length:15)->nullable();
            $table->string('email',length:30)->nullable();
            $table->boolean('status_pkl')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswas');
    }
};
