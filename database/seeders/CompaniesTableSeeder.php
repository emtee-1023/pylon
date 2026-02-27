<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'id' => 1,
                'name' => 'Leah Distributors',
                'company_id' => 'leahdistributors',
                'created_at' => '2026-02-23 10:15:06',
                'updated_at' => '2026-02-23 10:15:06',
            ),
            1 => 
            array (
                'id' => 2,
                'name' => 'Kinetic Technology Limited',
                'company_id' => 'kinetictechnologylimited',
                'created_at' => '2026-02-23 10:23:42',
                'updated_at' => '2026-02-23 10:23:42',
            ),
        ));
        
        
    }
}