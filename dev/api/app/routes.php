<?php

// root points to latest API version
Route::get('', array('uses' => function() {
    return Redirect::to('/v1');
}));

Route::group(array('prefix' => 'v1'), function() {

    // documentation
    Route::get('', array('as' => 'home', 'uses' => function() {
        return View::make('docs.v1.index');
    }));

    Route::resource('users', 'api\User\UserController');
    Route::resource('users.notes', 'api\Note\NoteController');

});