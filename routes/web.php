<?php

use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('/logout_manual' ,  function (){
    request()->session()->invalidate();
});

Route::get('/{any}', 'AppController@index')->where('any' , '.*');
