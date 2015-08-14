<?php

Route::group(['prefix' => 'newsletter'], function() {
    Route::get('/', 'NewsletterController@index');
    Route::get('/find/{id}', 'NewsletterController@show');
    Route::delete('/delete/{id}', 'NewsletterController@destroy');
});

Route::group(['prefix' => 'list'], function() {
    Route::get('/', 'MailinglistController@index');
    Route::get('/find/{id}', 'MailinglistController@show');
    Route::delete('/delete/{id}', 'MailinglistController@destroy');
});

Route::group(['prefix' => 'subscriber'], function() {
    Route::post('/add', 'SubscriberController@store');
    Route::get('/{list_id}', 'SubscriberController@index');
    Route::get('/{list_id}/find/{email}', 'SubscriberController@show');
    Route::delete('/{list_id}/delete/{email}', 'SubscriberController@destroy');
});