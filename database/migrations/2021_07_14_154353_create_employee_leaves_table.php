<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('leave_id')->unsigned();
            $table->date('start_date')->nullable();
            $table->date('start_date_hijri')->nullable();
            $table->date('end_date')->nullable();
            $table->date('end_date_hijri')->nullable();
            $table->date('back_to_work_date')->nullable();
            $table->date('back_to_work_date_hijri')->nullable();
            $table->date('application_date')->nullable();
            $table->date('application_date_hijri')->nullable();
            $table->date('vacation_due_date')->nullable();
            $table->date('vacation_due_date_hijri')->nullable();
            $table->date('work_from_date')->nullable();
            $table->date('work_from_date_hijri')->nullable();
            $table->date('work_to_date')->nullable();
            $table->date('work_to_date_hijri')->nullable();
            $table->string('balance',50)->nullable();
            $table->string('re_entry_exit_visa_no',50)->nullable();
            $table->string('status',50)->nullable();
            $table->string('contract_no',50)->nullable();
            $table->string('vacation_value',50)->nullable();
            $table->string('ticket_value',50)->nullable();
            $table->string('end_service_value',50)->nullable();
            $table->string('pay_roll_flag',50)->nullable();
            $table->string('salary_before_leave',50)->nullable();
            $table->string('vacation_value_paid',50)->nullable();
            $table->string('ticket_value_paid',50)->nullable();
            $table->string('end_service_value_paid',50)->nullable();
            $table->string('unused_days',50)->nullable();
            $table->string('begbal_setup',50)->nullable();
            $table->string('vacation_days',50)->nullable();
            $table->string('leave_due_days',50)->nullable();
            $table->string('req_no',50)->nullable();
            $table->string('days_req',50)->nullable();
            $table->string('isvdue_paid',50)->nullable();
            $table->string('monthly_salary',50)->nullable();
            $table->string('full_salary',50)->nullable();
            $table->string('period_covered',50)->nullable();
            $table->string('paid_days',50)->nullable();
            $table->string('duration',50)->nullable();
            $table->string('grant_days',50)->nullable();
            $table->string('month_due',50)->nullable();
            $table->string('remaining_balance',50)->nullable();
            $table->string('remarks',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('leave_id')->references('id')->on('leaves');
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
        Schema::dropIfExists('employee_leaves');
    }
}
