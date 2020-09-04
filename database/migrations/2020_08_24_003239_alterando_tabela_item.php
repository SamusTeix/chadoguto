<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterandoTabelaItem extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::drop('item');
        Schema::create('item', function (Blueprint $table) {
            $table->id();
            $table->integer('tipo_id');
            $table->integer('lista');
            $table->string('nome');
            $table->string('descricao');
            $table->float('preco');
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
    }
}
