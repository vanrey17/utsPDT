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
        Schema::table('books', function (Blueprint $table) {
            $table->string('author', 50)->nullable()->change();
            $table->string('isbn', 20)->nullable()->change();
            $table->foreignId('category_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('books', function (Blueprint $table) {
            $table->string('author', 50)->nullable(false)->change();
            $table->string('isbn', 20)->nullable(false)->change();
            $table->foreignId('category_id')->nullable(false)->change();
        });
    }
};
