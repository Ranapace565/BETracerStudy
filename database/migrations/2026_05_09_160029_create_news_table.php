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
        Schema::create('news', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Penulis
        
        $table->string('title');
        $table->string('slug')->unique(); 
        $table->text('content');
        $table->string('thumbnail')->nullable(); // Gambar utama berita
        $table->string('category')->nullable(); // Contoh: Event, Prestasi, Tips
        
        $table->boolean('is_published')->default(true);
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
