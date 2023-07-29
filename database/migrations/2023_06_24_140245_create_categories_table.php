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
            $table->id();
            $table->string('category_name')->unique();
            $table->string('desc');
            $table->enum('category_status', ['active', 'nonactive']);
            $table->dateTime('deadline_date');
            $table->date('created_date')->default(now());
            // $table->foreignId('id_admin');
            $table->timestamps();
        });
        // Schema::table('categories', function (Blueprint $table) {
        //     $table->foreign('id_admin')->references('id_account')->on('accounts');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
