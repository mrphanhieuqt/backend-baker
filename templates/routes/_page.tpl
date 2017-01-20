
    // Routes for {{page}}
    Route::match(['get', 'post'], '/{{page}}', '{{Page}}Controller@index')->name('{{page}}');
    Route::match(['get', 'post'], '/{{page}}/add', '{{Page}}Controller@new')->name('{{page}}Add');
    Route::match(['get', 'post'], '/{{page}}/edit/{id}', '{{Page}}Controller@edit')->name('{{page}}Edit');