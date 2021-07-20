<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEvaluationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_evaluations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('evaluator_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('evaluation_type_id')->unsigned();
            $table->date('date_from')->nullable();
            $table->date('date_from_hijri')->nullable();
            $table->date('date_to')->nullable();
            $table->date('date_to_hijri')->nullable();
            $table->date('evaluation_date')->nullable();
            $table->date('evaluation_date_hijri')->nullable();
            $table->integer('contract_no')->nullable();
            $table->string('remarks',200)->nullable();
            $table->string('achievements',200)->nullable();
            $table->string('recommendations',200)->nullable();
            $table->string('employee_notes',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('evaluator_id')->references('id')->on('employees');
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
        Schema::dropIfExists('employee_evaluations');
    }
}
