<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CriaçãoDasTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email');
        });

        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('descricao');
            $table->integer('tamanho');
            $table->integer('quantidade');
        });

        Schema::create('imagem', function (Blueprint $table) {
            $table->id();
            $table->string('tabela');
            $table->integer('tabela_id');
            $table->string('nome');
            $table->text('link');
        });

        Schema::create('link', function (Blueprint $table) {
            $table->id();
            $table->string('tabela');
            $table->integer('tabela_id');
            $table->string('nome');
            $table->text('link');
        });        

        Schema::create('doacao', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('tipo');
            $table->integer('canal');
            $table->integer('finalizado');
        });

        Schema::create('doacao_item', function (Blueprint $table) {
            $table->id();
            $table->integer('id_doacao');
            $table->integer('tamanho');
        });

        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('login');
            $table->string('senha');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('usuario');
        Schema::drop('item');
        Schema::drop('imagem');
        Schema::drop('link');
        Schema::drop('doacao');
        Schema::drop('doacao_item');
        Schema::drop('admin');
    }
}
