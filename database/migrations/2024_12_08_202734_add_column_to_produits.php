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
        Schema::table('produits', function (Blueprint $table) {
          //  $table->boolean('sur_devis')->default(false);
          //  $table->integer('stock_alert')->default(10);
           // $table->text('meta_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('produits', function (Blueprint $table) {
         ///   $table->dropColumn('sur_devis');
         //   $table->dropColumn('stock_alert');
        //    $table->dropColumn('meta_description');
        });
    }
};
