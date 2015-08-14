<?php

Route::group(['prefix' => 'newsletter'], function() {
    Route::get('/', 'NewsletterController@index');
    //Route::post('/add/{newsletter}', 'NewsletterController@store');
    //Route::put('/update/{newsletter}', 'NewsletterController@update');
    Route::get('/find/{id}', 'NewsletterController@show');
    Route::get('/delete/{id}', 'NewsletterController@destroy');
});

Route::group(['prefix' => 'list'], function() {
    Route::get('/', 'MailinglistController@index');
    //Route::post('/add/{newsletter}', 'MailinglistController@store');
    //Route::put('/update/{newsletter}', 'MailinglistController@update');
    Route::get('/find/{id}', 'MailinglistController@show');
    Route::get('/delete/{id}', 'MailinglistController@destroy');
});

Route::group(['prefix' => 'subscriber'], function() {
    Route::get('/{list_id}', 'SubscriberController@index');
    Route::post('/add', 'SubscriberController@store');
    //Route::put('/update', 'SubscriberController@update');
    Route::get('/find/{list_id}/{email}', 'SubscriberController@show');
    Route::get('/delete/{list_id}/{email}', 'SubscriberController@destroy');

    Route::get('/{list_id}/{email}/edit', 'SubscriberController@edit');
    Route::get('/{list_id}/create', 'SubscriberController@create');
});