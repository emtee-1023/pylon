<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ApiKeysTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('api_keys')->delete();
        
        \DB::table('api_keys')->insert(array (
            0 => 
            array (
                'id' => 1,
                'app_name' => 'Kronos',
                'key_hash' => 'a4f78156c48f283ffd55430b029b60e71d84cb35b20f9ded15bfc5b76790600e',
                'scopes' => '["config:read"]',
                'active' => 1,
                'last_used_at' => '2026-02-23 14:18:35',
                'created_at' => '2026-02-23 10:13:41',
                'updated_at' => '2026-02-23 14:18:35',
            ),
            1 => 
            array (
                'id' => 2,
                'app_name' => 'ESS',
                'key_hash' => '5f64cfd230ef26dcb10e0ce965e9a0090a3ed8797976b6f378d35bed4ea831bb',
                'scopes' => '["config:read"]',
                'active' => 1,
                'last_used_at' => NULL,
                'created_at' => '2026-02-23 10:23:54',
                'updated_at' => '2026-02-23 10:23:54',
            ),
            2 => 
            array (
                'id' => 3,
                'app_name' => 'Membership Portal',
                'key_hash' => '684419e246f05829692442b1da5c24be498cf29430d04bc91e4990cdaa72269d',
                'scopes' => '["config:read"]',
                'active' => 1,
                'last_used_at' => NULL,
                'created_at' => '2026-02-23 10:24:07',
                'updated_at' => '2026-02-23 10:24:07',
            ),
        ));
        
        
    }
}