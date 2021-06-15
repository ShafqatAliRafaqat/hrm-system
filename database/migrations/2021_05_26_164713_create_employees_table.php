<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('position_id')->unsigned();
            $table->unsignedBigInteger('country_id')->unsigned();
            $table->unsignedBigInteger('city_id')->unsigned();
            $table->unsignedBigInteger('religion_id')->unsigned();
            $table->unsignedBigInteger('company_id')->unsigned();
            $table->unsignedBigInteger('department_id')->unsigned();
            $table->unsignedBigInteger('cost_center_id')->unsigned();
            $table->unsignedBigInteger('branch_id')->unsigned();
            $table->Integer('sponsor_id')->nullable();
            $table->Integer('shift_id')->nullable();
            $table->Integer('security_user_id')->nullable();
            $table->string('en_first_name',50);
            $table->string('ar_first_name',50);
            $table->string('en_middle_name',50)->nullable();
            $table->string('ar_middle_name',50)->nullable();
            $table->string('en_last_name',50)->nullable();
            $table->string('ar_last_name',50)->nullable();
            $table->string('en_grand_name',50)->nullable();
            $table->string('ar_grand_name',50)->nullable();
            $table->string('civil_status',10)->nullable();
            $table->string('sex',3)->nullable();
            $table->string('birthplace',30)->nullable();
            $table->string('email',30)->nullable();
            $table->date('dob')->nullable();
            $table->date('hired_date')->nullable();
            $table->string('dob_hijri',10)->nullable();
            $table->string('hired_date_hijri',10)->nullable();
            $table->string('position_as_per_iqama',30)->nullable();
            $table->string('remarks_1',100)->nullable();
            $table->string('remarks_2',100)->nullable();
            $table->string('status',10)->nullable();
            $table->string('dt_onloc',10)->nullable();
            $table->string('contract',20)->nullable();
            $table->string('insurance',20)->nullable();
            $table->string('section',20)->nullable();
            $table->string('hijri_age',20)->nullable();
            $table->string('bank_account_no',20)->nullable();
            $table->string('iqama_no',20)->nullable();
            $table->string('mobile_no',20)->nullable();
            $table->string('attendance_no',20)->nullable();
            $table->string('report_to_pos',20)->nullable();
            $table->string('report_to_emp',20)->nullable();
            $table->string('use_ms_glid',20)->nullable();
            $table->string('lang',20)->nullable();
            $table->string('badgeno',20)->nullable();
            $table->string('attuser',20)->nullable();
            $table->string('delegate',20)->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->unsignedBigInteger('deleted_by')->nullable();
            $table->timestamps();
            $table->softdeletes();
            $table->foreign('company_id')->references('id')->on('companies');
            $table->foreign('branch_id')->references('id')->on('company_branches');
            $table->foreign('position_id')->references('id')->on('designations');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('city_id')->references('id')->on('cities');
            $table->foreign('religion_id')->references('id')->on('religions');
            $table->foreign('department_id')->references('id')->on('company_departments');
            $table->foreign('cost_center_id')->references('id')->on('cost_centers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('employees');
    }
}
