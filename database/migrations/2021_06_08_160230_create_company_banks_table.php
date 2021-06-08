<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBanksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_banks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->unsignedBigInteger('currency_id')->unsigned();
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->string('account_type',50)->nullable();
            $table->string('account_no',50)->nullable();
            $table->Integer('gl_acct_code')->nullable();
            $table->string('address_1',200)->nullable();
            $table->string('address_2',200)->nullable();
            $table->string('address_3',200)->nullable();
            $table->string('address_4',200)->nullable();
            $table->string('bank_code',30)->nullable();
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
        Schema::dropIfExists('company_banks');
    }
}
