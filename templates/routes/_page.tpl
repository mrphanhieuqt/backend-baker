
    // Routes for {{page}}
    Route::match(['get', 'post'], '/{{page}}', '{{Page}}Controller@index')->name('{{page}}');
    Route::match(['get', 'post'], '/{{page}}/add', '{{Page}}Controller@add')->name('{{page}}Add');
    Route::match(['get', 'post'], '/{{page}}/edit/{id}', '{{Page}}Controller@edit')->name('{{page}}Edit');
    Route::match(['get', 'post'], '/{{page}}/delete/{id}', '{{Page}}Controller@delete')->name('{{page}}Delete');