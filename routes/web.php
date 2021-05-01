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

Route::get('/about', function () {
    return view('about');
});

Route::get('/', function () {
    return view('welcome');
});

Route::get('/listings','Controller@index')->name('listings.list');
Route::get('/listings/{listings}/view','Controller@view')->name('listing.view');
Route::get('/listings/{listings}/reviews','Controller@viewReviews')->name('listing.viewReviews');
Route::get('/help','Controller@help')->name('help');
Route::get('/help/faq','Controller@helpFAQ')->name('helpFAQ');
Route::post('/help','Controller@createTicket')->name('createTicket');

Route::group(['middleware'=>['auth','checkUserStatus']],function(){
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
	Route::post('/manage-listings/{listings}/manage/','ListerController@storeListingThumb')->name('lister.storeListingThumb');
	Route::delete('/manage-listings/{listings}/manage','ListerController@removeListing')->name('lister.removeListing');
	Route::get('/manage-listings/{listings}/manage/add','ListerController@addListingEntry')->name('lister.addListingEntry');
	Route::post('/manage-listings/{listings}/manage/add','ListerController@createListingEntry')->name('lister.createListingEntry');
	Route::get('/manage-listings/{listings}/manage/{entry}','ListerController@manageListingEntry')->name('lister.manageListingEntry');
	Route::put('/manage-listings/{listings}/manage/{entry}','ListerController@updateListingEntry')->name('lister.updateListingEntry');
	Route::post('/manage-listings/{listings}/manage/{entry}','ListerController@storeListingEntryImage')->name('lister.storeListingEntryImage');
	Route::post('/manage-listings/{listings}/manage/{entry}/thumb','ListerController@storeListingEntryThumb')->name('lister.storeListingEntryThumb');
	Route::delete('/manage-listings/{listings}/manage/{entry}/thumb','ListerController@removeListingEntryThumb')->name('lister.removeListingEntryThumb');
	Route::delete('/manage-listings/{listings}/manage/{entry}/{image}','ListerController@deleteListingEntryImage')->name('lister.deleteListingEntryImage');
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
	Route::get('/manage-listings/all','AdminController@manageAllListings')->name('admin.allListings');
	Route::get('/manage-listings/all/{status}','AdminController@manageListings')->name('admin.manageListings');
	Route::get('/manage-listings/all/{category}/{value}','AdminController@filterListings')->name('admin.filterListings');
	Route::get('/manage-listings/{listing}','AdminController@manageListing')->name('admin.manageListing');
	Route::get('/manage-listings/{listings}/{entry}','AdminController@manageListingEntry')->name('admin.manageListingEntry');
	Route::put('/manage-listings/{listing}','AdminController@performListingAction')->name('admin.performListingAction');
	Route::post('/manage-listings/{listing}/bookmark','AdminController@addListingBookmark')->name('admin.addListingBookmark');
	Route::post('/manage-listings/{listing}/{entry}/bookmark','AdminController@addListingEntryBookmark')->name('admin.addListingEntryBookmark');
	Route::get('/manage-listings/logs/{target}','AdminController@viewListingManagementLogs')->name('admin.viewListingManagementLogs');
	// Route::get('/manage-listings/logs/all','AdminController@viewListingManagementLogsAll')->name('admin.viewListingManagementLogsAll');
	Route::get('/listing-bookmarks/','AdminController@manageBookmarks')->name('admin.manageBookmarks');
	Route::delete('/listing-bookmarks/{bookmark}','AdminController@removeBookmark')->name('admin.removeBookmark');
	Route::get('/manage-users/all','AdminController@listUsers')->name('admin.listUsers');
	// Route::get('/manage-users/all/{user}/suspend','AdminController@suspendUser')->name('admin.suspendUser');
	// Route::get('/manage-users/all/{user}/activate','AdminController@activateUser')->name('admin.activateUser');
	Route::get('/manage-users/all/{user}/{action}','AdminController@performUserAction')->name('admin.performUserAction');
	Route::get('/manage-users/all/logs/{target}','AdminController@viewUserManagementLogs')->name('admin.viewUserManagementLogs');
	Route::get('/manage-users/all/{user}','AdminController@viewUser')->name('admin.viewUser');
	Route::get('/manage-listings/{listing}/manage-reviews','AdminController@manageReviews')->name('admin.manageReviews');
	// Route::delete('/manage-listings/{listings}/manage-reviews/{review}/remove','AdminController@deleteReview')->name('admin.deleteReview');
	Route::delete('/manage-listings/{listing}/manage-reviews/{review}/remove', [
		'as' => 'deleteReview', 'uses' => 'AdminController@deleteReview'
	]);
	Route::post('/help/tickets/{ticket}/action','AdminController@performTicketAction')->name('admin.performTicketAction');
	Route::get('/help/tickets/{ticket}','AdminController@viewTicket')->name('admin.viewTicket');
	Route::get('/help/tickets/logs/{ticket?}','AdminController@viewTicketLogs')->name('admin.viewTicketLogs');
	Route::get('/help/tickets/admin/{user?}/logs','AdminController@viewAdminTicketLogs')->name('admin.viewAdminTicketLogs');
	Route::get('/help/tickets/user/{email?}/logs','AdminController@viewUserTicket')->name('admin.viewUserTicket');
	Route::get('/help/tickets/assigned/{user?}','AdminController@assignedTickets')->name('admin.assignedTickets');
	Route::get('/help/categories','AdminController@viewHelpCategories')->name('admin.viewHelpCategories');
	Route::post('/help/categories/{item?}','AdminController@performHelpCategoryTask')->name('admin.performHelpCategoryTask');
	// Route::put('/help/categories/{category}','AdminController@updateHelpCategory')->name('admin.updateHelpCategory');
	// Route::delete('/help/categories/{category}','AdminController@deleteHelpCategory')->name('admin.deleteHelpCategory');
	Route::get('/help/categories/logs/{target?}','AdminController@viewHelpCategoryLogs')->name('admin.viewHelpCategoryLogs');
	Route::get('/help/faq/manage/','AdminController@viewHelpFAQs')->name('admin.viewHelpFAQs');
	Route::post('/help/faq/manage/','AdminController@addHelpFAQ')->name('admin.addHelpFAQ');
	Route::put('/help/faq/manage/{entry}','AdminController@updateHelpFAQ')->name('admin.updateHelpFAQ');
	Route::delete('/help/faq/manage/{entry}','AdminController@deleteHelpFAQ')->name('admin.deleteHelpFAQ');
	Route::get('/help/faq/manage/logs/{target}','AdminController@viewHelpFAQLogs')->name('admin.viewHelpFAQLogs');
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

	Route::get('/topics','AdminController@listTopics')->name('admin.topics');

	//SuperAdministrator Routes
	Route::get('/manage-users/create','SuperAdminController@createUser')->name('superAdmin.createUser');
	Route::post('/manage-users/create','SuperAdminController@storeUser')->name('superAdmin.storeUser');

	//SystemAdministrator Routes
	Route::delete('/manage-users/all/{user}/kick','SystemAdminController@deleteUser')->name('systemAdmin.deleteUser');

});

Auth::routes();

// // Authentication Routes
// Route::get('login', [
// 	'as' => 'login',
// 	'uses' => 'Auth\LoginController@showLoginForm'
// ]);
// Route::post('login', [
// 	'as' => '',
// 	'uses' => 'Auth\LoginController@login'
// ]);
// Route::post('logout', [
// 	'as' => 'logout',
// 	'uses' => 'Auth\LoginController@logout'
// ]);

// // Password Reset Routes
// Route::post('password/email', [
// 	'as' => 'password.email',
// 	'uses' => 'Auth\ForgotPasswordController@sendResetLinkEmail'
// ]);
// Route::get('password/reset', [
// 	'as' => 'password.request',
// 	'uses' => 'Auth\ForgotPasswordController@showLinkRequestForm'
// ]);
// Route::post('password/reset', [
// 	'as' => 'password.update',
// 	'uses' => 'Auth\ResetPasswordController@reset'
// ]);
// Route::get('password/reset/{token}', [
// 	'as' => 'password.reset',
// 	'uses' => 'Auth\ResetPasswordController@showResetForm'
// ]);

// // Registration Routes
// Route::get('register', [
// 	'as' => 'register',
// 	'uses' => 'Auth\RegisterController@showRegistrationForm'
// ]);
// Route::post('register', [
// 	'as' => '',
// 	'uses' => 'Auth\RegisterController@register'
// ]);

Route::get('/', 'Controller@main')->name('home');