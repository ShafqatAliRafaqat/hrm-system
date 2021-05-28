<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCountriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_name',50);
            $table->string('ar_name',50)->nullable();
            $table->string('en_nationality',50)->nullable();
            $table->string('ar_nationality',50)->nullable();
            $table->string('code',3)->nullable();
            $table->string('numcode',3)->nullable();
            $table->string('phonecode',4)->nullable();
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
        Schema::dropIfExists('countries');
    }
}
