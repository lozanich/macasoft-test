<?php

use Faker\Generator as Faker;

$factory->define(\App\Models\Roles::class, function (Faker $faker) {
    return [
        'id_rol' => $faker->numberBetween(1, 10),
        'rol'    => $faker->randomElement(['usuario', 'administrador', 'vendedor'])
    ];
});
