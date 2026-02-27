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
                'branding' => '{"logo_url": null, "text_color_dark": "#FFFFFF", "text_color_light": "#000000", "default_theme_mode": "dark", "primary_color_dark": "#1976D2", "surface_color_dark": "#242424", "primary_color_light": "#1565c0", "surface_color_light": "#ebebeb", "secondary_color_dark": "#1976d2", "background_color_dark": "#ffffff", "secondary_color_light": "#1565c0", "background_color_light": "#FFFFFF"}',
                'api_config' => '{"endpoint": "http://192.168.88.189:8001/api"}',
                'created_at' => '2026-02-23 10:15:06',
                'updated_at' => '2026-02-25 09:40:12',
            ),
            1 => 
            array (
                'id' => 2,
                'company_id' => 2,
                'app_id' => 1,
                'branding' => '{"logo_url": null, "text_color_dark": "#f7f7f7", "text_color_light": "#000000", "default_theme_mode": "light", "primary_color_dark": "#ff6502", "surface_color_dark": "#1f1f1f", "primary_color_light": "#ff6502", "surface_color_light": "#ebebeb", "secondary_color_dark": "#ff6502", "background_color_dark": "#ffffff", "secondary_color_light": "#ff6502", "background_color_light": "#ffffff"}',
                'api_config' => '{"endpoint": "http://192.168.88.189:8001/api"}',
                'created_at' => '2026-02-23 10:23:42',
                'updated_at' => '2026-02-25 09:42:31',
            ),
        ));
        
        
    }
}