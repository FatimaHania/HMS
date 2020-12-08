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

        DB::insert('insert into usertypes (id,description) values (1,"Hospital"),(2,"Physician"),(3,"Patient"),(4,"Pharmacy"),(5,"Laboratory")');
    }
}
