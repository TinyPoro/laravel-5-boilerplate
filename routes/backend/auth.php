<?php

/**
 * All route names are prefixed with 'admin.auth'.
 */
Route::group([
    'prefix'     => 'auth',
    'as'         => 'auth.',
    'namespace'  => 'Auth',
], function () {
    Route::group([
        'middleware' => 'backend',
    ], function () {
        /*
         * User Management
         */
        Route::group(['namespace' => 'User', 'middleware' => 'admin'], function () {

            /*
             * User Status'
             */
            Route::get('user/deactivated', 'UserStatusController@getDeactivated')->name('user.deactivated');
            Route::get('user/deleted', 'UserStatusController@getDeleted')->name('user.deleted');

            /*
             * User CRUD
             */
            Route::resource('user', 'UserController');

            /*
             * Specific User
             */
            Route::group(['prefix' => 'user/{user}'], function () {
                // Account
                Route::get('account/confirm/resend', 'UserConfirmationController@sendConfirmationEmail')->name('user.account.confirm.resend');

                // Status
                Route::get('mark/{status}', 'UserStatusController@mark')->name('user.mark')->where(['status' => '[0,1]']);

                // Social
                Route::delete('social/{social}/unlink', 'UserSocialController@unlink')->name('user.social.unlink');

                // Confirmation
                Route::get('confirm', 'UserConfirmationController@confirm')->name('user.confirm');
                Route::get('unconfirm', 'UserConfirmationController@unconfirm')->name('user.unconfirm');

                // Password
                Route::get('password/change', 'UserPasswordController@edit')->name('user.change-password');
                Route::patch('password/change', 'UserPasswordController@update')->name('user.change-password.post');

                // Access
                Route::get('login-as', 'UserAccessController@loginAs')->name('user.login-as');

                // Session
                Route::get('clear-session', 'UserSessionController@clearSession')->name('user.clear-session');
            });

            /*
             * Deleted User
             */
            Route::group(['prefix' => 'user/{deletedUser}'], function () {
                Route::get('delete', 'UserStatusController@delete')->name('user.delete-permanently');
                Route::get('restore', 'UserStatusController@restore')->name('user.restore');
            });
        });

        /*
         * Role Management
         */
        Route::group(['namespace' => 'Role', 'middleware' => 'admin'], function () {
            Route::resource('role', 'RoleController', ['except' => ['show']]);
        });

        /*
         * News Management
         */
        Route::group(['namespace' => 'News', 'middleware' => 'author'], function () {
            Route::get('news/deleted', 'NewsController@getDeleted')->name('news.delete');
            Route::resource('news', 'NewsController');

            /*
             * Deleted News
             */
            Route::group(['prefix' => 'news/{deletedNews}'], function () {
                Route::get('restore', 'NewsController@restore')->name('news.restore');
                Route::get('publish', 'NewsController@publish')->name('news.publish');
                Route::get('delete', 'NewsController@delete')->name('news.delete-permanently');
            });
        });

        /*
         * Category Management
         */
        Route::group(['namespace' => 'Category', 'middleware' => 'admod'], function () {
            Route::get('category/deleted', 'CategoryController@getDeleted')->name('category.delete');
            Route::resource('category', 'CategoryController');

            /*
             * Deleted Category
             */
            Route::group(['prefix' => 'category/{deletedCategory}'], function () {
                Route::get('restore', 'CategoryController@restore')->name('category.restore');
                Route::get('delete', 'CategoryController@delete')->name('category.delete-permanently');
            });
        });
    });
});
