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
        Schema::create('pemasukan_pending', function (Blueprint $table) {
            $table->id('id_pemasukan');
            $table->foreignId('id_payer');
            $table->string('desc');
            $table->date('created_date')->default(now());
            $table->bigInteger('nominal');
            $table->enum('status', ['overdue', 'ontime']);
            $table->foreignId('id_category');
            $table->timestamps();
        });
        Schema::table('pemasukan_pending', function (Blueprint $table) {
            $table->foreign('id_payer')->references('id_account')->on('accounts');
            $table->foreign('id_category')->references('id_category')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemasukan_pendings');
    }
};
