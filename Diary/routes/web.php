<?php
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

// Route::get('/', function () {
//     return view('welcome');
// });
//get('URLリクエスト','対象コントローラー@対象メソッド')
Route::get('/', 'DiaryController@index')->name('diary.index'); //追加

	Route::group(['middleware' => 'auth'] ,function(){
    Route::get('diary/create', 'DiaryController@create')->name('diary.create'); //投稿画面

    Route::post('diary/create','DiaryController@store')->name('diary.create');//保存処理
    
    Route::get('diary/{id}/edit', 'DiaryController@edit')->name('diary.edit'); // 編集画面
    
    Route::put('diary/{id}/update', 'DiaryController@update')->name('diary.update'); //更新処理
    
    Route::delete('diary/{id}/delete',"DiaryController@destroy")->name('diary.destroy');//削除処理
    //()は引数

    Route::get('/mypage', 'DiaryController@mypage')->name('diary.mypage'); //mypage


    Route::post('diary/{id}/like', 'DiaryController@like')->name('diary.like');
    Route::post('diary/{id}/dislike', 'DiaryController@dislike')->name('diary.dislike');
});



//authはログイン。Groupでログインしないと見れないようにしている

// //削除
// Route::get('/', function () {
//     return view('welcome');
// });
// オブジェクト指向のクラスメソッド
// クラス名::メソッド
// オブジェクト->メソッド

// class Car {
//     function start() {
  
//     }
//   }
  
//   $car = new Car();
//   $car->start();
  
//   Car::start();

// restful設計
// GET 取得
// POST 作成
// Put 更新
// DELETE 削除


Auth::routes();




