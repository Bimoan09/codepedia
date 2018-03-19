<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableComments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('article_id')->unsigned();
            $table->integer('visitor_id')->unsigned();
            $table->text('comments');
            $table->boolean('is_parent')->default('0');
            $table->integer('parent_id')->nullable();
            $table->boolean('is_show')->default('0');
            $table->timestamps();
          });

          Schema::table('comments', function($table){
             $table->foreign('article_id')->references('id')->on('articles')->onDelete('cascade');
             $table->foreign('visitor_id')->references('id')->on('visitors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
    }
}
