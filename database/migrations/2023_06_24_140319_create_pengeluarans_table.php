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
        Schema::create('pengeluaran', function (Blueprint $table) {
            $table->id('id_pengeluaran');
            $table->string('title');
            $table->string('desc');
            $table->date('created_date')->default(now());
            $table->foreignId('id_admin');
            $table->timestamps();
        });
        Schema::table('pengeluaran', function (Blueprint $table) {
            $table->foreign('id_admin')->references('id_account')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
