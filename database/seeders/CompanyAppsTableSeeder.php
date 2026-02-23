<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CompanyAppsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('company_apps')->delete();
        
        \DB::table('company_apps')->insert(array (
            0 => 
            array (
                'id' => 1,
                'company_id' => 1,
                'app_id' => 1,
                'branding' => '{"primary_color_light":"#1976D2","primary_color_dark":"#1976D2","secondary_color_light":"#e70404","secondary_color_dark":"#424242","background_color_light":"#FFFFFF","background_color_dark":"#1E1E1E","surface_color_light":"#F5F5F5","surface_color_dark":"#2D2D2D","logo_url":null,"default_theme_mode":"light"}',
                'api_config' => '{"endpoint":"http:\\/\\/192.168.88.129:8000\\/api"}',
                'created_at' => '2026-02-23 10:15:06',
                'updated_at' => '2026-02-23 13:44:26',
            ),
            1 => 
            array (
                'id' => 2,
                'company_id' => 2,
                'app_id' => 1,
                'branding' => '{"primary_color_light":"#19d27b","primary_color_dark":"#08e792","secondary_color_light":"#19d29a","secondary_color_dark":"#00ff9d","background_color_light":"#FFFFFF","background_color_dark":"#d10000","surface_color_light":"#F5F5F5","surface_color_dark":"#ff0a0a","logo_url":null,"default_theme_mode":"system"}',
                'api_config' => '{"endpoint":"http:\\/\\/192.168.88.189:8001\\/api"}',
                'created_at' => '2026-02-23 10:23:42',
                'updated_at' => '2026-02-23 13:52:42',
            ),
            2 => 
            array (
                'id' => 3,
                'company_id' => 2,
                'app_id' => 3,
                'branding' => '{"primary_color_light":"#1976D2","primary_color_dark":"#1976D2","secondary_color_light":"#424242","secondary_color_dark":"#424242","background_color_light":"#FFFFFF","background_color_dark":"#1E1E1E","surface_color_light":"#F5F5F5","surface_color_dark":"#2D2D2D","logo_url":null,"default_theme_mode":"system"}',
                'api_config' => '{"endpoint":null}',
                'created_at' => '2026-02-23 10:24:21',
                'updated_at' => '2026-02-23 10:24:21',
            ),
            3 => 
            array (
                'id' => 4,
                'company_id' => 2,
                'app_id' => 2,
                'branding' => '{"primary_color_light":"#1976D2","primary_color_dark":"#1976D2","secondary_color_light":"#424242","secondary_color_dark":"#424242","background_color_light":"#FFFFFF","background_color_dark":"#1E1E1E","surface_color_light":"#F5F5F5","surface_color_dark":"#2D2D2D","logo_url":null,"default_theme_mode":"system"}',
                'api_config' => '{"endpoint":null}',
                'created_at' => '2026-02-23 10:24:29',
                'updated_at' => '2026-02-23 10:24:29',
            ),
        ));
        
        
    }
}