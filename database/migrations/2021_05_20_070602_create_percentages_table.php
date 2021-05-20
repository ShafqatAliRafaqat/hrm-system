<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePercentagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percentages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->integer('value')->default(0);
            $table->integer('to')->default(0);
            $table->integer('from')->default(0);
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('percentages');
    }
}
