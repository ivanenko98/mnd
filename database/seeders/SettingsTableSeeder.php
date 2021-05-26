<?php

use App\Portal\Models\City;
use App\Portal\Models\Role;
use App\Portal\Models\Service;
use App\Portal\Models\Setting;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SettingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $settings = [
            'language' => 'uk'
        ];

        foreach ($settings as $setting_title => $value) {
            Setting::create(['title' => $setting_title]);
        }

        foreach (User::all() as $user) {
            foreach (Setting::all() as $setting) {
                $user->settings()->attach($setting->id, ['value' => $settings[$setting->title]]);
            }
        }
    }
}
