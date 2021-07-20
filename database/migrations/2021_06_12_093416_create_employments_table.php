<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmploymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->date('start_date_hijri')->nullable();
            $table->date('end_date_hijri')->nullable();
            $table->date('termination_date')->nullable();
            $table->date('termination_notice_date')->nullable();
            $table->date('termination_effective_date')->nullable();
            $table->date('termination_date_hijri')->nullable();
            $table->date('termination_notice_date_hijri')->nullable();
            $table->date('termination_effective_date_hijri')->nullable();
            $table->date('vacation_due_date')->nullable();
            $table->date('vacation_due_date_hijri')->nullable();
            $table->date('contract_date')->nullable();
            $table->integer('bank_id')->nullable();
            $table->tinyInteger('current_flag')->nullable();
            $table->tinyInteger('contract_status')->nullable();
            $table->tinyInteger('terminate_flag')->nullable();
            $table->string('final_set_flag',10)->nullable();
            $table->string('vacation_month_due',20)->nullable();
            $table->string('no_login',20)->nullable();
            $table->string('bank_account_no',30)->nullable();
            $table->string('contract_type',50)->nullable();
            $table->string('contract_family_flag',50)->nullable();
            $table->string('contract_no',50)->nullable();
            $table->string('contract_duration',50)->nullable();
            $table->string('time_unit_duration',50)->nullable();
            $table->string('termination_type',50)->nullable();
            $table->string('contract_created_by',100)->nullable();
            $table->string('terminated_by',100)->nullable();
            $table->string('terminated_when',100)->nullable();     
            $table->string('vacation_days',100)->nullable();
            $table->string('renew',200)->nullable();
            $table->string('rank',200)->nullable();
            $table->string('work_hrs',200)->nullable();
            $table->string('contract_remark',500)->nullable();
            $table->string('termination_remark',500)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('city_id')->references('id')->on('cities');
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
        Schema::dropIfExists('employments');
    }
}
