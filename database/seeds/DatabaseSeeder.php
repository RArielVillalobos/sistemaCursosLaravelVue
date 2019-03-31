<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //eliminara el directorio storage/app/public
        Storage::deleteDirectory('courses');
        Storage::deleteDirectory('users');

        Storage::makeDirectory('courses');
        Storage::makeDirectory('users');

        factory(\App\Role::class,1)->create(['name'=>'admin']);
        factory(\App\Role::class,1)->create(['name'=>'teacher']);
        factory(\App\Role::class,1)->create(['name'=>'student']);

        //crearemos un user admin y a la vez el mismo sera un estudiante
        factory(\App\User::class,1)->create([
            'name'=>'admin',
            'email'=>'admin@gmail.com',
            'password'=>bcrypt('ar1el123'),
            'role_id'=>\App\Role::ADMIN,

        ])->each(function(\App\User $u){
            factory(\App\Student::class,1)->create([
                'user_id'=>$u->id
            ]);
        });

        //creamos otros 50 usuarios y  a cada uno lo hacemos estudiante
        factory(\App\User::class,50)->create()->each(function(\App\User $u){
            factory(\App\Student::class,1)->create(['user_id'=>$u->id]);
        });

        //10 usuarios y a su vez a cada uno le hacemos una relacion con estudiante y profesor
        factory(\App\User::class,10)->create()->each(function(\App\User $u){
            factory(\App\Student::class,1)->create(['user_id'=>$u->id]);
            factory(\App\Teacher::class,1)->create(['user_id'=>$u->id]);
        });

        factory(\App\Level::class,1)->create(['name'=>'Beginner']);
        factory(\App\Level::class,1)->create(['name'=>'Intermidiate']);
        factory(\App\Level::class,1)->create(['name'=>'Advanced']);
        //va a escojer 5 categoria aleatoria de las que pusimos en factory
        factory(\App\Category::class,5)->create();



    }
}
