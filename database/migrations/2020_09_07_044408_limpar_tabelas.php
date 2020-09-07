<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class LimparTabelas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('admin');
        Schema::dropIfExists('doacao');
        Schema::dropIfExists('doacao_item');
        Schema::dropIfExists('doacao_tipo');
        Schema::dropIfExists('imagem');
        Schema::dropIfExists('item');
        Schema::dropIfExists('link');
        Schema::dropIfExists('tamanho');
        Schema::dropIfExists('tipo');
        Schema::dropIfExists('usuario');

        Schema::create('admin', function (Blueprint $table) {
            $table->id();
            $table->string('login');
            $table->string('senha');
        });

        Schema::create('doacao', function (Blueprint $table) {
            $table->id();
            $table->integer('id_usuario');
            $table->integer('tipo')->default(0);
            $table->integer('canal')->default(0);
            $table->integer('finalizado')->default(0);
            $table->string('token');
        });

        Schema::create('doacao_item', function (Blueprint $table) {
            $table->id();
            $table->integer('id_item');
            $table->integer('id_doacao');
            $table->string('tamanho');
            $table->integer('quantidade');
        });

        Schema::create('doacao_tipo', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('imagem');
            $table->string('descricao');
            $table->string('dados');
        });

        Schema::create('imagem', function (Blueprint $table) {
            $table->id();
            $table->string('tabela');
            $table->integer('tabela_id');
            $table->string('nome');
            $table->string('link');
        });

        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id');
            $table->integer('lista');
            $table->string('nome');
            $table->string('descricao');
            $table->float('preco');
        });

        Schema::create('link', function (Blueprint $table) {
            $table->id();
            $table->string('tabela');
            $table->integer('tabela_id');
            $table->string('nome');
            $table->string('link');
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

        Schema::create('usuario', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('sobrenome');
            $table->string('email');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
