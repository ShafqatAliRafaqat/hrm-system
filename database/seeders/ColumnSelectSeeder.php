<?php

namespace Database\Seeders;

use App\Models\ColumnSelect;
use App\Models\Role;
use Illuminate\Database\Seeder;

class ColumnSelectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $columnselect = array(
            array('group_by'=>1,'order_by'=>1, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'firstname','ar_name' => 'firstname','en_description' => 'First Name','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>2, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'lastname','ar_name' => 'lastname','en_description' => 'Last Name','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>3, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'basic_salary','ar_name' => 'basic_salary','en_description' => 'Basic Salary','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>4, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'birth_place','ar_name' => 'birth_place','en_description' => 'Birth Place','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>5, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'bank_account_no','ar_name' => 'bank_account_no','en_description' => 'Bank Account No','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>6, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'bonus','ar_name' => 'bonus','en_description' => 'Bonus','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>7, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'designation','ar_name' => 'designation','en_description' => 'Designation','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>8, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'hired_date','ar_name' => 'hired_date','en_description' => 'Hired Date','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>9, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'nationailty','ar_name' => 'nationailty','en_description' => 'Nationailty','ar_description' => 'الإسم','type' => 'L'),
            array('group_by'=>1,'order_by'=>10, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'birth_date','ar_name' => 'birth_date','en_description' => 'Birth Date','ar_description' => 'الإسم','type' => 'L'),

            array('group_by'=>2,'order_by'=>1, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'contract','ar_name' => 'contract','en_description' => 'Contract','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>2, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'company','ar_name' => 'company','en_description' => 'Company','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>3, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'basic_salary','ar_name' => 'basic_salary','en_description' => 'Basic Salary','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>4, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'birth_place','ar_name' => 'birth_place','en_description' => 'Birth Place','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>5, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'city','ar_name' => 'city','en_description' => 'City','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>6, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'branch','ar_name' => 'branch','en_description' => 'Branch','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>7, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'civil_status','ar_name' => 'civil_status','en_description' => 'Civil Status','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>8, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'hired_date','ar_name' => 'hired_date','en_description' => 'Hired Date','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>9, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'nationailty','ar_name' => 'nationailty','en_description' => 'Nationailty','ar_description' => 'الإسم','type' => 'S'),
            array('group_by'=>2,'order_by'=>10, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'birth_date','ar_name' => 'birth_date','en_description' => 'Birth Date','ar_description' => 'الإسم','type' => 'S'),

            array('group_by'=>3,'order_by'=>1, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'wife','ar_name' => 'wife','en_description' => 'wife','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>2, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'husband','ar_name' => 'husband','en_description' => 'husband','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>3, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'mother','ar_name' => 'mother','en_description' => 'mother','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>4, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'father','ar_name' => 'father','en_description' => 'father','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>5, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'brother','ar_name' => 'brother','en_description' => 'brother','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>6, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'son','ar_name' => 'son','en_description' => 'son','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>7, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'daughter','ar_name' => 'daughter','en_description' => 'daughter','ar_description' => 'الإسم','type' => 'dependents'),
            array('group_by'=>3,'order_by'=>8, 'language_order_by'=>1,'both_language'=>1,'en_name' => 'cousin','ar_name' => 'cousin','en_description' => 'cousin','ar_description' => 'الإسم','type' => 'dependents'),
            );
        foreach ($columnselect as $column) {
            ColumnSelect::create($column);
        }
    }
}
