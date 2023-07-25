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
        Schema::create('categories', function (Blueprint $table) {
            $table->id('id_category');
            $table->string('category_name')->unique();
            $table->date('created_date')->default(now());
            $table->string('desc');
            $table->enum('category_status', ['ordinary', 'unique']);
            $table->foreignId('id_admin');
            $table->date('deadline_date');
            $table->timestamps();
        });
        Schema::table('categories', function (Blueprint $table) {
            $table->foreign('id_admin')->references('id_account')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
