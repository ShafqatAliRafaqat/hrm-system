<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeModificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_modifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('modification_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->date('date_from')->nullable();
            $table->date('date_from_hijri')->nullable();
            $table->date('date_to')->nullable();
            $table->date('date_to_hijri')->nullable();
            $table->date('effectivity_date')->nullable();
            $table->date('effectivity_date_hijri')->nullable();
            $table->tinyInteger('flag')->default(0);
            $table->string('doc_id',10)->nullable();
            $table->string('subdoc_id',10)->nullable();
            $table->string('contact_no',20)->nullable();
            $table->string('from_value',20)->nullable();
            $table->string('to_value',20)->nullable();
            $table->string('en_from_info',200)->nullable();
            $table->string('ar_from_info',200)->nullable();
            $table->string('en_to_info',200)->nullable();
            $table->string('ar_to_info',200)->nullable();
            $table->string('comments',200)->nullable();
            $table->unsignedBigInteger('authorized_by')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('employee_id')->references('id')->on('employees');
            $table->foreign('modification_id')->references('id')->on('modifications');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employee_modifications');
    }
}
