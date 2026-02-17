<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminBlogController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AuthController;
// Route::get('/', function () {
//     return view('index');
// });
Route::view('/','index');
//お問い合わせフォーム
Route::get('/contact',[ContactController::class,'index'])->name('contact');
Route::post('/contact',[ContactController::class,'sendMail']);
Route::get('/contact/complete',[ContactController::class,'complete'])->name('contact.complete');

//管理画面のルートグループ
// Route::prefix('/admin')//共通のパス
//     ->name('admin.')//共通のルート名
//     ->middleware('auth')//共通のミドルウェア
//     ->group(function(){
// //ブログ
//         // Route::get('/blogs',[AdminBlogController::class,'index'])->name('blogs.index');
//         // Route::get('/blogs/create',[AdminBlogController::class,'create'])->name('blogs.create');
//         // Route::post('/blogs',[AdminBlogController::class,'store'])->name('blogs.store')->middleware('auth');
//         // Route::get('/blogs/{blog}',[AdminBlogController::class,'edit'])->name('blogs.edit')->middleware('auth');
//         // Route::put('/blogs/{blog}',[AdminBlogController::class,'update'])->name('blogs.update')->middleware('auth');
//         // Route::delete('/blogs/{blog}',[AdminBlogController::class,'destroy'])->name('blogs.destroy');
//         //resource一括登録
//         Route::resource('/blogs',AdminBlogController::class)->except('show');
        
        
//         //ユーザー登録
//         Route::get('/users/create',[UserController::class,'create'])->name('users.create');
//         Route::post('/users/store',[UserController::class,'store'])->name('users.store');

//         //ログアウト       
//         Route::post('/logout',[AuthController::class,'logout'])->name('logout');


//     });
//         Route::post('/admin/login',[AuthController::class,'login'])->middleware('guest');
//         Route::get('/admin/login',[AuthController::class,'showLoginForm'])->name('admin.login')->middleware('guest');

//記法2

//管理画面のルートグループ
Route::prefix('/admin')//共通のパス
    ->name('admin.')//共通のルート名
    
    ->group(function(){
        //ログイン時のみアクセス可能なルート
        Route::middleware('auth')
            ->group(function(){

        //ブログ
        Route::resource('/blogs',AdminBlogController::class)->except('show');
                
        //ユーザー登録
        Route::get('/users/create',[UserController::class,'create'])->name('users.create');
        Route::post('/users/store',[UserController::class,'store'])->name('users.store');

        //ログアウト       
        Route::post('/logout',[AuthController::class,'logout'])->name('logout');

        });
        //未ログイン時のみアクセス可能なルート
        Route::middleware('guest')
            ->group(function(){
        Route::post('/login',[AuthController::class,'login']);
        Route::get('/login',[AuthController::class,'showLoginForm'])->name('login');
        });
    });
