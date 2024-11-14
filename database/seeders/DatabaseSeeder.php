<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Period;
use App\Models\Setting;
use App\Models\Village;
use App\Models\UserLevel;
use App\Models\SubDistrict;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        UserLevel::updateOrCreate([
            'id' => '1',
            'name' => 'Manager',
        ]);

        UserLevel::updateOrCreate([
            'id' => '2',
            'name' => 'Operator',
        ]);

        UserLevel::updateOrCreate([
            'id' => '3',
            'name' => 'Admin',
        ]);

        User::updateOrCreate(
            ['number' => 'MNG202411050001'],
            [
                'fullname' => 'Manager',
                'username' => 'manager',
                'gender' => 'F',
                'no_telp' => '08986564321',
                'email' => 'manager@gmail.com',
                'password' => Hash::make('111111'),
                'level_id' => 1,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['number' => 'ADM202411050001'],
            [
                'fullname' => 'Admin',
                'username' => 'admin',
                'gender' => 'M',
                'no_telp' => '08986564321',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('111111'),
                'level_id' => 3,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['number' => 'OPR202411050001'],
            [
                'fullname' => 'Operator',
                'username' => 'operator',
                'gender' => 'M',
                'no_telp' => '08986564321',
                'email' => 'operator@gmail.com',
                'password' => Hash::make('111111'),
                'level_id' => 2,
                'is_active' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'created_by' => 'admin',
            ]
        );

    }
}
