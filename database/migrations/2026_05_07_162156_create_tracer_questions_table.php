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
        // 1. Tabel Periode Kuesioner
    Schema::create('questionnaires', function (Blueprint $table) {
        $table->id();
        $table->string('title'); // Contoh: Tracer Study Lulusan 2026
        $table->year('year');
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });

    // 2. Tabel Master Pertanyaan
    Schema::create('questions', function (Blueprint $table) {
        $table->id();
        $table->foreignId('questionnaire_id')->constrained()->onDelete('cascade');
        // Relasi ke diri sendiri untuk pertanyaan bercabang (Sub-Question)
        $table->foreignId('parent_id')->nullable()->constrained('questions')->onDelete('cascade');
        
        $table->string('kode')->unique(); // Contoh: f8, f502 (Kode Kemendikbud)
        $table->text('text'); // Isi pertanyaan
        $table->enum('type', ['text', 'number', 'radio', 'checkbox', 'dropdown']);
        $table->integer('order')->default(0); // Untuk urutan tampil di UI
        $table->boolean('is_required')->default(true);
        $table->timestamps();
    });

    // Tabel Opsi untuk Pertanyaan (Radio/Checkbox/Dropdown)
    Schema::create('question_options', function (Blueprint $table) {
        $table->id();
        $table->foreignId('question_id')->constrained()->onDelete('cascade');
        $table->string('option_text'); // Contoh: "Sangat Puas"
        $table->string('value'); // Nilai data, contoh: "5" atau "A"
        $table->integer('order')->default(0);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questionnaires');
        Schema::dropIfExists('questions');
        Schema::dropIfExists('question_options');
    }
};
