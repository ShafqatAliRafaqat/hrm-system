<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDeducationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_deducations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('deduction_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('start_date_hijri')->nullable();
            $table->date('end_date')->nullable();
            $table->date('end_date_hijri')->nullable();
            $table->date('loan_date')->nullable();
            $table->date('loan_date_hijri')->nullable();
            $table->integer('contract_no')->nullable();
            $table->integer('paid_flag')->nullable();
            $table->integer('to_be_paid')->nullable();
            $table->integer('leave_no')->nullable();
            $table->integer('req_no')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->float('amount',7,2)->nullable();
            $table->float('amount_to_be_paid',7,2)->nullable();
            $table->float('amount_paid',7,2)->nullable();
            $table->string('no_of_payments',10)->nullable();
            $table->string('deduction_remarks',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('deduction_id')->references('id')->on('deductions');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_deducations');
    }
}
