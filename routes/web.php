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

Route::get('/password/reset/{token}', 'Auth\ForgotPasswordController@getReset');
Route::post('/password/reset', 'Auth\ForgotPasswordController@postReset');
Auth::routes();

//Destroy Impersonate
Route::get('/impersonate/destroy','ImpersonateController@Destroy');

//applying auth to every following page
Route::group(['middleware' => 'auth'], function () {
    Route::get('/impersonate/user/{id}','ImpersonateController@Impersonate')->name('impersonate');

    //when trying to access home url redirect every user to their dashboard
    Route::get('/', 'DashboardController@showDashboard');
    Route::get('/dashboard', 'DashboardController@showDashboard');

    //show logout form
    Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');

    //new users registration (students)
    Route::get('/settings/system-settings/','SettingController@getSystemSettingsPage');
    Route::post('/settings/system-settings/','SettingController@updateSystemSettings');

    //stats
    Route::get('/stats/','StatsController@getStats');

    //new users registration (students)
    Route::get('/create-users','UserController@showNewUsersPage');
    Route::post('/create-users','UserController@addStudents');

    //list of students
    Route::get('/students/list/{page_var}','UserController@showStudents');
    Route::post('/students/list/{page_var}','UserController@archiveStudent');
    Route::delete('/students/list/{page_var}','UserController@deleteStudent');

    //staff holidays
    Route::get('/staff-holidays/list/{page_var}','HolidayController@getHolidays');
    Route::post('/staff-holidays/list/{page_var}','HolidayController@newHoliday');
    Route::delete('/staff-holidays/list/{page_var}','HolidayController@removeHoliday');

    //staff area
    Route::get('/staff-area/','StaffAreaController@getStaffArea');
    Route::post('/staff-area/','StaffAreaController@createNew');
    Route::delete('/staff-area/','StaffAreaController@deleteItem');


    Route::get('/staff-area/announcements/{page_var}','StaffAreaController@getAnnouncements');
    Route::post('/staff-area/announcements/{page_var}','StaffAreaController@newAnnouncement');
    Route::delete('/staff-area/announcements/{page_var}','StaffAreaController@removeAnnouncement');

    Route::get('/staff-area/resources/{page_var}','StaffAreaController@getStaffResources');
    Route::post('/staff-area/resources/{page_var}','StaffAreaController@newResource');
    Route::delete('/staff-area/resources/{page_var}','StaffAreaController@removeResource');

    Route::get('/staff-area/assesments/{page_var}','StaffAreaController@getStaffAssesments');
    Route::post('/staff-area/assesments/{page_var}','StaffAreaController@newAssesment');
    Route::delete('/staff-area/assesments/{page_var}','StaffAreaController@removeAssesment');

    //staff holiday request
    Route::get('/request-holidays/','HolidayController@getNewHolidays');
    Route::post('/request-holidays/','HolidayController@requestNewHolidays');

    //Tutor revenue Pages
    Route::get('/revenue/list/{page_var}','RevenueController@getTutorRevenue');
    Route::get('/revenue/invoice','RevenueController@generate_pdf');
    Route::post('/revenue/list/{page_var}','RevenueController@addNewSaleOrCreditEntry');
    Route::delete('/revenue/list/{page_var}','RevenueController@RemoveSaleOrCreditEntry');

    //tutors
    Route::get('/manage-users/list/{page_var}','TutorController@showTutors');
    Route::post('/manage-users/list/{page_var}','TutorController@addTutor');
    Route::delete('/manage-users/list/{page_var}','TutorController@removeUser');

    //courses
    Route::get('/courses/list/{page_var}','CourseController@showCourses');
    Route::post('/courses/list/{page_var}','CourseController@addCourse');
    Route::delete('/courses/list/{page_var}','CourseController@removeCourse');

    //course marking
    Route::get('/marking/list/{page_var}','CourseController@showCoursesMarking');
    Route::post('/marking/list/{page_var}','CourseController@courseMarking');

    //student courses
    Route::get('/my-courses/list/{page_var}','CourseController@showMyCourses');

    //pdf reader course page
    Route::get('/course/{course_id}/reader/{page_var}','CourseController@courseMaterialReader');
    Route::post('/course/{course_id}/reader/{page_var}','CourseController@saveCourseNotes');

    //course dash page
    Route::get('/course/{course_id}/dash/','CourseController@getCourseDash');
    Route::post('/course/{course_id}/dash/','CourseController@uploadAssignment');

    //single course edit
    Route::get('/courses/edit/{course_id}','CourseController@displayCourse');
    Route::post('/courses/edit/{course_id}','CourseController@editCourse');
    Route::delete('/courses/edit/{course_id}','CourseController@removeCourseTemplate');

    //get courses ajax
    Route::get('/get-courses-ajax','CourseController@getCoursesAJAX');
    //get student's incomplete assigned courses
    Route::get('/extend-course-subscription','CourseController@extendStudentCourseSubscriptionAJAX');
    //extend student course
    Route::get('/get-student-assigned-courses-by-id-ajax','CourseController@getStudentIncompleteAssignedCoursesAJAX');
    //mark assignment
    Route::get('/mark-student-assignment-ajax','CourseController@markStudentAssignment');
    //get student incomplete assigned course assignment marking by id ajax
    Route::get('/get-student-assignment-marking-by-id-ajax','CourseController@getStudentIncompleteAssignedCourseAssignmentAJAX');
    //get next assignment marking AJAX
    Route::get('/get-next-sam-assignment-marking-ajax','CourseController@getNextSAMAssignmentMarkingAJAX');
    //get next evidence marking AJAX
    Route::get('/get-next-sam-evidence-marking-ajax','CourseController@getNextSAMEvidenceMarkingAJAX');
    //get student incomplete assigned course assignment marking by id ajax
    Route::get('/get-student-course-marking-by-id-ajax','CourseController@getStudentAssignedCourseAJAX');
    //get student incomplete assigned work based course unit marking by id ajax
    Route::get('/get-student-work-based-course-marking-by-id-ajax','CourseController@getStudentAssignedWorkBasedCourseAJAX');
    //mark course (progress / complete)
    Route::get('/mark-course-progress-ajax','CourseController@markCourseProgress');
    //mark course (progress / complete)
    Route::get('/mark-unit-course-progress-ajax','CourseController@markUnitCourseProgress');
    //mark course (progress / complete)
    Route::get('/mark-sam-unit-course-progress-ajax','CourseController@markSAMUnitCourseProgress');
    //delete assignment note by id
    Route::get('/delete-assignment-note','CourseController@deleteAssignmentNoteAndGetAllNotes');
    //delete assignment marker by id
    Route::get('/delete-assignment-marker','CourseController@deleteAssignmentMarkerAndGetAllMarkers');

    //get courses except given ids
    Route::get('/get-courses-where-not-in-ajax','CourseController@getCoursesWhereNotInAJAX');
    //get student course assignment / evidence for uploading
    Route::get('/get-course-upload-for-marking-by-id-ajax','CourseController@getStudentCourseAssignmentForManualUploadByIdAJAX');
    //get student course assignment / evidence for uploading
    Route::get('/get-course-upload-for-dashboard-by-id-ajax','CourseController@getStudentCourseAssignmentManualUploadForDashboardByIdAJAX');

    //get single course by id - ajax
    Route::get('/get-course-by-id-ajax','CourseController@getCourseByIdAJAX');          //get single course by id - ajax
    Route::get('/get-evidence-by-id-ajax','CourseController@getEvidenceByIdAJAX');      //get single course by id - ajax
    Route::get('/get-feedback-by-id-ajax','CourseController@getFeedbackTemplateByIdAJAX');
    Route::get('/get-canned-response-by-id-ajax','CourseController@getCannedResponseByIdAJAX');
    //get tutors ajax
    Route::get('/get-tutors-ajax','TutorController@getTutorsAJAX');
    //get single tutor by id - ajax
    Route::get('/get-user-by-id-ajax','TutorController@getUserByIdAJAX');
    //get single task by id - ajax
    Route::get('/get-task-by-id-ajax','TasksController@getTaskByIdAJAX');

    //my account page
    Route::get('/my-account/','UserController@showMyAccount');
    Route::post('/my-account/','UserController@myAccount');
    Route::delete('/my-account/','UserController@deleteProfilePhoto');

    //tasks management
    Route::get('/task-management/list/{page_var}','TasksController@viewTasks');
    Route::post('/task-management/list/{page_var}','TasksController@createTask');
    Route::delete('/task-management/list/{page_var}','TasksController@deleteSelectedTasks');

    //tasks conversations
    Route::get('/task-management/conversation/{task_id}','TasksController@getTaskConversation');
    Route::post('/task-management/conversation/{task_id}','TasksController@postReplyInConversation');

    //help centre contact reasons
    Route::get('/help-centre/contact-reasons/','HelpCentreController@getContactReasons');
    Route::post('/help-centre/contact-reasons/','HelpCentreController@createContactReason');
//    Route::delete('/help-centre/contact-reasons/','HelpCentreController@deleteContactReason');

    //help centre
    Route::get('/help-centre/list/{page_var}','HelpCentreController@viewHelpCentreTask');
    Route::post('/help-centre/list/{page_var}','HelpCentreController@createHelpCentreTask');
    Route::delete('/help-centre/list/{page_var}','HelpCentreController@deleteSelectedHelpCentreTasks');

    //resources
    Route::get('/resources/list/{page_var}','ResourceController@viewResources');
    Route::post('/resources/list/{page_var}','ResourceController@createResource');
    Route::delete('/resources/list/{page_var}','ResourceController@deleteSelectedResources');

    //materials
    Route::get('/materials/list/{page_var}','MaterialController@viewMaterials');
    Route::post('/materials/list/{page_var}','MaterialController@createMaterial');
    Route::delete('/materials/list/{page_var}','MaterialController@deleteSelectedMaterials');

    //automatic emails
    Route::get('/communication/automatic-emails/list/{page_var}','AutomaticEmailController@viewAutomaticEmails');
    Route::post('/communication/automatic-emails/list/{page_var}','AutomaticEmailController@createAutomaticEmail');
    Route::delete('/communication/automatic-emails/list/{page_var}','AutomaticEmailController@deleteAutomaticEmails');

    //unique EMAIL template
    Route::get('/check-if-email-template-already-exists-ajax','AutomaticEmailController@checkIfEmailTemplateAlreadyExistsAJAX');
    Route::get('/get-email-template-by-id-ajax','AutomaticEmailController@getTemplatebyIdAJAX');

    //automatic sms
    Route::get('/communication/automatic-sms/list/{page_var}','AutomaticSMSController@viewAutomaticSMS');
    Route::post('/communication/automatic-sms/list/{page_var}','AutomaticSMSController@createAutomaticSMS');
    Route::delete('/communication/automatic-sms/list/{page_var}','AutomaticSMSController@deleteAutomaticSMS');

    //test sms
    Route::get('/test-sms','AutomaticSMSController@sendSMS');

    //unique SMS template
    Route::get('/check-if-sms-template-already-exists-ajax','AutomaticSMSController@checkIfSMSTemplateAlreadyExistsAJAX');
    Route::get('/get-template-by-id-ajax','AutomaticSMSController@getTemplatebyIdAJAX');

    //get user photo
    Route::get('/get-user-photo','UserController@getUserPhoto'); //returns json string
});



