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
        Schema::create('pemasukan_verified', function (Blueprint $table) {
            $table->id('id_pemasukan');
            $table->foreignId('id_payer');
            $table->string('desc');
            $table->date('created_at')->default(now());
            $table->integer('nominal');
            $table->foreignId('id_acceptedBy');
        });
        Schema::table('pemasukan_verified', function (Blueprint $table) {
            $table->foreign('id_payer')->references('id_account')->on('accounts');
            $table->foreign('id_acceptedBy')->references('id_account')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukan_verifieds');
    }
};
