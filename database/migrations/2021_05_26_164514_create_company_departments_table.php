<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDepartmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_departments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->string('en_manager_name',50)->nullable();
            $table->string('ar_manager_name',50)->nullable();
            $table->string('acctgbranch',50)->nullable();
            $table->string('fabranch',50)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
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
        Schema::dropIfExists('company_departments');
    }
}
