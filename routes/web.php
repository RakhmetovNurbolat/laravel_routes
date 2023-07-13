<?php

use App\Http\Controllers\GreetingsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

Route::get('/', function () {
    echo 'ITShcool';
});

//1
Route::get('/world', function(){
    echo "Привет, мир!";
})->name('world');

//2
Route::get('/greeting' , [
    GreetingsController::class, 
    'index'
]);

//3
Route::view('/about', 'about');

//4
Route::post('/form-submit', function(){
    echo "Данные успешно отправлены!";
});

//5
Route::get('/form-submit', function(){
    echo '<form method = "POST" action="/form-submit">
        <input type="hidden" name="_token" value="'.csrf_token().'">
        <button type="submit">Отправить</button>
    </form>';
});


//6
Route::match(['get' , 'post'] , '/match' , function(){
    return"Привет, это метод GET или POST!";
});

//7
Route::any('/any' , function(){
    echo "Привет, это любой метод!";
});

//8
Route::post('/number' , function(Request $request){
    echo 'Вы ввели число: ' . $request->number;
});

//9
Route::view('/number' , 'number');

//10
Route::get('/introduce', function(){
    echo '<form action = "/hello" method = "POST">
        Name :<input type="text" name = "text">
        <input type="hidden" name = "_token" value = "'.csrf_token().'"> 
        <button type="submit"> SEND </button>
    </form>';
});
Route::post('/hello', function(Request $request){
    echo 'hello '. $request->text;
});

//11
Route::redirect('/redirect', 'world');

//12
Route::get('/user/{id}' , function($id , Request $request){
    echo 'Вы выбрали пользователя с ID: '.$id;
})->name('user');

//13

Route::get('/optional/{param?}' , function($param = null){
    echo $param == null ? "Параметр не передан" : "Вы передали параметр: ".$param;
});

//14
Route::get('/sum/{number1}/{number2}', function($number1 , $number2){
    echo $number1 + $number2;
})->where(['number1' => '[0-9]+' , 'number2' => '[0-9]+']);

//15
Route::get('/articles/{article?}', function($article = null){
    return $article == null ? redirect('world') : 'Вы передали параметр: '.$article;
});

//16
Route::get('/link', function(){
    return "<a href = ".route('user' , ['id' => 10])."> Пользователь с ID 10" ;
});

//17
/*
Route::middleware(['dashboard' , 'users']) -> group(function(){
    Route::get('/dashboard', function(){
        echo 'Панель управления';
    });
    Route::get('/users', function(){
        echo 'Список пользователей';
    });        
});
*/

Route::group(['namespace' => 'App\Http\Controllers'], function(){
    Route::get('/dashboard', function(){
        echo 'Панель управления';
    }) -> name('dashboard');
    Route::get('/users', function(){
        echo 'Список пользователей';
    }) -> name('users');  
});

//18
Route::prefix('/admin')->name('admin.')->group(function(){
    Route::get('/dashboard', function(){ echo 'admin.dashboard';}) -> name('dashboard');
    Route::get('/users', function(){ echo 'admin.users'; }) -> name('users'); 
});

//19
Route::fallback(function(){
    return "Ошибка 404: Страница не найдена";
});

//20
// php artisan route:list
/*
GET|HEAD   / ....................................................................................
POST       _ignition/execute-solution ignition.executeSolution › Spatie\LaravelIgnition › Execut…
GET|HEAD   _ignition/health-check ignition.healthCheck › Spatie\LaravelIgnition › HealthCheckCon…
POST       _ignition/update-config ignition.updateConfig › Spatie\LaravelIgnition › UpdateConfig…
GET|HEAD   about ................................................................................
GET|HEAD   admin/dashboard ...................................................... admin.dashboard
GET|HEAD   admin/users .............................................................. admin.users
ANY        any ..................................................................................
GET|HEAD   api/user .............................................................................
GET|HEAD   articles/{article?} ..................................................................
GET|HEAD   dashboard .................................................................. dashboard
POST       form-submit ..........................................................................
GET|HEAD   form-submit ..........................................................................
GET|HEAD   greeting ................................................... GreetingsController@index
POST       hello ................................................................................
GET|HEAD   introduce ............................................................................
GET|HEAD   link .................................................................................
GET|POST|HEAD match .............................................................................
POST       number ...............................................................................
GET|HEAD   number ...............................................................................
GET|HEAD   optional/{param?} ....................................................................
ANY        redirect ..................................... Illuminate\Routing › RedirectController
GET|HEAD   sanctum/csrf-cookie sanctum.csrf-cookie › Laravel\Sanctum › CsrfCookieController@show
GET|HEAD   sum/{number1}/{number2} ..............................................................
GET|HEAD   user/{id} ....................................................................... user
GET|HEAD   users .......................................................................... users
GET|HEAD   world .......................................................................... world
GET|HEAD   {fallbackPlaceholder} ................................................................

                                                                              Showing [28] routes
                                                                              
*/