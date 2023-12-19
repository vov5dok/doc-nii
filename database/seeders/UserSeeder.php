<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Leeto\MoonShine\Models\MoonshineUser;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        MoonshineUser::create([
            'email'                  => 'admin@test.local',
            'name'                   => 'admin',
            'moonshine_user_role_id' => 1,
            'active'                 => true,
            'password'               => Hash::make('1234567890'),
        ]);
        MoonshineUser::create([
            'email'                  => 'applicant@test.local',
            'name'                   => 'applicant',
            'moonshine_user_role_id' => 4,
            'active'                 => true,
            'password'               => Hash::make('1234567890'),
        ]);
        MoonshineUser::create([
            'email'                  => 'employee@test.local',
            'name'                   => 'employee',
            'moonshine_user_role_id' => 5,
            'active'                 => true,
            'password'               => Hash::make('1234567890'),
        ]);
        MoonshineUser::create([
            'email'                  => 'participant@test.local',
            'name'                   => 'participant',
            'moonshine_user_role_id' => 3,
            'active'                 => true,
            'password'               => Hash::make('1234567890'),
        ]);
    }
}
