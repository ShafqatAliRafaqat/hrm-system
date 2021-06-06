<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_branches', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->string('en_manager_name',50)->nullable();
            $table->string('ar_manager_name',50)->nullable();
            $table->string('address_1',200)->nullable();
            $table->string('address_2',200)->nullable();
            $table->string('address_3',200)->nullable();
            $table->string('address_4',200)->nullable();
            $table->string('postal_code',6)->nullable();
            $table->string('state_region',30)->nullable();
            $table->string('phone_1',15)->nullable();
            $table->string('phone_2',15)->nullable();
            $table->string('phone_3',15)->nullable();
            $table->string('fax_1',15)->nullable();
            $table->string('fax_2',15)->nullable();
            $table->string('fax_3',15)->nullable();
            $table->string('email',15)->nullable();
            $table->string('website',50)->nullable();
            $table->string('status',6)->nullable();
            $table->string('remarks_1',200)->nullable();
            $table->string('remarks_2',200)->nullable();
            $table->string('remarks_3',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('country_id')->references('id')->on('countries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_branches');
    }
}
