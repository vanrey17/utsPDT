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
    Schema::create('books', function (Blueprint $table) {
        $table->id();
        $table->string('title', 100); // Default sudah NOT NULL
        $table->string('author', 50);
        $table->string('isbn', 20)->unique();
        $table->string('publish_year', 4)->nullable();
        $table->string('publisher', 100)->nullable();

        // 1. Buat kolomnya dulu
        // 2. Gunakan constrained() untuk cara yang lebih singkat dan modern
        $table->foreignId('category_id')
              ->constrained('categories')
              ->onDelete('cascade'); // Opsional: Hapus buku jika kategori dihapus

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
