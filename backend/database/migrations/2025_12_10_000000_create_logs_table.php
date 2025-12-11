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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->string('entidade'); // 'local', 'atividade', 'instalacao', etc
            $table->unsignedBigInteger('entidade_id'); // ID do registro modificado
            $table->string('operacao'); // 'criacao', 'edicao', 'inativacao', 'ativacao'
            $table->string('campo_alterado')->nullable(); // Campo específico que foi alterado
            $table->text('valor_anterior')->nullable(); // Valor anterior (para edição)
            $table->text('valor_novo')->nullable(); // Valor novo (para edição)
            $table->timestamps();

            $table->foreign('id_usuario')->references('id')->on('usuario')->onDelete('cascade');
            $table->index(['entidade', 'entidade_id']);
            $table->index(['id_usuario', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
