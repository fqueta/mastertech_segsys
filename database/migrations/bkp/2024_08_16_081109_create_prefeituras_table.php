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
        Schema::create('prefeituras', function (Blueprint $table) {
            $table->id();
            $table->string('nome','256')->nullable();
            $table->string('prefix','256')->nullable();
            $table->string('database','256')->nullable();
            $table->longText('obs')->nullable();
            $table->longText('config')->nullable();
            $table->enum('excluido',['n','s']);
            $table->text('reg_excluido')->nullable();
            $table->enum('deletado',['n','s']);
            $table->string('domain')->unique()->nullable();
            $table->text('reg_deletado')->nullable();
            $table->enum('criar_table',['n','s']);
            $table->enum('ativo',['s','n']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prefeituras');
    }
};
