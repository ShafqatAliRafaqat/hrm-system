<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollSpecificPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_specific_preferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->tinyInteger('sub_ledger_id')->default(0);
            $table->tinyInteger('monthly_pay')->default(0);
            $table->tinyInteger('post_to_account')->default(0);
            $table->tinyInteger('return_date')->default(0);
            $table->tinyInteger('calculate_extraleave')->default(0);
            $table->tinyInteger('use_twoglacct_inbenefits')->default(0);
            $table->tinyInteger('map_to_acctg_branch')->default(0);
            $table->tinyInteger('payroll_rounding')->default(0);
            $table->tinyInteger('attendance_mc')->default(0);
            $table->tinyInteger('costcenter_based_attendance')->default(0);
            $table->tinyInteger('entry_overtime')->default(0);
            $table->tinyInteger('split_payroll')->default(0);
            $table->tinyInteger('auto_gosi_calculate')->default(0);
            $table->string('gosi_alert_days',50)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payroll_specific_preferences');
    }
}
