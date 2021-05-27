<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGregHijriActual2sTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('greg_hijri_actual2s', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('hijri_date');
            $table->string('internal_date');
            $table->date('greg_date');
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
        Schema::dropIfExists('greg_hijri_actual2s');
    }
}
