<?php

use Faker\Generator as Faker;

$factory->define(App\Course::class, function (Faker $faker) {
    $name=$faker->sentence;
    $status=$faker->randomElement([\App\Course::PUBLISHED,\App\Course::PENDING,\App\Course::REJECTED]);
    return [

        //accedemos a todo los datos del modelo, luego escojemos uno aleatorio y obtenemos el id
        'teacher_id'=>\App\Teacher::all()->random()->id,
        'category_id'=>\App\Category::all()->random()->id,
        'level_id'=>\App\Level::all()->random()->id,
        'name'=>$name,
        'slug'=>str_slug($name,'-'),
        'description'=>$faker->paragraph,
        //ponemos el fullpath en false para que solo guarde el nombre
        'picture'=>\Faker\Provider\Image::image(storage_path().'/app/public/courses',600,350,'business',false),
        'status'=>$status,
        //si estatus es distinto de publicado, si todavia no ha sido aprobado, sera falso
        'previus_approved'=>$status !== \App\Course::PUBLISHED ? false : true,
        'previus_rejected'=>$status === \App\Course::REJECTED ? true : false,
    ];
});
