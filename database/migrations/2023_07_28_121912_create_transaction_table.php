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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->string('nim');
            $table->dateTime('tanggal');
            $table->unsignedBigInteger('category_id');
            $table->float('harga');
            $table->text('image');
            $table->string('description');
            $table->string('status')->default('pending'); // Status default adalah "not_verified"
            $table->timestamps();
/* 
    //TODO buat dulu tabel kategori
        // Tambahkan foreign key untuk kategori
        $table->foreign('category_id')
        ->references('id')
        ->on('categories')
        ->onDelete('cascade'); // Jika data di tabel categories dihapus, maka data yang memiliki foreign key yang terkait akan dihapus juga
        */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction');
    }
};
