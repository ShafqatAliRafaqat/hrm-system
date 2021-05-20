<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_description',50);
            $table->string('ar_description',50);
            $table->date('date_from');
            $table->date('date_to');
            $table->unsignedTinyInteger('no_work')->default(0);
            $table->unsignedTinyInteger('sessions')->default(0);
            $table->unsignedTinyInteger('ot')->default(0);
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
        Schema::dropIfExists('company_schedules');
    }
}
