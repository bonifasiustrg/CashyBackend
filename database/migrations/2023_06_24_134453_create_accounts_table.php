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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id('id_account');
            $table->string('username')->unique();
            $table->string('password');
            $table->integer('nim');
            $table->enum('id_role', [1, 2]);
            $table->foreignId('id_createdBy');
            $table->timestamps();
        });
        Schema::table('accounts', function (Blueprint $table) {
            $table->foreign('id_createdBy')->references('id_account')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
