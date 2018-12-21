<?php

Route::group(['prefix' => 'api', 'middleware' => 'auth'], function () {

    /*
     * ---------------
     * Organisers
     * ---------------
     */


    /*
     * ---------------
     * Events
     * ---------------
     */
    Route::resource('events', 'API\EventsApiController');


    /*
     * ---------------
     * Attendees
     * ---------------
     */
    Route::resource('attendees', 'API\AttendeesApiController');


    /*
     * ---------------
     * Orders
     * ---------------
     */

    /*
     * ---------------
     * Users
     * ---------------
     */
    Route::post('/users', 'API\UsersApiController@store');

    /*
     * ---------------
     * Check-In / Check-Out
     * ---------------
     */

});