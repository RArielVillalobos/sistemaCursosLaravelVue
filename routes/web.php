<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/set_language/{language}','Controller@setLanguage')->name('set_language');
Route::get('login/{driver}','Auth\LoginController@redirecToProvider')->name('social_auth');
//a donde llegaria el usuario
Route::get('login/{driver}/callback','Auth\LoginController@handleProviderCallback');
Route::get('/', function () {
    return view('welcome');
});


Auth::routes();
//en el array podemos pasar el prefijo, middlewares,etc
//todas las rutas que esten aca vana  empezar con el prefijo courses
Route::group(['prefix'=>'courses'],function(){
    //para acceder directamente al curso ponemos course
    Route::get('/{course}','CourseController@show')->name('courses.detail');


});

Route::get('/', 'HomeController@index')->name('home');

/*Route::get('/images/{path}/{attachment}',function ($path,$attachment){
        //retornar a ruta de storage/cursos/attachment
        $file=sprintf('storage/%s/%s',$path,$attachment);
        if(File::exists($file)){
            return Image::make($file)->response();
        }
});*/
