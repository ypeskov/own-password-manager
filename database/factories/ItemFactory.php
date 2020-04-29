<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Item;
use Faker\Generator as Faker;

$factory->define(Item::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(2),
        'url' => $faker->url,
        'folder' => $faker->word,
        'username' => $faker->userName,
        'password' => safe_encrypt('karamba#$%', 'Qwerty123' ^ 'ypeskov@pisem.net'),
        'comments' => $faker->text(20),
    ];
});
