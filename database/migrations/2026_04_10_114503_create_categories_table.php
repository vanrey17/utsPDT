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
    // Cek apakah tabel belum ada
    if (!Schema::hasTable('categories')) {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('description', 255)->nullable();
            $table->timestamps();
        });
    } else {
        // Jika tabel sudah ada, kita hanya pastikan kolom 'description' ada
        Schema::table('categories', function (Blueprint $table) {
            if (!Schema::hasColumn('categories', 'description')) {
                $table->string('description', 255)->nullable()->after('name');
            }
        });
    }
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
