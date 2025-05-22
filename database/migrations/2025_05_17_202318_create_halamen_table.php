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
        Schema::create('halamans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('menu_id');
            $table->string('judul');
            $table->string('slug')->unique();
            $table->longText('isi');
            $table->enum('status', ['draft', 'publish', 'arsip'])->default('draft');
            $table->timestamp('published_at')->nullable();
            $table->string('nama_file')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halamans');
    }
};
