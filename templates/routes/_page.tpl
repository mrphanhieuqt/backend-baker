
    // Routes for {{page}}
    Route::match(['get', 'post'], '/{{page}}', 'UsersController@index')->name('{{page}}');
    Route::match(['get', 'post'], '/{{page}}/add', 'UsersController@new')->name('{{page}}Add');
    Route::match(['get', 'post'], '/{{page}}/edit/{id}', 'UsersController@edit')->name('{{page}}Edit');