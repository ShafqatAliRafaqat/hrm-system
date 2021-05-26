<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDepartmentSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('department_id')->unsigned();
            $table->string('en_name',50)->nullable();
            $table->string('ar_name',50)->nullable();
            $table->string('status',50)->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('department_id')->references('id')->on('company_departments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_sections');
    }
}
