<?php

use Faker\Generator as Faker;

$factory->define(App\Student::class, function (Faker $faker) {
    return [
        //
        'name' => $faker->name() ,
        'parent' => $faker->name() ,
        'username' => $faker->userName()                 ,
        'password' => $faker->password() ,
        'gender' => $faker->title() ,
        'email' => $faker->email() ,
        'class_id' => $faker->numberBetween(1, 10) ,
        'section_id' => $faker->randomLetter() ,
        'roll_no' => $faker->numberBetween(1, 100) ,
    ];
});
