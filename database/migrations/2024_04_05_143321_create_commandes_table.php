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
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->enum("statut", ['créé','attente','livraison' ,'traitement', 'En cours livraison', 'livrée', 'payée','planification','retournée'])->default('attente');
          
                $table->enum("mode", ["espèce","paypal","carte de credit"])->default("espèce");
            $table->enum("etat",["attente","confirmé","annulé"])->default("attente") ;
            $table->text("note")->nullable()->default(null);
            $table->string("nom")->nullable();
            $table->string("prenom")->nullable();
            $table->float('coupon')->nullable();
            $table->string('photo')->nullable();
            $table->string("adresse")->nullable();
            $table->string("phone")->nullable();
            $table->string("email")->nullable();
            $table->string("pays")->nullable();
            $table->string("gouvernorat")->nullable();
            $table->integer("quantite")->nullable();
            $table->decimal("frais", 10,3)->nullable();
            $table->unsignedBigInteger('user_id')->nullable()->default(null);


            $table->unsignedBigInteger('transport_id')->nullable();
            $table->unsignedBigInteger('tranport_id')->nullable();
          
            $table->boolean('adresses')->nullable();
            $table->text('adresse_supp1')->nullable();
            $table->text('adresse_supp2')->nullable();

            $table->float('sub_total')->nullable();
            $table->float('total_amount')->nullable();
           
            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};