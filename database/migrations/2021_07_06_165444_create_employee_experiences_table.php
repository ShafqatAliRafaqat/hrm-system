<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->date('date_from')->nullable();
            $table->date('date_from_hijri')->nullable();
            $table->date('date_to')->nullable();
            $table->date('date_to_hijri')->nullable();
            $table->string('ex_company',100)->nullable();
            $table->string('ex_position',100)->nullable();
            $table->string('ex_salary',10)->nullable();
            $table->string('reason_for_leaving',500)->nullable();
            $table->string('ex_address',500)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('employee_experiences');
    }
}
