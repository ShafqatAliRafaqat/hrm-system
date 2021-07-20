<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDependentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_dependents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('column_id')->unsigned();
            $table->string('en_name',50)->nullable();
            $table->string('ar_name',50)->nullable();
            $table->string('en_middle_name',50)->nullable();
            $table->string('ar_middle_name',50)->nullable();
            $table->string('en_grand_name',50)->nullable();
            $table->string('ar_grand_name',50)->nullable();
            $table->string('en_family_name',50)->nullable();
            $table->string('ar_family_name',50)->nullable();
            $table->date('dob')->nullable();
            $table->string('dob_hijri',10)->nullable();
            $table->string('sex',3)->nullable();
            $table->string('iqama_no',20)->nullable();
            $table->string('mobile_no',20)->nullable();
            $table->string('hijri_age',20)->nullable();
            $table->string('age',20)->nullable();
            $table->string('address',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('column_id')->references('id')->on('column_selects');
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
        Schema::dropIfExists('employee_dependents');
    }
}
