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
    Schema::create('job_vacancies', function (Blueprint $table) {
        $table->id();
        // Menggunakan user_id agar Admin & Alumni bisa posting
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        
        $table->string('title');
        $table->string('company');
        $table->text('description');
        $table->string('location')->nullable();
        $table->string('poster_image')->nullable();
        $table->string('category')->nullable();
        
        $table->boolean('is_active')->default(true);
        $table->date('expired_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
