<?php

Route::group(['middleware' => 'web', 'prefix' => \Helper::getSubdirectory(), 'namespace' => 'Modules\UnassignedCount\Http\Controllers'], function()
{
    Route::get('/', 'UnassignedCountController@index');
});
