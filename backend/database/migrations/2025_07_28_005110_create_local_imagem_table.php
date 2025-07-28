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
        Schema::create('local_imagem', function (Blueprint $table) {
            $table->id();
            $table->foreignId("id_local")
                  ->constrained("local")
                  ->onDelete('cascade');
            $table->longText("imagem")->nullable(false); // BLOB da imagem
            $table->boolean("ativo")->nullable(false)->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_imagem');
    }
};
