
    // Routes for {{page}}
    Route::match(['get', 'post'], '/{{page}}', 'Admin\{{Page}}Controller@index')->name('{{page}}');
    Route::match(['get', 'post'], '/{{page}}/add', 'Admin\{{Page}}Controller@add')->name('{{page}}Add');
    Route::match(['get', 'post'], '/{{page}}/edit/{id}', 'Admin\{{Page}}Controller@edit')->name('{{page}}Edit');
    Route::match(['get', 'post'], '/{{page}}/delete', 'Admin\{{Page}}Controller@delete')->name('{{page}}Delete');