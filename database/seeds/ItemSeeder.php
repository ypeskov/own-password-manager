<?php

use App\Models\ItemType;
use App\User;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrFail();
        $passwordType = ItemType::where('name', 'password')->firstOrFail();
        $noteType = ItemType::where('name', 'note')->firstOrFail();

        factory(App\Models\Item::class, 10)->create([
            'user_id' => $user->id,
            'item_type_id' => $passwordType->id,
        ]);

        factory(App\Models\Item::class, 4)->create([
            'user_id' => $user->id,
            'item_type_id' => $noteType->id,
        ]);
    }
}
