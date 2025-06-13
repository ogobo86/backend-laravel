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
        Schema::table('product', function (Blueprint $table) {
            //
            $table->unsignedBigInteger('category_id')->nullable();
            $table->foreign('category_id')
                  ->references('id')->on('category') 
                  ->onDelete('set null'); // Al no existir coloca null. 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product', function (Blueprint $table) {
            // 1. Primero se elimina el FK
            Schema::dropForeign(['category_id']);
            // 2. Se elemina la columna
            Schema::dropIfExists('category_id');
        });
    }
};
