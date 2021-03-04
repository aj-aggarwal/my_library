<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Book;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

$factory->define(Book::class, function (Faker $faker) {
	
	$isbns = ['0005534186', '0978110196', '0978108248', '0978194527', '0978194004', '0978194985', '0978171349', '0978039912', '0978031644', '0978168968', '0978179633', '0978006232', '0978195248', '0978125029', '0978078691', '0978152476', '0978153871', '0978125010', '0593139135', '0441013597'];

    return [
        'title' => "The ".ucfirst($faker->word),
        'isbn'	=> $isbns[array_rand($isbns, 1)],
        'published_at' => $faker->dateTimeThisCentury->format('Y-m-d'),
        'status' => 'AVAILABLE',
    ];
});
