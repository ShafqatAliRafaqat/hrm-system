<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('beneficiary_id')->unsigned();
            $table->date('benefit_effective_date')->nullable();
            $table->date('benefit_effective_date_hijri')->nullable();
            $table->date('benefit_end_date')->nullable();
            $table->date('benefit_end_date_hijri')->nullable();
            $table->date('termination_date')->nullable();
            $table->date('termination_date_hijri')->nullable();
            $table->date('transaction_date')->nullable();
            $table->date('transaction_date_hijri')->nullable();
            $table->integer('contract_no')->nullable();
            $table->tinyInteger('final_set_flag')->nullable();
            $table->tinyInteger('money_value')->nullable();
            $table->float('amount',7,2)->nullable();
            $table->float('monthly_pay',7,2)->nullable();
            $table->float('absence_pay',7,2)->nullable();
            $table->float('late_pay',7,2)->nullable();
            $table->string('payment_scheme',10)->nullable();
            $table->string('no_of_days',10)->nullable();
            $table->string('return_towork',10)->nullable();
            $table->string('benefit_remark',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('beneficiary_id')->references('id')->on('beneficiary_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_earnings');
    }
}
