<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->text('nome');
            $table->text('slug');
            $table->text('capa')->nullable();
            $table->text('video')->nullable();
            $table->text('descricao')->nullable();
            $table->text('conteudo')->nullable();
            $table->text('tipo')->nullable();
            $table->integer('status')->default('1');
            $table->bigInteger('idCategoria')->nullable()->unsigned();
            $table->foreign('idCategoria')->references('id')->on('categorias')->onDelete('cascade');;
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
