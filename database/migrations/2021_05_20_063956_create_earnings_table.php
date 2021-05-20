<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEarningsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('earnings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->unsignedTinyInteger('w_value')->default(0);
            $table->unsignedTinyInteger('is_factor')->default(0);
            $table->unsignedTinyInteger('is_fixed')->default(0);
            $table->unsignedTinyInteger('is_mb')->default(0);
            $table->float('percentage_of_salary',7,2);
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
        Schema::dropIfExists('earnings');
    }
}
