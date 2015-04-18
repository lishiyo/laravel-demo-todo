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

/*
By default, the RouteServiceProvider includes your routes.php file within a namespace group, allowing you to register controller routes without specifying the full App\Http\Controllers namespace prefix.

 */
Route::get('/', 'WelcomeController@index');
Route::get('home', 'HomeController@index');
Route::get('oauth_tumblr', ['as' => 'tumblr', 'uses' => 'WelcomeController@loginWithTumblr']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

/*
If it becomes necessary to add additional routes to a resource controller beyond the default resource routes, you should define those routes before your call to Route::resource:

Route::get('photos/popular', 'PhotoController@method');
 */

Route::resource('projects', 'ProjectsController');
// projects/{projects}/tasks/{tasks}
Route::resource('projects.tasks', 'TasksController');

// Bind models to routes - L4 way
// L5 way - see Providers/RouteServiceProvider
// Route::model('tasks', 'Task');
// Route::model('projects', 'Project');

// friendly ids - use slugs rather than ids
Route::bind('tasks', function($value, $route) {
	return App\Task::whereSlug($value)->first();
});
Route::bind('projects', function($value, $route) {
	return App\Project::whereSlug($value)->first();
});
