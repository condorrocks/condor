<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    return [
        'name'           => $faker->name,
        'email'          => $faker->safeEmail,
        'password'       => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Role::class, function (Faker\Generator $faker) {
    $name = $faker->word;

    return [
        'name'        => $faker->word,
        'slug'        => str_slug($name),
        'description' => $faker->sentence,
    ];
});

$factory->define(App\Permission::class, function (Faker\Generator $faker) {
    $name = $faker->word;

    return [
        'name'        => $name,
        'slug'        => str_slug($name),
        'description' => $faker->sentence,
    ];
});

$factory->define(App\Account::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Aspect::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
    ];
});

$factory->define(App\Feed::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
        'apikey'    => md5($faker->name),
        'params'    => json_encode(['param1' => 'value1', 'param2' => 'value2']),
        'aspect_id' => factory(App\Aspect::class)->create()->id,
    ];
});

$factory->define(App\Board::class, function (Faker\Generator $faker) {
    return [
        'name'      => $faker->name,
    ];
});

$factory->define(App\Snapshot::class, function (Faker\Generator $faker) {
    return [
        'target'      => $faker->name,
        'board_id'    => factory(App\Board::class)->create()->id,
        'aspect_id'   => factory(App\Aspect::class)->create()->id,
        'feed_id'     => factory(App\Feed::class)->create()->id,
        'hash'        => $faker->name,
        'timestamp'   => Carbon\Carbon::parse(date('Y-m-d 08:00:00', strtotime('today +2 days'))),
        'data'        => json_encode(['indicator1' => 'value1', 'indicator2' => 'value2']),
    ];
});
