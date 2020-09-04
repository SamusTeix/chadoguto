<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlteracaoTabelaItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id');
            $table->string('nome');
            $table->string('descricao');
            $table->float('preco');
        });

        Schema::create('tamanho', function (Blueprint $table) {
            $table->id();
            $table->integer('item_id');
            $table->integer('pequeno');
            $table->integer('medio');
            $table->integer('grande');
            $table->integer('unico');
        });

        Schema::create('tipo', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('item');
        Schema::drop('tamanho');
        Schema::drop('tipo');
    }
}
