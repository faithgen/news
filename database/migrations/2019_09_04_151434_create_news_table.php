<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fg_news', function (Blueprint $table) {
            $table->string('id', 150)->primary();
            $table->string('ministry_id', 150)->index();
            $table->string('title');
            $table->longText('news');
            $table->timestamps();

            $table->foreign('ministry_id')->references('id')->on('fg_ministries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fg_news');
    }
}
