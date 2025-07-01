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
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string("nome"    )->nullable(false);
            $table->string("usuario" )->nullable(false);
            $table->string("email"   )->nullable(false);
            $table->string("telefone")->nullable(false);
            $table->foreignId("id_funcao")
                  ->constrained("funcao" );
            $table->foreignId("id_secao" )
                  ->constrained("secao"  );
            $table->boolean("ativo"  )->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('usuario');
    }
};
