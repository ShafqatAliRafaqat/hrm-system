<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeTrainingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_trainings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('education_id')->unsigned();
            $table->date('date_from')->nullable();
            $table->date('date_from_hijri')->nullable();
            $table->date('date_to')->nullable();
            $table->date('date_to_hijri')->nullable();
            $table->string('school',100)->nullable();
            $table->string('course',100)->nullable();
            $table->string('school_address',200)->nullable();
            $table->string('comments',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('education_id')->references('id')->on('education');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_trainings');
    }
}
