<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColumnSelectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('column_selects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('group_by')->nullable();
            $table->integer('order_by')->nullable();
            $table->integer('language_order_by')->nullable();
            $table->tinyInteger('both_language')->default(0);
            $table->string('en_name',50)->nullable();
            $table->string('ar_name',50)->nullable();
            $table->string('en_description',500)->nullable();
            $table->string('ar_description',500)->nullable();
            $table->string('type',20)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('column_selects');
    }
}
