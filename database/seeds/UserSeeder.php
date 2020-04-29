<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'Yura',
            'email' => 'ypeskov@pisem.net',
            'password' => Hash::make('Qwerty123'),
        ]);

        factory(User::class, 3)->create(['password' => Hash::make('Qwerty123'), ]);
    }
}
