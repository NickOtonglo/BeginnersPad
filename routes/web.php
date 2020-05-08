<?php

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

// Route::post('/login', [
// 	'uses' => 'Auth\AuthController@login',
// 	'middleware' => 'checkUserStatus',
// ]);

use App\Http\Controllers\AdminController;

Route::get('/about', function () {
    return view('about');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listings','Controller@index')->name('listings.list');

Route::get('/listings/{listings}/view','Controller@view')->name('listing.view');

// Route::get('/listings/{listings}/review/{review}','ListingsController@review')->name('listing.review');

Route::get('/listings/{listings}/reviews','Controller@viewReviews')->name('listing.viewReviews');
Route::get('/help','Controller@help')->name('help');
Route::post('/help','Controller@createTicket')->name('createTicket');

Route::group(['middleware'=>'auth'],function(){
	//Common Routes
	Route::get('/account','Controller@manageAccount')->name('manageAccount');
	Route::post('/account','Controller@updateDetails')->name('updateAccountDetails');
	Route::get('/logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('/help/my-tickets','Controller@viewTicketHistory')->name('viewTicketHistory');
	Route::get('/help/my-tickets/{ticket}','Controller@viewTicket')->name('viewTicket');
	Route::get('/help/my-tickets/category/{category}','Controller@viewTicketCategory')->name('viewTicketCategory');

	//Lister Routes
	Route::get('/manage-listings','ListerController@manageListings')->name('lister.manageListings');
	Route::get('/manage-listings/new','ListerController@createListing')->name('lister.createListing');
	Route::post('/manage-listings/new','ListerController@storeListing')->name('lister.storeListing');
	Route::get('/manage-listings/{listings}/manage','ListerController@manageListing')->name('lister.manageListing');
	Route::put('/manage-listings/{listings}/manage','ListerController@updateListing')->name('lister.updateListing');
	Route::delete('/manage-listings/{listings}/manage','ListerController@removeListing')->name('lister.removeListing');
	Route::get('/manage-listings/{listings}/manage/add','ListerController@addListingEntry')->name('lister.addListingEntry');
	Route::post('/manage-listings/{listings}/manage/add','ListerController@createListingEntry')->name('lister.createListingEntry');
	Route::get('/manage-listings/{listings}/manage/{entry}','ListerController@manageListingEntry')->name('lister.manageListingEntry');
	Route::put('/manage-listings/{listings}/manage/{entry}','ListerController@updateListingEntry')->name('lister.updateListingEntry');
	Route::delete('/manage-listings/{listings}/manage/{entry}/{image}','ListerController@deleteListingEntry')->name('lister.deleteListingEntry');
	Route::get('/manage-listings/{listings}/reviews','ListerController@listingReviews')->name('listing.listingReviews');
	Route::get('/manage-listings/my-applications','ListerController@myApplications')->name('lister.myApplications');
	// Route::get('/manage-listings/{listings}/manage/{image}/remove','ListerController@deleteImage')->name('lister.removeImage');
	Route::get('/manage-listings/{listing}/manage/{image}/remove', [
		'as' => 'deleteImage', 'uses' => 'ListerController@deleteImage'
	]);

	//Customer Routes
	Route::post('/listings/{listings}/view','CustomerController@makeApplication')->name('listing.apply');
	Route::get('/account/manage/my-applications','CustomerController@myApplications')->name('listing.myApplications');
	Route::get('/account/manage/my-favourites','CustomerController@myFavourites')->name('listing.myFavourites');
	Route::get('/account/manage/my-applications/listings/{listings}/review','CustomerController@reviewListing')->name('customer.reviewListing');
	Route::post('/account/manage/my-applications/listings/{listings}/review','CustomerController@saveReview')->name('customer.saveReview');
	Route::get('/account/manage/my-reviews','CustomerController@myReviews')->name('customer.myReviews');
	Route::get('/account/manage/my-reviews/{listings}/edit','CustomerController@editReview')->name('customer.editReview');
	Route::put('/account/manage/my-reviews/{listings}/edit','CustomerController@updateReview')->name('customer.updateReview');
	Route::delete('/account/manage/my-reviews/{listings}/remove','CustomerController@deleteReview')->name('customer.deleteReview');
	// Route::post('/listings/my-favourites','CustomerController@addToFavourites')->name('customer.addToFavourites');
	Route::get('/waiting-list/','CustomerController@loadWaitingList')->name('customer.waitingList');

	//Administrator Routes
	Route::get('/manage-listings/list','AdminController@manageListings')->name('admin.manageListings');
	Route::get('/manage-listings/all','AdminController@manageAllListings')->name('admin.allListings');
	Route::get('/manage-listings/all/{listing}','AdminController@manageListing')->name('admin.manageListing');
	Route::post('/manage-listings/all/{listing}','AdminController@respondToApplication')->name('admin.respondToApplication');
	Route::get('/manage-listings/bookmarks','AdminController@bookmarks')->name('admin.bookmarks');
	Route::delete('/manage-listings/bookmarks/{bookmark}/remove','AdminController@removeBookmark')->name('admin.removeBookmark');
	Route::get('/manage-users/all','AdminController@listUsers')->name('admin.listUsers');
	Route::get('/manage-users/all/{user}/suspend','AdminController@suspendUser')->name('admin.suspendUser');
	Route::get('/manage-users/all/{user}/activate','AdminController@activateUser')->name('admin.activateUser');
	Route::get('/manage-users/all/{user}','AdminController@viewUser')->name('admin.viewUser');
	Route::get('/manage-listings/{listing}/manage-reviews','AdminController@manageReviews')->name('admin.manageReviews');
	// Route::delete('/manage-listings/{listings}/manage-reviews/{review}/remove','AdminController@deleteReview')->name('admin.deleteReview');
	Route::delete('/manage-listings/{listing}/manage-reviews/{review}/remove', [
		'as' => 'deleteReview', 'uses' => 'AdminController@deleteReview'
	]);
	Route::post('/help/tickets/{ticket}/action','AdminController@preformTicketAction')->name('admin.preformTicketAction');
	Route::get('/help/tickets/{ticket}','AdminController@viewTicket')->name('admin.viewTicket');
	Route::get('/help/assigned','AdminController@myTickets')->name('admin.myTickets');
	Route::get('/manage-zones/all','AdminController@listZones')->name('admin.zones');
	Route::get('/manage-zone/new','AdminController@createZone')->name('admin.createZone');
	Route::post('/manage-zone/new','AdminController@saveZone')->name('admin.saveZone');
	Route::get('/manage-zone/{zone}','AdminController@viewZone')->name('admin.viewZone');
	Route::get('/manage-zone/{zone}/edit','AdminController@editZone')->name('admin.editZone');
	Route::put('/manage-zone/{zone}/edit','AdminController@updateZone')->name('admin.updateZone');
	Route::get('/manage-zone/{zone}/add','AdminController@addZoneEntry')->name('admin.addZoneEntry');
	Route::post('/manage-zone/{zone}/add','AdminController@saveZoneEntry')->name('admin.saveZoneEntry');
	Route::get('/manage-zone/{zone}/{entry}/edit','AdminController@editZoneEntry')->name('admin.editZoneEntry');
	Route::put('/manage-zone/{zone}/{entry}/edit','AdminController@updateZoneEntry')->name('admin.updateZoneEntry');
	Route::delete('/manage-zone/{zone}/{entry}/edit','AdminController@deleteZoneEntry')->name('admin.deleteZoneEntry');

	//SuperAdministrator Routes
	Route::get('/manage-users/create','SuperAdminController@createUser')->name('superAdmin.createUser');
	Route::post('/manage-users/create','SuperAdminController@storeUser')->name('superAdmin.storeUser');

	//SystemAdministrator Routes
	Route::delete('/manage-users/all/{user}/kick','SystemAdminController@deleteUser')->name('systemAdmin.deleteUser');

});

Auth::routes();

// //Login Routes
// Route::get('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@showLoginForm']);
// Route::post('login', ['as' => 'auth.login', 'uses' => 'Auth\AuthController@login']);
// Route::get('logout', ['as' => 'auth.logout', 'uses' => 'Auth\AuthController@logout']);

// //Registration Routes
// Route::get('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@showRegistrationForm']);
// Route::post('register', ['as' => 'auth.register', 'uses' => 'Auth\AuthController@register']);

// //Password Reset Routes
// Route::get('password/reset/{token?}', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@showResetForm']);
// Route::post('password/email', ['as' => 'auth.password.email', 'uses' => 'Auth\PasswordController@sendResetLinkEmail']);
// Route::post('password/reset', ['as' => 'auth.password.reset', 'uses' => 'Auth\PasswordController@reset']);

Route::get('/', 'Controller@main')->name('home');

// Route::get('/home', 'ListingsController@index')->name('home');
