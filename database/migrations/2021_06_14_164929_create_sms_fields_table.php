<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSmsFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sms_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('column_id')->unsigned();
            $table->unsignedBigInteger('sms_id')->unsigned();
            $table->integer('order_by')->nullable();
            $table->tinyInteger('both_language')->default(0);
            $table->string('en_name',50)->nullable();
            $table->string('ar_name',50)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('column_id')->references('id')->on('column_selects');
            $table->foreign('sms_id')->references('id')->on('sms_templates');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sms_fields');
    }
}
