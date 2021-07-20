<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeAddressesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_addresses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('local_city_id')->unsigned();
            $table->unsignedBigInteger('local_country_id')->unsigned();
            $table->unsignedBigInteger('home_city_id')->unsigned();
            $table->unsignedBigInteger('home_country_id')->unsigned();
            $table->string('local_address_1',200)->nullable();
            $table->string('local_address_2',200)->nullable();
            $table->string('local_address_3',200)->nullable();
            $table->string('home_address_1',200)->nullable();
            $table->string('home_address_2',200)->nullable();
            $table->string('home_address_3',200)->nullable();
            $table->string('local_postal_code',6)->nullable();
            $table->string('home_postal_code',6)->nullable();
            $table->string('local_phone',15)->nullable();
            $table->string('home_phone',15)->nullable();
            $table->string('local_telephone',15)->nullable();
            $table->string('home_telephone',15)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('local_city_id')->references('id')->on('cities');
            $table->foreign('local_country_id')->references('id')->on('countries');
            $table->foreign('home_city_id')->references('id')->on('cities');
            $table->foreign('home_country_id')->references('id')->on('countries');
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
        Schema::dropIfExists('employee_addresses');
    }
}
