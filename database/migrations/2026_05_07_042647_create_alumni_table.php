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
        Schema::create('alumnis', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('nim')->unique()->nullable(); // nimhsmsmh
        $table->string('nik', 16)->unique()->nullable(); // Tambahan: NIK
        $table->string('npwp', 20)->unique()->nullable(); // Tambahan: NPWP
        $table->string('name'); // nmmhsmsmh
        $table->string('phone_number')->nullable();
        $table->string('img_profile')->nullable(); // Kolom revisi
        $table->json('privacy_settings')->nullable(); // Kolom revisi JSON
        $table->year('tahun_lulus')->nullable();
        $table->string('kdpstmsmh')->nullable(); // Kode Prodi
        $table->string('status')->nullable(); // Tambahan: Status (Bekerja/Studi/dll)
        $table->timestamps();
    });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnis');
    }
};
