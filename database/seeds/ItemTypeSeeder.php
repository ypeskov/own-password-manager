<?php

use App\Models\ItemType;
use Illuminate\Database\Seeder;

class ItemTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ItemType::create(['name' => 'password', 'is_enabled' => true,]);
        ItemType::create(['name' => 'note', 'is_enabled' => true,]);
        ItemType::create(['name' => 'credit card', 'is_enabled' => false,]);
        ItemType::create(['name' => 'bank account', 'is_enabled' => false,]);
        ItemType::create(['name' => 'database', 'is_enabled' => false,]);
        ItemType::create(['name' => 'server', 'is_enabled' => false,]);
    }
}
