<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEvaluationResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_evaluation_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('employee_evaluation_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('evaluation_type_id')->unsigned();
            $table->date('date_from')->nullable();
            $table->date('date_from_hijri')->nullable();
            $table->date('date_to')->nullable();
            $table->date('date_to_hijri')->nullable();
            $table->string('rate_value',20)->nullable();
            $table->string('max_mark',20)->nullable();
            $table->string('grade',20)->nullable();
            $table->string('percentage',20)->nullable();
            $table->string('score',20)->nullable();
            $table->json('evaluation_ids')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('employee_evaluation_id')->references('id')->on('employee_evaluations');
            $table->foreign('evaluation_type_id')->references('id')->on('evaluation_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_evaluation_results');
    }
}
