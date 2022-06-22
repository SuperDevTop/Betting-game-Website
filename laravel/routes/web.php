<?php

use App\Events\StartCrashGame;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view("welcome");
});


Route::get('/pusher', function() {
    event( new StartCrashGame("testing crash"));
    return "Event has been sent!";
});

Route::group(['prefix' => 'admin'], function () {
  Route::get('/', 'AdminAuth\LoginController@showLoginForm')->name('login');
  Route::post('/login', 'AdminAuth\LoginController@login');
  Route::post('/logout', 'AdminAuth\LoginController@logout')->name('logout');

  Route::get('/register', 'AdminAuth\RegisterController@showRegistrationForm')->name('register');
  Route::post('/register', 'AdminAuth\RegisterController@register');

  Route::post('/password/email', 'AdminAuth\ForgotPasswordController@sendResetLinkEmail')->name('password.request');
  Route::post('/password/reset', 'AdminAuth\ResetPasswordController@reset')->name('password.email');
  Route::get('/password/reset', 'AdminAuth\ForgotPasswordController@showLinkRequestForm')->name('password.reset');
  Route::get('/password/reset/{token}', 'AdminAuth\ResetPasswordController@showResetForm');
});

Auth::routes();

/////
Route::get('/TemporaryFunction', 'LandingController@TemporaryFunction');
Route::get('/affilliated/{id}', 'LandingController@affiliate');
/////


Route::get('/affiliate/{id}', 'LandingController@affiliate');
Route::get('/crashgameevent/{id}', 'LandingController@crashgameevent');


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/logout', 'HomeController@logout');
Route::get('/profile', 'HomeController@profile');
Route::post('/profile_edit', 'HomeController@profile_edit');
Route::get('/blocked_page', 'HomeController@blocked_page');
Route::get('/threadrunning/{id}', 'LandingController@threadrunning');
Route::get('/getusers/', 'LandingController@getusers');
Route::get('/delusers/', 'LandingController@delusers');

Route::group(['middleware' => ['checkStatus']], function () {

    
    Route::get('/login_ip_history', 'HomeController@login_ip_history');

    Route::get('/crash_game_play', 'CrashGame\GameController@crash_game_play');
    Route::get('/get_crash_game_status', 'CrashGame\GameController@get_crash_game_status');
    Route::post('/place_crash_game', 'CrashGame\GameController@place_crash_game');
    Route::post('/bet_crash_game', 'CrashGame\GameController@bet_crash_game');

    Route::get('/crash_game_history', 'CrashGame\HistoryController@crash_game_history');

    Route::get('/deposit', 'TransactionController@deposit');
    Route::post('/deposit_post', 'TransactionController@deposit_post');
    Route::get('/deposit_status', 'TransactionController@deposit_status');
    Route::post('/deposit_status_post', 'TransactionController@deposit_status_post');
    Route::get('/deposit_success_view', 'TransactionController@deposit_success_view');
    Route::get('/deposit_error_view', 'TransactionController@deposit_error_view');
    Route::get('/transaction_history', 'TransactionController@transaction_history');
    Route::get('/withdraw', 'TransactionController@withdraw');
    Route::post('/withdraw_request_post', 'TransactionController@withdraw_request_post');
    Route::get('/cancel_withdraw/{id}', 'TransactionController@cancel_withdraw');
    Route::get('/withdraw_pending_history', 'TransactionController@withdraw_pending_history');
    Route::get('/withdraw_success_history', 'TransactionController@withdraw_success_history');


    Route::get('/affiliate_link', 'AffiliateController@affiliate_link');
    Route::get('/affiliate_user_list_view', 'AffiliateController@affiliate_user_list_view');
    Route::get('/affiliate_earning', 'AffiliateController@affiliate_earning');
    
    Route::post('/send_message', 'ChatController@send_message');
    Route::post('/get_message', 'ChatController@get_message');
});