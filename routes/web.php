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
    Route::group(['middleware'=>['auth']],function (){
        Route::get('/subscribed','CourseController@subscribed')->name('courses.subscribed');
        Route::get('/{course}/inscribe','CourseController@inscribe')->name('courses.inscribe');
        Route::post('add_review','CourseController@addReview')->name('courses.add_review');

        Route::get('create','CourseController@create')->name('courses.create')
                //para pasar un parametro al middleware role, debemos usar la funcion sprintf, y luego el parametro
               ->middleware([sprintf("role:%s",\App\Role::TEACHER)]);

        Route::post('store','CourseController@store')->name('courses.store')
            //para pasar un parametro al middleware role, debemos usar la funcion sprintf, y luego el parametro
            ->middleware([sprintf("role:%s",\App\Role::TEACHER)]);

        Route::put('update','CourseController@update')->name('courses.update')
            //para pasar un parametro al middleware role, debemos usar la funcion sprintf, y luego el parametro
            ->middleware([sprintf("role:%s",\App\Role::TEACHER)]);





    });

    //para acceder directamente al curso ponemos course
    Route::get('/{course}','CourseController@show')->name('courses.detail');



});

Route::group(['middleware'=>['auth']],function(){
    Route::group(['prefix'=>'subscription'],function (){
        Route::get('plans','SubscriptionController@plans')->name('subscription.plans');
        Route::post('process_subscription','SubscriptionController@processSubscription')->name('subscription.process_subscription');
        Route::get('admin','SubscriptionController@admin')->name('subscription.admin');
        Route::post('resume','SubscriptionController@resume')->name('subscription.resume');
        Route::post('cancel','SubscriptionController@cancel')->name('subscription.cancel');
    });

    Route::group(['prefix'=>'invoices'],function(){
        Route::get('/admin','InvoiceController@admin')->name('invoices.admin');
        Route::get('/{invoice}/download','InvoiceController@download')->name('invoices.download');

    });

    Route::group(['prefix'=>'profile'],function(){
            Route::get('/','ProfileController@index')->name('profile.index');
            Route::put('/','ProfileController@update')->name('profile.update');
    });
});



Route::get('/', 'HomeController@index')->name('home');

/*Route::get('/images/{path}/{attachment}',function ($path,$attachment){
        //retornar a ruta de storage/cursos/attachment
        $file=sprintf('storage/%s/%s',$path,$attachment);
        if(File::exists($file)){
            return Image::make($file)->response();
        }
});*/

Route::group(['prefix'=>'solicitude'],function (){
    Route::post('/teacher','SolicitudeController@teacher')->name('solicitude.teacher');
});


Route::group(['prefix'=>'teacher'],function (){
    Route::get('/courses','TeacherControllerController@courses')->name('teacher.courses');
    Route::get('students','TeacherController@students')->name('teacher.students');
    Route::post('/send_message_to_student','TeacherController@sendMessageStudent')->name('teacher.send_message_to_student');
});