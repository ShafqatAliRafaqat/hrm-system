<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeductionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deductions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->string('credit_glid',50);
            $table->string('parentdeduction',50);
            $table->unsignedTinyInteger('modifyflag')->default(0);
            $table->unsignedTinyInteger('is_request')->default(0);
            $table->unsignedTinyInteger('is_fixed')->default(0);
            $table->unsignedTinyInteger('is_mb')->default(0);
            $table->unsignedTinyInteger('printable')->default(0);
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
        Schema::dropIfExists('deductions');
    }
}
