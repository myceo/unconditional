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

use App\Http\Controllers\Tenant\Admin\Training\CoursesController;
use App\Http\Controllers\Tenant\Admin\Training\LecturePagesController;
use App\Http\Controllers\Tenant\Admin\Training\LecturesController;
use App\Http\Controllers\Tenant\Training\LmsController;
use Illuminate\Support\Facades\Route;

Route::get('/','HomeController@site')->name('site.home');
Route::get('/test','HomeController@test')->name('test');

Route::get('/privacy-policy','HomeController@privacy')->name('site.privacy');
Auth::routes();
Route::get('social/login/{network}','Auth\LoginController@social')->name('social.login');
Route::get('social/form','Auth\LoginController@completeSocial')->name('social.form');
Route::post('social/save','Auth\LoginController@saveSocial')->name('social.save-social');

Route::get('/home', 'HomeController@site')->name('home');

Route::get('/auth/social-login','Auth\AuthController@social')->name('auth.social');
Route::get('/auth/billing/{token}','Auth\AuthController@billing')->name('auth.billing');

Route::get('/groups','Site\DepartmentsController@index')->name('site.departments');
Route::get('/groups/{department}','Site\DepartmentsController@details')->name('site.department');
Route::get('cron','HomeController@cron')->name('cron');
Route::get('get-image','Site\DepartmentsController@getImage')->name('get-image');
Route::get('/contact','Site\ContactController@form')->name('site.contact');
Route::post('/contact','Site\ContactController@process')->name('site.process-contact');

Route::group(['prefix'=>'admin','middleware'=>['auth','admin']],function(){

    Route::get('/migrate','HomeController@migrate')->name('migrate');
    Route::get('/dashboard','Admin\IndexController@dashboard')->name('admin.dashboard');
    Route::resource('groups', 'Admin\DepartmentsController');
    Route::resource('categories', 'Admin\CategoriesController');
    Route::get('groups/remove-picture/{id}','Admin\DepartmentsController@removePicture')->name('dept.remove-picture');
    Route::get('groups/members/{department}','Admin\DepartmentsController@members')->name('dept.members');
    Route::get('groups/all-members/{department}','Admin\DepartmentsController@allMembers')->name('dept.all-members');
    Route::post('groups/add-members/{department}','Admin\DepartmentsController@addMembers')->name('dept.add-members');
    Route::post('groups/remove-members/{department}','Admin\DepartmentsController@removeMembers')->name('dept.remove-members');
    Route::get('groups/set-admin/{department}/{user}/{mode}','Admin\DepartmentsController@setAdmin')->name('dept.set-admin');

    Route::get('members/search','Admin\MembersController@search')->name('members.search');
    Route::post('members/export','Admin\MembersController@export')->name('members.export');
    Route::get('members/import','Admin\MembersController@import')->name('members.import');
    Route::post('members/import','Admin\MembersController@saveImport')->name('members.save-import');
    Route::resource('members', 'Admin\MembersController');
    Route::get('members/remove-picture/{id}','Admin\MembersController@removePicture')->name('members.remove-picture');
    Route::resource('fields', 'Admin\FieldsController');

    Route::get('settings/{group}','Admin\SettingsController@settings')->name('admin.settings');
    Route::post('save-settings','Admin\SettingsController@saveSettings')->name('admin.save-settings');
    Route::get('settings/remove-picture/{setting}','Admin\SettingsController@removePicture')->name('settings.remove-picture');
    Route::resource('admins', 'Admin\AdminsController');
    Route::get('sms-settings','Admin\SettingsController@smsGateways')->name('settings.sms_gateways');
    Route::post('save-sms-setting','Admin\SettingsController@saveSmsSetting')->name('settings.save-sms-setting');
    Route::get('sms-gateway/{smsGateway}','Admin\SettingsController@smsFields')->name('settings.edit-sms-gateway');
    Route::post('save-sms-gateway/{smsGateway}','Admin\SettingsController@saveField')->name('settings.save-sms-gateway');
    Route::get('gateway-status/{smsGateway}/{status}','Admin\SettingsController@setSmsStatus')->name('settings.sms-status');
    Route::get('localization','Admin\SettingsController@language')->name('settings.language');
    Route::post('save-language','Admin\SettingsController@saveLanguage')->name('settings.save-language');

    Route::post('emails/upload-attachment/{id}','Admin\EmailsController@upload')->name('emails.upload');
    Route::post('emails/remove-upload/{id}','Admin\EmailsController@removeUpload')->name('emails.remove-upload');
    Route::get('emails/delete-email/{id}','Admin\EmailsController@destroy')->name('email.delete');
    Route::post('emails/delete-multiple','Admin\EmailsController@deleteMultiple')->name('email.delete-multiple');
    Route::get('emails/view-image/{emailAttachment}','Admin\EmailsController@viewImage')->name('email.view-image');
    Route::get('emails/download-attachment/{emailAttachment}','Admin\EmailsController@downloadAttachment')->name('email.download-attachment');
    Route::get('emails/download-attachments/{email}','Admin\EmailsController@downloadAttachments')->name('email.download-attachments');

    Route::get('emails/inbox','Admin\EmailsController@inbox')->name('emails.inbox');
    Route::get('emails/delete-inbox/{id}','Admin\EmailsController@destroyInbox')->name('email.delete-inbox');
    Route::get('emails/view-inbox/{email}','Admin\EmailsController@viewInbox')->name('email.view-inbox');
    Route::post('emails/delete-multiple-inbox','Admin\EmailsController@deleteMultipleInbox')->name('email.delete-multiple-inbox');


    Route::resource('emails', 'Admin\EmailsController');


    Route::get('sms/delete-email/{id}','Admin\SmsController@destroy')->name('sms.delete');
    Route::post('sms/delete-multiple','Admin\SmsController@deleteMultiple')->name('sms.delete-multiple');
    Route::get('sms/inbox','Admin\SmsController@inbox')->name('sms.inbox');
    Route::get('sms/delete-inbox/{id}','Admin\SmsController@destroyInbox')->name('sms.delete-inbox');
    Route::post('sms/delete-multiple-inbox','Admin\SmsController@deleteMultipleInbox')->name('sms.delete-multiple-inbox');



    Route::resource('sms', 'Admin\SmsController');

    Route::get('token','Admin\AccountController@token')->name('token');
    Route::get('set-token','Admin\AccountController@setToken')->name('set-token');
    Route::get('remove-token','Admin\AccountController@deleteToken')->name('remove-token');
    //Training routes
    Route::group(['namespace' => 'Admin\Training','as'=>'admin.'],function(){

        Route::get('/courses/{course}/duplicate',[CoursesController::class,'duplicate'])->name('courses.duplicate');


            Route::get('/courses/{course}/certificate',[CoursesController::class,'certificate'])->name('courses.certificate');
            Route::post('/courses/{course}/certificate',[CoursesController::class,'updateCertificate'])->name('courses.update-certificate');
            Route::get('/courses/{course}/certificate-image',[CoursesController::class,'clearCertificateImage'])->name('courses.certificate-image');
            Route::get('/courses/{course}/image/delete','CoursesController@removeImage')->name('courses.remove-image');


        Route::get('/course/{course}/students',[CoursesController::class,'students'])->name('courses.students');
        Route::post('/course/{course}/students',[CoursesController::class,'addStudents'])->name('courses.add-students');
        Route::post('/course/{course}/students/message',[CoursesController::class,'message'])->name('courses.message-students');

        Route::get('courses/{course}/play',[CoursesController::class,'play'])->name('courses.play');
        Route::resource('courses','CoursesController');
        Route::resource('course-categories', 'CourseCategoriesController');


        Route::get('/class/{lesson}/image/delete','LessonsController@removeImage')->name('lessons.remove-image');
        Route::resource('courses.classes', 'LessonsController')->parameters([
            'classes' => 'lesson'
        ]);
        Route::get('lectures/{lecture}/files',[LecturesController::class,'files'])->name('lecture.files');
        Route::resource('classes.lectures', 'LecturesController')->parameters([
            'classes' => 'lesson'
        ]);
        Route::get('course/lecture/edit-quiz/{lecturePage}','LecturePagesController@editQuiz')->name('lecture.edit-quiz');
        Route::post('course/lecture/edit-quiz/{lecturePage}','LecturePagesController@saveQuiz')->name('lecture.save-quiz');

        Route::post('course/lecture/lecture-pages/delete-multiple',[LecturePagesController::class,'deleteMultiple'])->name('lecture-pages.delete-multiple');
        Route::get('course/lecture/{lecture}/import-images',[LecturePagesController::class,'importImages'])->name('lecture-pages.import');
        Route::post('course/lecture/{lecture}/import-images',[LecturePagesController::class,'saveImages'])->name('lecture-pages.import-save');
        Route::resource('lectures.lecture-pages', 'LecturePagesController');

        Route::resource('tests', 'TestsController');
        Route::resource('test-questions', 'TestQuestionsController');
        Route::get('test-question/{test}','TestQuestionsController@index')->name('test-questions.index');
        Route::get('test-question/create/{test}','TestQuestionsController@create')->name('test-questions.create');
        Route::post('test-question/{test}','TestQuestionsController@store')->name('test-questions.store');
        Route::post('test-option/store/{testQuestion}','TestQuestionsController@storeOptions')->name('test-options.store');
        Route::get('test-options/edit/{testOption}','TestQuestionsController@editOption')->name('test-options.edit');
        Route::post('test-options/update/{testOption}','TestQuestionsController@updateOption')->name('test-options.update');
        Route::get('test-options/delete/{testOption}','TestQuestionsController@deleteOption')->name('test-options.delete');
        Route::get('test-attempts/{test}','TestsController@attempts')->name('tests.attempts');
        Route::get('delete-result/{userTest}','TestsController@deleteResult')->name('tests.delete-result');
        Route::get('view-result/{userTest}','TestsController@results')->name('tests.results');



    });


});


Route::group(['middleware'=>['auth','enrolled-course'],'prefix' => 'lms/{course}', 'as' => 'lms.'],function() {
    Route::get('landing',[LmsController::class,'landing'])->name('landing');
    Route::get('resume',[LmsController::class,'resume'])->name('resume');
    Route::get('start',[LmsController::class,'start'])->name('start');
    Route::get('class/{lesson}',[LmsController::class,'lesson'])->name('lesson');
    Route::get('lecture/{lecture}',[LmsController::class,'lecture'])->name('lecture');
    Route::post('lecture/{lecture}/log',[LmsController::class,'logLecture'])->name('log-lecture');
    Route::get('certificate',[LmsController::class,'certificate'])->name('certificate');
});


Route::get('/p'.'u'.'rc'.'ha'.'se-'.'c'.'o'.'d'.'e',[\App\Livewire\Site\Setup::class,'__invoke'])->name('se'.'tup');

Route::group(['prefix'=>'member','middleware'=>['auth','department']],function(){

    Route::get('/dashboard','Member\IndexController@dashboard')->name('member.dashboard');

    Route::get('teams/my-teams','Member\TeamsController@myTeams')->name('member.my-teams');

    Route::resource('teams', 'Member\TeamsController');
    Route::get('members/search','Member\MembersController@search')->name('member.members.search');

    Route::get('events/roster','Member\EventsController@roster')->name('member.events.roster');
    Route::get('events/roster/{event}','Member\EventsController@rosterEvent')->name('member.events.view-roster');

    Route::get('events/download/{event}','Member\EventsController@download')->name('member.events.download');
    Route::post('events/roaster-opt-out/{shift}','Member\EventsController@optOut')->name('member.events.opt-out');
    Route::get('events/my-shifts','Member\EventsController@shifts')->name('member.events.shifts');
    Route::get('events/roster-volunteer/{shift}','Member\EventsController@volunteer')->name('member.events.volunteer');

    Route::get('events/{event}/comments','Member\EventCommentsController@index')->name('member.event-comments.index');
    Route::post('events/{event}/comment','Member\EventCommentsController@store')->name('member.event-comments.store');
    Route::get('event-comments/view-image/{eventCommentAttachment}','Member\EventCommentsController@viewImage')->name('member.event-comments.view-image');
    Route::get('event-comments/download-file/{eventCommentAttachment}','Member\EventCommentsController@commentAttachment')->name('member.event-comments.download-attachment');
    Route::get('event-comments/download-files/{eventComment}','Member\EventCommentsController@commentAttachments')->name('member.event-comments.download-attachments');

    Route::resource('event-reports', 'Member\EventReportsController');
    Route::get('event-reports/view-image/{eventReportAttachment}','Member\EventReportsController@viewImage')->name('member.event-reports.view-image');
    Route::get('event-reports/download-file/{eventReportAttachment}','Member\EventReportsController@reportAttachment')->name('member.event-reports.download-attachment');
    Route::get('event-reports/download-files/{eventReport}','Member\EventReportsController@reportAttachments')->name('member.event-reports.download-attachments');
    Route::get('event-report-attachments/delete/{eventReportAttachment}','Member\EventReportsController@deleteAttachment')->name('member.event-reports.delete-attachment');


    Route::group(['middleware'=>'department.admin'],function(){

        Route::get('members/applications','Member\MembersController@applications')->name('member.members.applications');
        Route::get('members/application/{application}','Member\MembersController@application')->name('member.members.application');
        Route::post('members/application/{application}','Member\MembersController@updateApplication')->name('member.members.update-application');

        Route::get('members/remove/{id}','Member\MembersController@destroy')->name('member.members.remove');

        Route::post('members/export','Member\MembersController@export')->name('member.members.export');
        Route::get('members/import','Member\MembersController@import')->name('member.members.import');
        Route::post('members/import','Member\MembersController@saveImport')->name('member.members.save-import');

        Route::get('settings/general','Member\SettingsController@general')->name('member.settings.general');
        Route::post('settings/save-settings','Member\SettingsController@saveSettings')->name('member.settings.save-settings');
        Route::get('settings/remove-picture','Member\SettingsController@removePicture')->name('member.settings.remove-picture');

        Route::resource('fields', 'Member\FieldsController');

        Route::get('members/set-admin/{user}/{mode}','Member\MembersController@setAdmin')->name('member.members.set-admin');

        Route::resource('events', 'Member\EventsController');
        Route::post('events/duplicate/{event}','Member\EventsController@duplicate')->name('member.events.duplicate');
        Route::get('events/{event}/reports','Member\EventsController@reports')->name('member.events.reports');

        Route::get('events/shifts/{event}','Member\ShiftsController@index')->name('member.shifts.index');
        Route::get('events/shifts/create/{event}','Member\ShiftsController@create')->name('member.shifts.create');
        Route::post('events/shifts/store/{event}','Member\ShiftsController@store')->name('member.shifts.store');
        Route::get('events/shifts/{shift}/tasks/','Member\ShiftsController@tasks')->name('member.shifts.tasks');
        Route::post('events/shifts/{shift}/save-tasks','Member\ShiftsController@saveTasks')->name('member.shifts.save-tasks');
        Route::resource('shifts', 'Member\ShiftsController');

        Route::resource('galleries', 'Member\GalleriesController');




    });

    Route::get('members/leave','Member\MembersController@leaveGroup')->name('member.leave-group');
    Route::post('members/leave','Member\MembersController@processLeaveGroup')->name('member.process-leave');
    Route::get('members/birthdays','Member\MembersController@birthdays')->name('member.birthdays');
    Route::get('members/anniversaries','Member\MembersController@anniversaries')->name('member.anniversaries');
    Route::resource('members', 'Member\MembersController');

    Route::post('emails/upload-attachment/{id}','Member\EmailsController@upload')->name('member.emails.upload');
    Route::post('emails/remove-upload/{id}','Member\EmailsController@removeUpload')->name('member.emails.remove-upload');
    Route::get('emails/delete-email/{id}','Member\EmailsController@destroy')->name('member.email.delete');
    Route::post('emails/delete-multiple','Member\EmailsController@deleteMultiple')->name('member.email.delete-multiple');
    Route::get('emails/view-image/{emailAttachment}','Member\EmailsController@viewImage')->name('member.email.view-image');
    Route::get('emails/download-attachment/{emailAttachment}','Member\EmailsController@downloadAttachment')->name('member.email.download-attachment');
    Route::get('emails/download-attachments/{email}','Member\EmailsController@downloadAttachments')->name('member.email.download-attachments');

    Route::get('emails/inbox','Member\EmailsController@inbox')->name('member.emails.inbox');
    Route::get('emails/delete-inbox/{id}','Member\EmailsController@destroyInbox')->name('member.email.delete-inbox');
    Route::get('emails/view-inbox/{email}','Member\EmailsController@viewInbox')->name('member.email.view-inbox');
    Route::post('emails/delete-multiple-inbox','Member\EmailsController@deleteMultipleInbox')->name('member.email.delete-multiple-inbox');

    Route::resource('emails', 'Member\EmailsController');

    Route::get('/announcements/pin/{announcement}/{pinned}','Member\AnnouncementsController@pinned')->name('member.annoucements.pinned');
    Route::get('announcements/{announcement}/comments','Member\AnnouncementCommentsController@index')->name('member.announcement-comments.index');
    Route::post('announcements/{announcement}/comment','Member\AnnouncementCommentsController@store')->name('member.announcement-comments.store');
    Route::get('announcement-comments/view-image/{announcementCommentAttachment}','Member\AnnouncementCommentsController@viewImage')->name('member.announcement-comments.view-image');
    Route::get('announcement-comments/download-file/{announcementCommentAttachment}','Member\AnnouncementCommentsController@commentAttachment')->name('member.announcement-comments.download-attachment');
    Route::get('announcement-comments/download-files/{announcementComment}','Member\AnnouncementCommentsController@commentAttachments')->name('member.announcement-comments.download-attachments');

    Route::resource('announcements', 'Member\AnnouncementsController');

    Route::get('downloads/pin/{download}/{pinned}','Member\DownloadsController@pinned')->name('member.download.pinned');
    Route::get('downloads/view-image/{downloadFile}','Member\DownloadsController@viewImage')->name('member.download.view-image');
    Route::get('downloads/download-file/{downloadFile}','Member\DownloadsController@downloadAttachment')->name('member.download.download-attachment');
    Route::get('downloads/download-files/{download}','Member\DownloadsController@downloadAttachments')->name('member.download.download-attachments');
    Route::get('downloads/browse','Member\DownloadsController@browse')->name('member.downloads.browse');
    Route::resource('downloads', 'Member\DownloadsController');

    Route::get('/forum-topics/pin/{forumTopic}/{pinned}','Member\ForumTopicsController@pinned')->name('member.forum.pinned');
    Route::get('/forum-topics/status/{forumTopic}/{status}','Member\ForumTopicsController@setStatus')->name('member.forum.status');
    Route::get('forum-topics/view-image/{forumAttachment}','Member\ForumTopicsController@viewImage')->name('member.forum.view-image');
    Route::get('forum-topics/download-file/{forumAttachment}','Member\ForumTopicsController@forumAttachment')->name('member.forum.download-attachment');
    Route::get('forum-topics/download-files/{forumThread}','Member\ForumTopicsController@forumAttachments')->name('member.forum.download-attachments');

    Route::resource('forum-topics', 'Member\ForumTopicsController');

    Route::group(['middleware'=>'sms'],function(){
        Route::get('sms/delete-email/{id}','Member\SmsController@destroy')->name('member.sms.delete');
        Route::post('sms/delete-multiple','Member\SmsController@deleteMultiple')->name('member.sms.delete-multiple');
        Route::get('sms/inbox','Member\SmsController@inbox')->name('member.sms.inbox');
        Route::get('sms/delete-inbox/{id}','Member\SmsController@destroyInbox')->name('member.sms.delete-inbox');
        Route::post('sms/delete-multiple-inbox','Member\SmsController@deleteMultipleInbox')->name('member.sms.delete-multiple-inbox');
        Route::resource('sms', 'Member\SmsController');
    });

    Route::group(['namespace'=>'Member'],function (){
         Route::get('courses/{course}/enroll','CoursesController@enroll')->name('member.course-enroll');
        Route::get('courses/{course}','CoursesController@details')->name('member.course-details');
        Route::get('courses','CoursesController@index')->name('member.courses');
    });

});



//general auth
Route::group(['middleware'=>['auth']],function(){

    Route::get('account/profile','Admin\AccountController@profile')->name('account.profile');
    Route::post('account/save-profile','Admin\AccountController@saveProfile')->name('account.save-profile');
    Route::get('account/password','Admin\AccountController@password')->name('account.password');
    Route::post('account/save-password','Admin\AccountController@savePassword')->name('account.save-password');
    Route::get('account/remove-picture','Admin\AccountController@removePicture')->name('account.remove-picture');

    Route::get('select-group','Site\DepartmentsController@myDepartments')->name('site.select-department');
    Route::get('join-group/{department}','Site\DepartmentsController@join')->name('site.join-department');
    Route::get('apply/{department}','Site\DepartmentsController@apply')->name('site.apply');
    Route::post('save-application/{department}','Site\DepartmentsController@saveApplication')->name('site.save-application');
    Route::get('my-applications','Site\DepartmentsController@myApplications')->name('site.my-applications');
    Route::get('group-login/{department}','Site\DepartmentsController@login')->name('site.department-login');
    Route::get('delete-application/{application}','Site\DepartmentsController@deleteApplication')->name('site.delete-application');

    Route::group(['prefix'=>'user'],function(){
        Route::post('emails/upload-attachment/{id}','User\EmailsController@upload')->name('user.emails.upload');
        Route::post('emails/remove-upload/{id}','User\EmailsController@removeUpload')->name('user.emails.remove-upload');
        Route::get('emails/delete-email/{id}','User\EmailsController@destroy')->name('user.email.delete');
        Route::post('emails/delete-multiple','User\EmailsController@deleteMultiple')->name('user.email.delete-multiple');
        Route::get('emails/view-image/{emailAttachment}','User\EmailsController@viewImage')->name('user.email.view-image');
        Route::get('emails/download-attachment/{emailAttachment}','User\EmailsController@downloadAttachment')->name('user.email.download-attachment');
        Route::get('emails/download-attachments/{email}','User\EmailsController@downloadAttachments')->name('user.email.download-attachments');

        Route::get('emails/inbox','User\EmailsController@inbox')->name('user.emails.inbox');
        Route::get('emails/delete-inbox/{id}','User\EmailsController@destroyInbox')->name('user.email.delete-inbox');
        Route::get('emails/view-inbox/{email}','User\EmailsController@viewInbox')->name('user.email.view-inbox');
        Route::post('emails/delete-multiple-inbox','User\EmailsController@deleteMultipleInbox')->name('user.email.delete-multiple-inbox');
        Route::resource('emails', 'User\EmailsController');
        Route::resource('blocked-users','User\BlockedUsersController');
    });

    Route::get('/group/announcement/{announcement}','Site\DepartmentsController@announcement')->name('user.announcement');
    Route::get('/group/forum-topic/{forumTopic}','Site\DepartmentsController@forumTopic')->name('user.forum-topic');
    Route::get('/group/event/{event}','Site\DepartmentsController@event')->name('user.event');

    Route::get('courses/{course}/enroll',[\App\Http\Controllers\Tenant\Site\CoursesController::class,'enroll'])->name('site.course-enroll');
    Route::get('my-courses',[\App\Http\Controllers\Tenant\Site\CoursesController::class,'myCourses'])->name('site.my-courses');
    Route::get('remove-course/{course}',[\App\Http\Controllers\Tenant\Site\CoursesController::class,'remove'])->name('site.remove-course');
    Route::get('test/{test}/{course?}','Site\TestController@start')->name('site.tests.start');
    Route::post('test/{userTest}/{course?}','Site\TestController@processTest')->name('site.tests.process');
    Route::get('test-result/{userTest}','Site\TestController@result')->name('site.tests.result');
    Route::get('test-results/{test}','Site\TestController@results')->name('site.tests.results');



});


Route::get('courses',[\App\Http\Controllers\Tenant\Site\CoursesController::class,'courses'])->name('site.courses');
Route::get('courses/{course}',[\App\Http\Controllers\Tenant\Site\CoursesController::class,'course'])->name('site.course-details');
Route::get('tests',[\App\Http\Controllers\Tenant\Site\TestController::class,'index'])->name('site.tests');
