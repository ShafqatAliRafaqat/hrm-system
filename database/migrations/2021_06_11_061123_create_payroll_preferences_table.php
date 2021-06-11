<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayrollPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payroll_preferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->smallInteger('hours_per_month')->nullable();
            $table->smallInteger('days_per_month')->nullable();
            $table->smallInteger('ot')->nullable();
            $table->float('tardiness_factor',7,2)->nullable();
            $table->float('absent_factor',7,2)->nullable();
            $table->tinyInteger('calc_outside_payroll')->default(0);
            $table->tinyInteger('calc_overtime_payroll')->default(0);
            $table->tinyInteger('posttoacct_ot_outside_payroll')->default(0);
            $table->tinyInteger('days_only')->default(0);
            $table->tinyInteger('full_housing')->default(0);
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
        Schema::dropIfExists('payroll_preferences');
    }
}
