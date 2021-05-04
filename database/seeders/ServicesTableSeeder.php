<?php

use App\Portal\Models\Role;
use App\Portal\Models\Service;
use App\Portal\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ServicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $skills = [
            'Ремонт Холодильників',
            'Ремонт Колонок' => [
                'Ремонт Запальника',
                'Перевірка Автоматики'
            ],
            'Ремонт Пральних Машин',
            'Ремонт Котлів'
        ];

        foreach ($skills as $skill_title => $skill) {
            if (is_array($skill)) {
                $parent_id = Service::create(['title' => $skill_title])->id;

                foreach ($skill as $child_title) {
                    Service::create(['title' => $child_title, 'parent_id' => $parent_id]);
                }
            } else {
                Service::create(['title' => $skill]);
            }
        }
    }
}
