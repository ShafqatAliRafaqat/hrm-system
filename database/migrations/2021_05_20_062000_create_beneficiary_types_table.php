<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBeneficiaryTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('beneficiary_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('en_name',50);
            $table->string('ar_name',50);
            $table->unsignedTinyInteger('finalsetflag')->default(0);
            $table->unsignedTinyInteger('moneyvalueflag')->default(0);
            $table->unsignedTinyInteger('holidayflag')->default(0);
            $table->unsignedTinyInteger('printable')->default(0);
            $table->string('parentbenefit',5);
            
            $table->unsignedTinyInteger('modifyflag')->default(0);
            $table->unsignedTinyInteger('is_active')->default(0);
            $table->unsignedTinyInteger('credit_glid')->default(0);
            $table->unsignedTinyInteger('showinreport')->default(0);
            $table->unsignedTinyInteger('mulfactor')->default(0);
            $table->unsignedTinyInteger('percent_frsalary')->default(0);
            $table->unsignedTinyInteger('mb')->default(0);
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
        Schema::dropIfExists('beneficiary_types');
    }
}
