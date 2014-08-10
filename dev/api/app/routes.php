<?php

// documentation
Route::get('', array('as' => 'home', 'uses' => function() {
    return View::make('docs.index');
}));

Route::group(array('prefix' => 'v1'), function() {

    Route::resource('users', 'api\User\UserController');
    Route::resource('users.notes', 'api\Note\NoteController');

});