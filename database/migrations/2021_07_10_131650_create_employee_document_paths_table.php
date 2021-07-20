<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeeDocumentPathsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employee_document_paths', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('employee_id')->unsigned();
            $table->unsignedBigInteger('document_type_id')->unsigned();
            $table->unsignedBigInteger('employee_document_id')->unsigned();
            $table->string('document_no',20)->nullable();
            $table->string('document_file_name',50)->nullable();
            $table->string('document_type',50)->nullable();
            $table->string('path',200)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->foreign('document_type_id')->references('id')->on('document_types');
            $table->foreign('employee_document_id')->references('id')->on('employee_documents');
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
        Schema::dropIfExists('employee_document_paths');
    }
}
