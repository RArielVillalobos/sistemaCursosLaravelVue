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

        //para pasar un parametro al middleware role, debemos usar la funcion sprintf, y luego el parametro
        //role es el nombre de middleware
       Route::group(['middleware'=>[sprintf('role:%s',\App\Role::TEACHER)]],function (){
           Route::get('create','CourseController@create')->name('courses.create');



           Route::post('store','CourseController@store')->name('courses.store');



           Route::put('/{slug}/update','CourseController@update')->name('courses.update');



           Route::get('{slug}/edit','CourseController@edit')->name('courses.edit');

           Route::put('{course}/update','CourseController@update')->name('courses.update');
           Route::delete('{course}/destroy','CourseController@destroy')->name('courses.destroy');

       });
    });

    //para acceder directamente al curso ponemos course
    Route::get('{course}','CourseController@show')->name('courses.detail');



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



    Route::group(['prefix'=>'solicitude'],function (){
        Route::post('/teacher','SolicitudeController@teacher')->name('solicitude.teacher');
    });


    Route::group(['prefix'=>'teacher'],function (){
        Route::get('/courses','TeacherController@courses')->name('teacher.courses');
        Route::get('students','TeacherController@students')->name('teacher.students');
        Route::post('/send_message_to_student','TeacherController@sendMessageStudent')->name('teacher.send_message_to_student');
    });
});

Route::group(['prefix'=>'admin','middleware'=>['auth'=>sprintf('role:%s',\App\Role::ADMIN)]],function(){
    Route::get('/courses','AdminController@courses')->name('admin.courses');
    Route::get('/courses_json','AdminController@coursesJson')->name('admin.courses_json');
    Route::post('/courses/updateStatus','AdminController@updateCourseStatus');


    //parte para hacer
    Route::get('students','AdminController@students')->name('admin.students');
    Route::get('students_json','AdminController@studentsJson')->name('admin.students_json');
    Route::get('teachers','AdminController@teachers')->name('admin.teachers');
    Route::get('teachers_json','AdminControllerT@teachersJson')->name('admin.tachers_json');

});

Route::get('/', 'HomeController@index')->name('home');

/*Route::get('/images/{path}/{attachment}',function ($path,$attachment){
        //retornar a ruta de storage/cursos/attachment
        $file=sprintf('storage/%s/%s',$path,$attachment);
        if(File::exists($file)){
            return Image::make($file)->response();
        }
});*/

