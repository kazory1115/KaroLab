<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\LineBotController;



Route::get('/', function () {
    return view('welcome');
});

Route::prefix('blog')->group(function () {
    Route::get('/posts', [BlogController::class, 'index']);           // 取得所有文章
    Route::post('/posts', [BlogController::class, 'store']);          // 新增文章
    Route::get('/posts/{id}', [BlogController::class, 'show']);       // 取得單篇文章
    Route::put('/posts/{id}', [BlogController::class, 'update']);     // 更新文章
    Route::delete('/posts/{id}', [BlogController::class, 'destroy']); // 刪除文章
    
    // Route::get('ngrokUrl', [LineBotController::class, 'ngrokUrl']);
});


/* 無效路由自動導向 */
// Route::fallback(function () {
//     //不能用route name
//     // return redirect('list');
//     //可以用name
//     return redirect()->route('list');
// });
