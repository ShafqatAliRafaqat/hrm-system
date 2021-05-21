<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->integer('duration')->nullable();
            $table->unsignedTinyInteger('is_salary')->default(0);
            $table->unsignedTinyInteger('requirevisa')->default(0);
            $table->unsignedTinyInteger('withpay')->default(0);
            $table->unsignedTinyInteger('operator')->default(0);
            $table->unsignedTinyInteger('extra_leavecalc')->default(0);
            $table->unsignedTinyInteger('is_active')->default(0);
            $table->unsignedTinyInteger('is_settlement')->default(0);
            $table->unsignedTinyInteger('request')->default(0);
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
        Schema::dropIfExists('leaves');
    }
}
