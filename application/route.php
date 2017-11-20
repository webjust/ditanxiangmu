<?php
use think\Route;

Route::get('/', 'Index/Index/index');
Route::get('logout', 'Index/Index/logout');
Route::get('about', 'Index/Index/about');
Route::get('ad', 'Index/Index/ad');
Route::get('hr', 'Index/Index/hr');
Route::get('error', 'Index/Error/index');
Route::get('goods/:id', 'Index/Index/detail');
Route::get('all', 'Index/Index/all');
Route::get('ads', 'Index/Ads/ad');
