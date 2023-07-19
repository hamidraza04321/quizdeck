<?php

use Illuminate\Support\Facades\Route;

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
    return redirect()->back();
})->middleware('auth');

// Admin Routes
Route::group([ 'middleware' => ['auth', 'is_admin'], 'prefix' => 'admin', 'namespace' => 'Admin' ], function(){
	
	// Dashboard Routes
	Route::get('/dashboard', 'DashboardController@index');
	
	// User Controller Routes
	Route::resource('/user', 'UserController');
	Route::post('/user/delete', 'UserController@delete')->name('user.delete');
	Route::post('/user/status', 'UserController@changeStatus')->name('user.change.status');

	// Paper Controller Routes
	Route::get('/paper', 'PaperController@index');
	Route::get('/paper/create', 'PaperController@create');
	Route::get('/paper/review/{id}', 'PaperController@reviewPaper');
	Route::get('/paper/destroy', 'PaperController@destroy')->name('paper.destroy');

	Route::post('/paper', 'PaperController@store')->name('paper.store');
	Route::post('/paper/get-explaination', 'PaperController@getExplaination')->name('get.question.explaination');

	// Subject Controller Routes
	Route::resource('/subject', 'SubjectController');
	Route::post('/subject/delete', 'SubjectController@delete')->name('subject.delete');

	// Group Controller Routes
	Route::get('/groups', 'GroupController@index');
	Route::post('/group/store', 'GroupController@store')->name('group.store');
	Route::post('/group/add-user-in-group', 'GroupController@addUserInGroup')->name('add.user.in.group');
	Route::post('/group/delete-group', 'GroupController@deleteGroup')->name('delete.group');
	Route::post('/group/group-users', 'GroupController@groupUsers')->name('get.group.users');
	Route::post('/group/remove-user', 'GroupController@removeUser')->name('remove.user.from.group');

	// Assign Paper Controller Routes
	Route::get('/assign-paper', 'AssignPaperController@index');
	Route::post('/assign-paper/destroy', 'AssignPaperController@destroy')->name('assign-paper.destroy');

	Route::get('/assign-paper/reivew-student-results/{id}', 'AssignPaperController@reviewStudentResults');
	Route::get('/assign-paper/reivew-student-results/view-result/{id}', 'AssignPaperController@viewResult')->name('assign-paper.view-result');
	Route::post('/assign-paper/reivew-student-results/delete', 'AssignPaperController@deleteStudentResult')->name('delete.student.result');

	Route::get('/assign-paper/view-paper/{id}', 'AssignPaperController@viewPaper');
	
	// Routes In Assign Paper Create
	Route::get('/assign-paper/create', 'AssignPaperController@create');
	Route::post('/assign-paper/store', 'AssignPaperController@store')->name('assign-paper.store');
	Route::post('/assign-paper/assign-for', 'AssignPaperController@assignFor')->name('assign-paper.assign-for');
	Route::post('/assign-paper/get-papers', 'AssignPaperController@getPapers')->name('assign-paper.get-papers');
	Route::post('/assign-paper/get-description', 'AssignPaperController@getDescription')->name('assign-paper.get-description');

	// Student Report Routes
	Route::get('/students-report', 'StudentsReportController@index');
	Route::post('/students-report/get-report', 'StudentsReportController@getReport')->name('student-report.get-report');

	// Settigns Routes
	Route::get('/settings', 'SettingsController@index')->name('settings.index');
	Route::post('/settings/store', 'SettingsController@store')->name('settings.store');
});

// User Routes
Route::group([ 'middleware' => ['auth', 'is_user']], function(){

	// Dashboard Route
	Route::get('/dashboard', 'DashboardController@index');

	// In Progress Papers Routes
	Route::get('/in-progress-papers', 'InProgressPapersController@index');
	Route::get('/in-progress-papers/attempt-paper/{id}', 'InProgressPapersController@attemptPaper')->middleware('is_attempt_paper');
	
	Route::post('/in-progress-papers/change-status', 'InProgressPapersController@changeStatus')->name('attempt.paper.change.status');
	Route::post('/in-progress-papers/get-question', 'InProgressPapersController@getQuestion')->name('attempt.paper.get.question');
	Route::post('/in-progress-papers/store-answers', 'InProgressPapersController@storeAnswers')->name('attempt.paper.store.answers');
	Route::post('/in-progress-papers/save-paper', 'InProgressPapersController@savePaper')->name('attempt.paper.save.paper');
	Route::post('/in-progress-papers/submit-paper', 'InProgressPapersController@submitPaper')->name('attempt.paper.submit.paper');

	// Submitted Papers Routes
	Route::get('/submitted-papers', 'SubmittedPapersController@index');
	Route::get('/submitted-papers/review-result/{id}', 'SubmittedPapersController@reviewResult');
	Route::post('/submitted-papers/review-result/get-explaination', 'SubmittedPapersController@getExplaination')->name('submitted-papers.get-explaination');

});

// AUTHENTICATION ROUTES

Route::group([ 'middleware' => 'auth'], function(){

	// GAME ROUTES
	Route::get('/games', 'GameController@index');
	Route::get('/games/menja', 'GameController@menja');
	Route::get('/games/color-blast', 'GameController@colorBlast');
	Route::get('/games/snake', 'GameController@snake');
	Route::get('/games/flip-card', 'GameController@flipCard');

	// USER PROFILE ROUTES
	Route::get('/user/profile/{id}', 'Admin\UserController@profile')->name('user.profile');
	Route::post('/user/profile/update/{id}', 'Admin\UserController@updateProfile')->name('user.profile.update');
	Route::post('/user/profile/change-password', 'Admin\UserController@changePassword')->name('user.profile.change.password');
	Route::post('/user/profile/image/update', 'Admin\UserController@updateProfileImage')->name('update.user.profile.image');
});

Auth::routes();
