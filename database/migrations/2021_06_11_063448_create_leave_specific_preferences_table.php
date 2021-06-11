<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaveSpecificPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_specific_preferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->tinyInteger('forward_vacation_days_balance')->default(0);
            $table->tinyInteger('current_days_month')->default(0);
            $table->tinyInteger('use_latest_salary_calc')->default(0);
            $table->tinyInteger('include_vacation_days')->default(0);
            $table->date('fiscal_year_end');
            $table->smallInteger('days_in_year')->nullable();
            $table->smallInteger('vacation_days_per_contract')->nullable();
            $table->smallInteger('vacation_per_contract')->nullable();
            $table->tinyInteger('include_eos')->default(0);
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
        Schema::dropIfExists('leave_specific_preferences');
    }
}
