<?php

Route::get('/home', 'Admin\HomeController@index')->name('home');

/**
 * ROLES
 */
 Route::get('/role/{role}/permissions','Admin\RoleController@permissions');
 Route::get('/rolePermissions','Admin\RoleController@rolePermissions')->name('myrolepermission');
 Route::get('/roles/all','Admin\RoleController@all');
 Route::post('/assignPermission','Admin\RoleController@attachPermission');
 Route::post('/detachPermission','Admin\RoleController@detachPermission');
 Route::resource('/roles','Admin\RoleController');

 /**
  * PERMISSIONs
  */
 Route::get('/permissions/all','Admin\PermissionController@all');
 Route::resource('/permissions','Admin\PermissionController');


 /**
 * ADMINs
 */
Route::get('/profile','Admin\AdminController@profileEdit');
Route::put('/profile/{admin}','Admin\AdminController@profileUpdate');
Route::put('/changepassword/{admin}','Admin\AdminController@changePassword');
Route::put('/administrator/status','Admin\AdminController@switchStatus');
Route::post('/administrator/removeBulk','Admin\AdminController@destroyBulk');
Route::put('/administrator/statusBulk','Admin\AdminController@switchStatusBulk');
Route::resource('/administrator','Admin\AdminController');

/**
 * USERS
 */
Route::put('/user/status','Admin\UserController@switchStatus');
Route::post('/user/removeBulk','Admin\UserController@destroyBulk');
Route::put('/user/statusBulk','Admin\UserController@switchStatusBulk');
Route::get('/user/{id}/cellar','Admin\UserController@showUserCellar');
Route::resource('/user','Admin\UserController');


Route::get('/logout', 'Admin\HomeController@logout');
Route::get('/ProfileView', 'Admin\HomeController@ProfileView');
Route::get('/EditProfileView', 'Admin\HomeController@EditProfileView');
Route::post('/EditProfilePost', 'Admin\HomeController@EditProfilePost');
Route::get('/CommissionSettingView', 'Admin\HomeController@CommissionSettingView');
Route::post('/SetCommission', 'Admin\HomeController@SetCommission');

Route::get('/UserListView', 'Admin\Main\UserController@UserListView');
Route::get('/BlockUser/{id}', 'Admin\Main\UserController@BlockUser');
Route::get('/SpamListView', 'Admin\Main\UserController@SpamListView');
Route::get('/ActiveUser/{id}', 'Admin\Main\UserController@ActiveUser');
Route::get('/UserCrashGames/{id}', 'Admin\Main\UserController@UserCrashGames');
Route::post('/SetReferralRate', 'Admin\Main\UserController@SetReferralRate');
Route::post('/EditUserBalance', 'Admin\Main\UserController@EditUserBalance');
Route::get('/LoginUser/{id}', 'Admin\Main\UserController@LoginUser');

Route::get('/ReferralUserListView/{id}','Admin\Main\UserController@ReferralUserListView');

Route::get('/GameListView', 'Admin\Main\GameController@GameListView');
Route::get('/GameBettingsList/{id}', 'Admin\Main\GameController@GameBettingsList');

Route::get('/DepositHistory', 'Admin\Main\TransactionController@DepositHistory');
Route::get('/PendingWithdrawHistory', 'Admin\Main\TransactionController@PendingWithdrawHistory');
Route::get('/PaidWithdrawHistory', 'Admin\Main\TransactionController@PaidWithdrawHistory');
Route::post('/PayWithdrawPost', 'Admin\Main\TransactionController@PayWithdrawPost');
Route::post('/delete_withdraw_request', 'Admin\Main\TransactionController@delete_withdraw_request');