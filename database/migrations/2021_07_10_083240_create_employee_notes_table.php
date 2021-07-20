<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_notes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('report_to_position')->unsigned();
            $table->unsignedBigInteger('report_to_employee')->unsigned();
            $table->tinyInteger('badge_no')->nullable();
            $table->string('security_user_id',50)->nullable();
            $table->string('attendance_no',50)->nullable();
            $table->string('picture',200)->nullable();
            $table->string('notes',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('report_to_position')->references('id')->on('designations');
            $table->foreign('report_to_employee')->references('id')->on('employees');
            $table->foreign('employee_id')->references('id')->on('employees');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_notes');
    }
}
