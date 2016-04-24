<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/**
*
*   Route::resource('users', 'UsersController');
*
*   Gives you these named routes:
*
*       Verb    Path                        Action  Route Name
*       GET     /users                      index   users.index
*       GET     /users/create               create  users.create
*       POST    /users                      store   users.store
*       GET     /users/{user}               show    users.show
*       GET     /users/{user}/edit          edit    users.edit
*       PUT     /users/{user}               update  users.update
*       DELETE  /users/{user}               destroy users.destroy
*
*   The generated routes can be checked using 'php artisan route:list' command
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('tickets', 'TicketsController');
Route::resource('projects', 'ProjectsController');
Route::resource('users', 'UsersController');

Route::get('mentions', 'TweetsController@index');

Route::get('admin', function () {
    return view('admin_template');
});

Route::controllers([
    'auth' => '\App\Http\Controllers\Auth\AuthController',
    'password' => '\App\Http\Controllers\Auth\PasswordController',
]);

Route::get('/paypal', 'GenLinkPaypalController@handleTransaction');
Route::get('/genlink', 'GenLinkPaypalController@generateLink');


Route::get('/mail', function() {
    $user = new \App\User();
    $user->email = "asktajweed@gmail.com";
    $ticket = new \App\Ticket();
    $ticket->id = 5;
    \App\MailNotification::mailClaim([$user], $ticket);
    echo 'hello';
});


Route::get('app_settings', 'AppSettingsController@showSettings');

Route::post('change_twitter_consumer_key', 'AppSettingsController@changeTwitterConsumerKey');
Route::post('change_twitter_consumer_key_secret', 'AppSettingsController@changeTwitterConsumerKeySecret');
Route::post('change_twitter_access_token', 'AppSettingsController@changeTwitterAccessToken');
Route::post('change_twitter_access_token_secret', 'AppSettingsController@changeTwitterAccessTokenSecret');

Route::post('change_paypal_client_id', 'AppSettingsController@changePaypalClientID');
Route::post('change_paypal_secret_key', 'AppSettingsController@changePaypalSecretKey');


Route::get('fire', function () {
    // this fires the event
    event(new App\Events\NotificationsEvent());
    return "event fired";
});


Route::resource('notifications', 'NotificationsController',
    ['only' => ['index']]);
