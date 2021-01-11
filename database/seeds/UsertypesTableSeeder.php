<?php

use Illuminate\Database\Seeder;

class UsertypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('usertypes')->delete();

        DB::insert('insert into usertypes (id,description,show_in_register_form) values (1,"Hospital",0),(2,"Patient/Physician",1),(4,"Pharmacy",0),(5,"Laboratory",0)');
    }
}
