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
        Schema::table('concept', function (Blueprint $table) {
            // Se crea nuevo campo en concept
            $table->unsignedBigInteger("sale_id")->nullable();
            $table->foreign("sale_id")->references("id")->on("sale")->onDelete("set null"); //relacionamos con la tabla sale. 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concept', function (Blueprint $table) {
            $table->dropForeign(['sale_id']);
            $table->dropColumn('sale_id');
        });
    }
};
