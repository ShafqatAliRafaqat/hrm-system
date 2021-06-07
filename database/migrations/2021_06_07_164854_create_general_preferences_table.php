<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGeneralPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_preferences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->string('min_contract_months',10)->nullable();
            $table->string('max_contract_months',10)->nullable();
            $table->string('vacation_freq_contract',10)->nullable();
            $table->string('vacation_per_month',10)->nullable();
            $table->string('termination_notice',10)->nullable();
            $table->string('resignation_notice',20)->nullable();
            $table->string('service_award_less60',200)->nullable();
            $table->string('service_award_more60',200)->nullable();
            $table->string('bank_file',30)->nullable();
            $table->string('payment_type',30)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('currency_id')->references('id')->on('currency_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_preferences');
    }
}
