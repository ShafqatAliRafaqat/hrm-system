<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDocumentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_documents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('document_type_id')->unsigned();
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->tinyInteger('renew_flag')->default(0);
            $table->tinyInteger('current_flag')->default(0);
            $table->tinyInteger('visa_validity')->default(0);
            $table->tinyInteger('validity_unit')->default(0);
            $table->date('date_issued')->nullable();
            $table->date('date_issued_hijri')->nullable();
            $table->date('date_expire')->nullable();
            $table->date('date_expire_hijri')->nullable();
            $table->date('date_entry')->nullable();
            $table->date('date_entry_hijri')->nullable();
            $table->date('return_date')->nullable();
            $table->date('return_date_hijri')->nullable();
            $table->string('dependents_no',50)->nullable();
            $table->string('sponsor_no',50)->nullable();
            $table->string('document_no',50)->nullable();
            $table->string('port_entry',200)->nullable();
            $table->string('notes',200)->nullable();
            $table->string('issuing_authority',200)->nullable();
            $table->string('en_description',500)->nullable();
            $table->string('ar_description',500)->nullable();
            $table->string('remarks',500)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('document_type_id')->references('id')->on('document_types');
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
        Schema::dropIfExists('employee_documents');
    }
}
