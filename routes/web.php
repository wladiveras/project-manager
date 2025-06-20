<?php

use Illuminate\Support\Facades\Auth;
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
// Auth::routes();

// Route::get('/register/{lang?}', 'Auth\RegisterController@showRegistrationForm')->name('register');
// Route::get('/login/{lang?}', 'Auth\LoginController@showLoginForm')->name('login');
// Route::get('/reset/password/{lang?}', 'Auth\LoginController@showLinkRequestForm')->name('password.request');

require __DIR__.'/auth.php';

Route::get('/', ['uses' => 'HomeController@landingPage'])->middleware(['XSS']);
Route::get('/home', ['as' => 'home','uses' => 'HomeController@index'])->middleware(['auth','XSS',]);
Route::post('/stripe', ['as' => 'stripe.post','uses' => 'HomeController@stripe'])->middleware(['auth','XSS',]);
Route::get('dashboard-view',['as' => 'dashboard.view','uses' => 'HomeController@filterView'])->middleware(['auth', 'XSS']);

// User Module
Route::get('users/{view?}',['as' => 'users','uses' => 'UserController@index'])->middleware(['auth', 'XSS']);
Route::get('users-view',['as' => 'filter.user.view','uses' => 'UserController@filterUserView'])->middleware(['auth', 'XSS']);
Route::get('checkuserexists',['as' => 'user.exists','uses' => 'UserController@checkUserExists'])->middleware(['auth', 'XSS']);
Route::get('profile',['as' => 'profile','uses' =>'UserController@profile'])->middleware(['auth','XSS']);
Route::post('/profile',['as' => 'update.profile','uses' =>'UserController@updateProfile'])->middleware(['auth','XSS']);
Route::get('user/info/{id}',['as' => 'users.info','uses' =>'UserController@userInfo'])->middleware(['auth','XSS']);
Route::get('user/{id}/info/{type}',['as' => 'user.info.popup','uses' =>'UserController@getProjectTask'])->middleware(['auth','XSS']);
Route::delete('users/{id}', ['as' => 'user.destroy', 'uses' => 'UserController@destroy'])->middleware(['auth', 'XSS']);
// End User Module

// Language Module
Route::get('/lang/create',['as' => 'lang.create','uses' =>'UserController@createLang'])->middleware(['auth','XSS']);
Route::get('/lang/{lang}',['as' => 'lang','uses' =>'UserController@lang'])->middleware(['auth','XSS']);
Route::post('/lang',['as' => 'lang.store','uses' =>'UserController@storeLang'])->middleware(['auth','XSS']);
Route::post('/lang/data/{lang}',['as' => 'lang.store.data','uses' =>'UserController@storeLangData'])->middleware(['auth','XSS']);
Route::get('/lang/change/{lang}',['as' => 'lang.change','uses' =>'UserController@changeLang'])->middleware(['auth','XSS']);
Route::delete('/lang/{id}',['as' => 'lang.destroy','uses' =>'UserController@destroyLang'])->middleware(['auth','XSS']);
// End Language Module

// Search
Route::get('/search',['as' => 'search.json','uses' =>'UserController@search']);
// end

// Milestone Module
Route::get('projects/{id}/milestone', ['as' => 'project.milestone','uses' => 'ProjectController@milestone'])->middleware(['auth', 'XSS']);
Route::post('projects/{id}/milestone', ['as' => 'project.milestone.store', 'uses' => 'ProjectController@milestoneStore'])->middleware(['auth', 'XSS']);
Route::get('projects/milestone/{id}/edit', ['as' => 'project.milestone.edit', 'uses' => 'ProjectController@milestoneEdit'])->middleware(['auth', 'XSS']);
Route::post('projects/milestone/{id}', ['as' => 'project.milestone.update', 'uses' => 'ProjectController@milestoneUpdate'])->middleware(['auth', 'XSS']);
Route::delete('projects/milestone/{id}', ['as' => 'project.milestone.destroy', 'uses' => 'ProjectController@milestoneDestroy'])->middleware(['auth', 'XSS']);
Route::get('projects/milestone/{id}/show', ['as' => 'project.milestone.show', 'uses' => 'ProjectController@milestoneShow'])->middleware(['auth', 'XSS']);
// End Milestone

// Project Module
Route::get('invite-project-member/{id}',['as' => 'invite.project.member.view','uses' => 'ProjectController@inviteMemberView'])->middleware(['auth', 'XSS']);
Route::post('invite-project-user-member',['as' => 'invite.project.user.member','uses' => 'ProjectController@inviteProjectUserMember'])->middleware(['auth', 'XSS']);
Route::get('project/{view?}',['as' => 'projects.list','uses' => 'ProjectController@index'])->middleware(['auth', 'XSS']);
Route::get('projects-view',['as' => 'filter.project.view','uses' => 'ProjectController@filterProjectView'])->middleware(['auth', 'XSS']);
Route::post('projects/{id}/store-stages/{slug}', 'ProjectController@storeProjectTaskStages')->name('project.stages.store')->middleware(['auth', 'XSS']);
Route::patch('remove-user-from-project/{project_id}/{user_id}', ['as' => 'remove.user.from.project','uses' => 'ProjectController@removeUserFromProject'])->middleware(['auth', 'XSS']);
Route::get('projects-users',['as' => 'project.user','uses' => 'ProjectController@loadUser'])->middleware(['auth', 'XSS']);
Route::get('projects/{id}/gantt/{duration?}',['as' => 'projects.gantt','uses' =>'ProjectController@gantt'])->middleware(['auth','XSS']);
Route::post('projects/{id}/gantt',['as' => 'projects.gantt.post','uses' =>'ProjectController@ganttPost'])->middleware(['auth','XSS']);
Route::resource('projects', 'ProjectController')->middleware(['auth', 'XSS']);

// User Permission
Route::get('projects/{id}/user/{uid}/permission',['as' => 'projects.user.permission','uses' =>'ProjectController@userPermission'])->middleware(['auth','XSS']);
Route::post('projects/{id}/user/{uid}/permission',['as' => 'projects.user.permission.store','uses' =>'ProjectController@userPermissionStore'])->middleware(['auth','XSS']);
// End Project Module

// user module
Route::get('add-user',['as' => 'add.user.view','uses' => 'UserController@addUser'])->middleware(['auth', 'XSS']);
Route::get('check-user-exist',['as' => 'add.user.exists','uses' => 'UserController@addUserExists'])->middleware(['auth', 'XSS']);
Route::post('add-user-member',['as' => 'add.user.member','uses' => 'UserController@addUserMember'])->middleware(['auth', 'XSS']);
//forgot password
Route::any('user-reset-password/{id}', 'UserController@userPassword')->name('user.reset');
Route::post('user-reset-password/{id}', 'UserController@userPasswordReset')->name('user.password.update');

// Task Module
Route::get('stage/{id}/tasks', ['as' => 'stage.tasks','uses' => 'ProjectTaskController@getStageTasks'])->middleware(['auth', 'XSS']);

// Project Task Module
Route::get('/projects/{id}/task',['as' => 'projects.tasks.index','uses' =>'ProjectTaskController@index'])->middleware(['auth','XSS']);
Route::get('/projects/{pid}/task/{sid}',['as' => 'projects.tasks.create','uses' =>'ProjectTaskController@create'])->middleware(['auth','XSS']);
Route::post('/projects/{pid}/task/{sid}',['as' => 'projects.tasks.store','uses' =>'ProjectTaskController@store'])->middleware(['auth','XSS']);
Route::get('/projects/{id}/task/{tid}/show',['as' => 'projects.tasks.show','uses' =>'ProjectTaskController@show'])->middleware(['auth','XSS']);
Route::get('/projects/{id}/task/{tid}/edit',['as' => 'projects.tasks.edit','uses' =>'ProjectTaskController@edit'])->middleware(['auth','XSS']);
Route::post('/projects/{id}/task/update/{tid}',['as' => 'projects.tasks.update','uses' =>'ProjectTaskController@update'])->middleware(['auth','XSS']);
Route::delete('/projects/{id}/task/{tid}',['as' => 'projects.tasks.destroy','uses' =>'ProjectTaskController@destroy'])->middleware(['auth','XSS']);
Route::patch('/projects/{id}/task/order',['as' => 'tasks.update.order','uses' =>'ProjectTaskController@taskOrderUpdate'])->middleware(['auth','XSS']);
Route::patch('update-task-priority-color', ['as' => 'update.task.priority.color','uses' => 'ProjectTaskController@updateTaskPriorityColor'])->middleware(['auth', 'XSS']);

Route::post('/projects/{id}/comment/{tid}/file',['as' => 'comment.store.file','uses' =>'ProjectTaskController@commentStoreFile']);
Route::delete('/projects/{id}/comment/{tid}/file/{fid}',['as' => 'comment.destroy.file','uses' =>'ProjectTaskController@commentDestroyFile']);
Route::post('/projects/{id}/comment/{tid}',['as' => 'comment.store','uses' =>'ProjectTaskController@commentStore']);
Route::delete('/projects/{id}/comment/{tid}/{cid}',['as' => 'comment.destroy','uses' =>'ProjectTaskController@commentDestroy']);
Route::post('/projects/{id}/checklist/{tid}',['as' => 'checklist.store','uses' =>'ProjectTaskController@checklistStore']);
Route::post('/projects/{id}/checklist/update/{cid}',['as' => 'checklist.update','uses' =>'ProjectTaskController@checklistUpdate']);
Route::delete('/projects/{id}/checklist/{cid}',['as' => 'checklist.destroy','uses' =>'ProjectTaskController@checklistDestroy']);
Route::post('/projects/{id}/change/{tid}/fav',['as' => 'change.fav','uses' =>'ProjectTaskController@changeFav']);
Route::post('/projects/{id}/change/{tid}/complete',['as' => 'change.complete','uses' =>'ProjectTaskController@changeCom']);
Route::post('/projects/{id}/change/{tid}/progress',['as' => 'change.progress','uses' =>'ProjectTaskController@changeProg']);
Route::get('/projects/task/{id}/get',['as' => 'projects.tasks.get','uses' =>'ProjectTaskController@taskGet'])->middleware(['auth','XSS']);

Route::get('taskboard/{view?}',['as' => 'taskBoard.view','uses' => 'ProjectTaskController@taskBoard'])->middleware(['auth', 'XSS']);
Route::get('taskboard-view',['as' => 'project.taskboard.view','uses' => 'ProjectTaskController@taskboardView'])->middleware(['auth', 'XSS']);
Route::get('/calendar/{id}/show',['as' => 'task.calendar.show','uses' =>'ProjectTaskController@calendarShow'])->middleware(['auth','XSS']);
Route::post('/calendar/{id}/drag',['as' => 'task.calendar.drag','uses' =>'ProjectTaskController@calendarDrag']);
Route::get('calendar/{task}/{pid?}',['as' => 'task.calendar','uses' => 'ProjectTaskController@calendarView'])->middleware(['auth', 'XSS']);

Route::post('project/task/timer', ['as'=>'project.task.timer','uses'=>'ProjectTaskController@taskStart'])->middleware(['auth', 'XSS']);

// End Task Module

// Project Expense Module
Route::get('/projects/{id}/expense',['as' => 'projects.expenses.index','uses' =>'ExpenseController@index'])->middleware(['auth','XSS']);
Route::get('/projects/{pid}/expense/create',['as' => 'projects.expenses.create','uses' =>'ExpenseController@create'])->middleware(['auth','XSS']);
Route::post('/projects/{pid}/expense/store',['as' => 'projects.expenses.store','uses' =>'ExpenseController@store'])->middleware(['auth','XSS']);
Route::get('/projects/{id}/expense/{eid}/edit',['as' => 'projects.expenses.edit','uses' =>'ExpenseController@edit'])->middleware(['auth','XSS']);
Route::post('/projects/{id}/expense/{eid}',['as' => 'projects.expenses.update','uses' =>'ExpenseController@update'])->middleware(['auth','XSS']);
Route::delete('/projects/{eid}/expense/',['as' => 'projects.expenses.destroy','uses' =>'ExpenseController@destroy'])->middleware(['auth','XSS']);
Route::get('/expense-list',['as' => 'expense.list','uses' => 'ExpenseController@expenseList'])->middleware(['auth', 'XSS']);

// Project Timesheet
Route::get('append-timesheet-task-html', 'TimesheetController@appendTimesheetTaskHTML')->name('append.timesheet.task.html')->middleware(['auth', 'XSS']);
Route::get('timesheet-table-view', 'TimesheetController@filterTimesheetTableView')->name('filter.timesheet.table.view')->middleware(['auth', 'XSS']);
Route::get('timesheet-view', 'TimesheetController@filterTimesheetView')->name('filter.timesheet.view')->middleware(['auth', 'XSS']);
Route::get('timesheet-list', 'TimesheetController@timesheetList')->name('timesheet.list')->middleware(['auth', 'XSS']);
Route::get('timesheet-list-get', 'TimesheetController@timesheetListGet')->name('timesheet.list.get')->middleware(['auth', 'XSS']);

Route::get('/project/{id}/timesheet',['as' => 'timesheet.index','uses' =>'TimesheetController@timesheetView'])->middleware(['auth','XSS']);
Route::get('/project/{id}/timesheet/create',['as' => 'timesheet.create','uses' =>'TimesheetController@timesheetCreate'])->middleware(['auth','XSS']);
Route::post('/project/timesheet',['as' => 'timesheet.store','uses' =>'TimesheetController@timesheetStore'])->middleware(['auth','XSS']);
Route::get('/project/timesheet/{project_id}/edit/{timesheet_id}',['as' => 'timesheet.edit','uses' =>'TimesheetController@timesheetEdit'])->middleware(['auth','XSS']);
Route::post('/project/timesheet/update/{timesheet_id}',['as' => 'timesheet.update','uses' =>'TimesheetController@timesheetUpdate'])->middleware(['auth','XSS']);
Route::delete('/project/timesheet/{timesheet_id}',['as' => 'timesheet.destroy','uses' =>'TimesheetController@timesheetDestroy'])->middleware(['auth','XSS']);

// User_Todo Module
Route::post('/todo/create',['as' => 'todo.store','uses' =>'UserController@todo_store'])->middleware(['auth','XSS']);
Route::post('/todo/{id}/update',['as' => 'todo.update','uses' =>'UserController@todo_update'])->middleware(['auth','XSS']);
Route::delete('/todo/{id}',['as' => 'todo.destroy','uses' =>'UserController@todo_destroy'])->middleware(['auth','XSS']);
Route::get('/change/mode',['as' => 'change.mode','uses' =>'UserController@changeMode']);


// Site Setting
Route::get('/settings',['as' => 'settings','uses' =>'SettingsController@index'])->middleware(['auth','XSS']);
Route::post('/settings',['as' => 'settings.store','uses' =>'SettingsController@store'])->middleware(['auth','XSS']);

// Send Test Email
Route::POST('/emailCheck',['as' => 'test.email','uses' =>'SettingsController@testEmail'])->middleware(['auth','XSS']);
Route::post('/emailCheck/send',['as' => 'test.email.send','uses' =>'SettingsController@testEmailSend'])->middleware(['auth','XSS']);

// Email Templates
Route::get('email_template_lang/{id}/{lang?}', 'EmailTemplateController@manageEmailLang')->name('manage.email.language')->middleware(['auth']);
Route::post('email_template_store/{pid}', 'EmailTemplateController@storeEmailLang')->name('store.email.language')->middleware(['auth']);
Route::post('email_template_status/{id}/{pid}', 'EmailTemplateController@updateStatus')->name('status.email.language')->middleware(['auth']);

Route::get('email_template','EmailTemplateController@index')->name('email_template.index')->middleware(['auth']);
/*Route::get('email_template/create','EmailTemplateController@create')->name('email_template.create')->middleware(['auth']);*/
Route::post('email_template','EmailTemplateController@store')->name('email_template.store')->middleware(['auth']);
Route::post('email_template/update/{id}','EmailTemplateController@update')->name('email_template.update')->middleware(['auth']);
// End Email Templates

// Invoice Module
Route::resource('invoices', 'InvoiceController')->middleware(['auth','XSS']);
Route::post('/project/invoice',['as' => 'project.client.json','uses' =>'InvoiceController@jsonClient'])->middleware(['auth','XSS']);

// Invoice Item
Route::get('invoices/{id}/products', 'InvoiceController@productAdd')->name('invoices.products.add')->middleware(['auth','XSS']);
Route::post('invoices/{id}/products', 'InvoiceController@productStore')->name('invoices.products.store')->middleware(['auth','XSS']);
Route::delete('invoices/{id}/products/{pid}', 'InvoiceController@productDelete')->name('invoices.products.delete')->middleware(['auth','XSS']);

// Invoice Payment
Route::get('invoices-payments', 'InvoiceController@payments')->name('invoices.payments')->middleware(['auth','XSS']);
Route::get('invoices/{id}/payments', 'InvoiceController@paymentAdd')->name('invoices.payments.create')->middleware(['auth','XSS']);
Route::post('invoices/{id}/payments', 'InvoiceController@paymentStore')->name('invoices.payments.store')->middleware(['auth','XSS']);

//Client Invoice Payment
Route::post('/invoices/client/{id}/payment',['as' => 'client.invoice.payment','uses' =>'InvoiceController@addPayment'])->middleware(['auth', 'XSS']);
Route::post('/{id}/pay-with-paypal',['as' => 'client.pay.with.paypal','uses' =>'PaypalController@clientPayWithPaypal'])->middleware(['auth','XSS']);
Route::get('/{id}//get-payment-status',['as' => 'client.get.payment.status','uses' =>'PaypalController@clientGetPaymentStatus'])->middleware(['auth','XSS']);

// end invoice module

// Invoice Mail Send
Route::get('invoices/{id}/get_invoice', 'InvoiceController@printInvoice')->name('get.invoice')->middleware(['XSS']);
Route::get('invoice/{id}/payment/reminder', 'InvoiceController@paymentReminder')->name('invoice.payment.reminder');
Route::get('invoice/{id}/sent', 'InvoiceController@sent')->name('invoice.sent');

// Client Side Invoice Mail Send
Route::get('invoice/{id}/custom-send', 'InvoiceController@customMail')->name('invoice.custom.send')->middleware(['auth','XSS']);
Route::post('invoice/{id}/custom-mail', 'InvoiceController@customMailSend')->name('invoice.custom.mail')->middleware(['auth','XSS']);


// Invoice Template
Route::get('template/invoice',['as'=>'invoice.template.setting','uses'=>'InvoiceController@templateSetting'])->middleware(['auth','XSS']);
Route::post('/invoice-setting',['as' => 'invoice.template.store','uses' =>'InvoiceController@saveTemplateSettings'])->middleware(['auth','XSS']);
Route::get('/invoices/preview/{template}/{color}',['as' => 'invoice.preview','uses' =>'InvoiceController@previewInvoice']);


// Tax Module
Route::resource('taxes', 'TaxController')->middleware(['auth','XSS']);
// end tax


//================================= Invoice Payment Gateways  ====================================//

Route::post('/invoice-pay-with-paystack',['as' => 'invoice.pay.with.paystack','uses' =>'PaystackPaymentController@invoicePayWithPaystack'])->middleware(['auth','XSS']);
Route::get('/invoice/paystack/{pay_id}/{invoice_id}', ['as' => 'invoice.paystack','uses' => 'PaystackPaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-flaterwave',['as' => 'invoice.pay.with.flaterwave','uses' =>'FlutterwavePaymentController@invoicePayWithFlutterwave'])->middleware(['auth','XSS']);
Route::get('/invoice/flaterwave/{txref}/{invoice_id}', ['as' => 'invoice.flaterwave','uses' => 'FlutterwavePaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-razorpay',['as' => 'invoice.pay.with.razorpay','uses' =>'RazorpayPaymentController@invoicePayWithRazorpay'])->middleware(['auth','XSS']);
Route::get('/invoice/razorpay/{txref}/{invoice_id}', ['as' => 'invoice.razorpay','uses' => 'RazorpayPaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-paytm',['as' => 'invoice.pay.with.paytm','uses' =>'PaytmPaymentController@invoicePayWithPaytm'])->middleware(['auth','XSS']);
Route::post('/invoice/paytm/{invoice}', ['as' => 'invoice.paytm','uses' => 'PaytmPaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-mercado',['as' => 'invoice.pay.with.mercado','uses' =>'MercadoPaymentController@invoicePayWithMercado'])->middleware(['auth','XSS']);
Route::any('/invoice/mercado/{invoice}', ['as' => 'invoice.mercado.callback','uses' => 'MercadoPaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-mollie',['as' => 'invoice.pay.with.mollie','uses' =>'MolliePaymentController@invoicePayWithMollie'])->middleware(['auth','XSS']);
Route::get('/invoice/mollie/{invoice}', ['as' => 'invoice.mollie','uses' => 'MolliePaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-skrill',['as' => 'invoice.pay.with.skrill','uses' =>'SkrillPaymentController@invoicePayWithSkrill'])->middleware(['auth','XSS']);
Route::get('/invoice/skrill/{invoice}', ['as' => 'invoice.skrill','uses' => 'SkrillPaymentController@getInvoicePaymentStatus']);

Route::post('/invoice-pay-with-coingate',['as' => 'invoice.pay.with.coingate','uses' =>'CoingatePaymentController@invoicePayWithCoingate'])->middleware(['auth','XSS']);
Route::get('/invoice/coingate/{invoice}', ['as' => 'invoice.coingate','uses' => 'CoingatePaymentController@getInvoicePaymentStatus']);

Route::post('/paymentwall' , ['as' => 'invoice.paymentwallpayment','uses' =>'PaymentWallPaymentController@invoicepaymentwall'])->middleware(['XSS']);
Route::post('/invoice-pay-with-paymentwall/{plan}',['as' => 'invoice.pay.with.paymentwall','uses' =>'PaymentWallPaymentController@invoicePayWithPaymentwall'])->middleware(['XSS']);
Route::get('/invoices/{flag}/{invoice}', ['as' => 'error.invoice.show','uses' => 'PaymentWallPaymentController@invoiceerror']);

//================================= End Invoice Payment Gateways  ====================================//


Route::get(
    '/invoices/pay/{id}', [
        'as' => 'pay.invoice',
        'uses' => 'InvoiceController@pay',
    ]
);

Route::get('invoices/pay/pdf/{id}', 'InvoiceController@pdffrominvoice')->name('invoice.download.pdf');

Route::post('/invoice-pay-with-stripe',['as' => 'invoice.pay.with.stripe','uses' =>'StripePaymentController@invoicePayWithStripe']);


//===========================================Import-Exort=================================================//

Route::get('export/project', 'ProjectController@export')->name('project.export');
Route::get('import/project/file', 'ProjectController@importFile')->name('project.file.import');
Route::post('import/project', 'ProjectController@import')->name('project.import');

Route::get('export/members', 'UserController@export')->name('members.export');
Route::get('import/members/file', 'UserController@importFile')->name('members.file.import');
Route::post('import/members', 'UserController@import')->name('members.import');


Route::get('import/invoice/file', 'InvoiceController@importFile')->name('invoice.file.import');
Route::post('import/invoice', 'InvoiceController@import')->name('invoice.import');

//===========================================screenshort=========================================//
Route::delete('tracker/{tid}/destroy', 'TimeTrackerController@Destroy')->name('tracker.destroy');
Route::get('time-tracker','TimeTrackerController@index')->name('time.tracker')->middleware(['auth','XSS']);
Route::get('projects/{id}/time-tracker','TimeTrackerController@projectTracks')->name('projects.time.tracker')->middleware(['auth','XSS']);
Route::post('tracker/image-view', ['as' => 'tracker.image.view','uses' => 'TimeTrackerController@getTrackerImages']);
Route::delete('tracker/image-remove', ['as' => 'tracker.image.remove','uses' => 'TimeTrackerController@removeTrackerImages']);

//===========================================ZoomMeeting=============================================//
Route::any('/setting/saveZoomSettings', ['as' => 'setting.ZoomSettings','uses' => 'SettingsController@saveZoomSettings'])->middleware(['auth','XSS']);

Route::get('zoommeeting/calendar', 'ZoomMeetingController@calendar')->name('zoommeeting.calendar');
// Route::get('/zoom/project/select/{id}', 'ZoomMeetingController@projectwiseuser')->name('zoom.project.select');
 Route::get('/zoom/projects/select/{id}', 'ZoomMeetingController@projectwiseclient')->name('zoom.projects.select');
Route::resource('zoommeeting', 'ZoomMeetingController')->middleware(['auth','XSS']);

//=======================================Slack Notification============================================//
Route::post('setting/slack','SettingsController@slack')->name('slack.setting');

//=======================================Telegram Notification============================================//
Route::post('setting/Telegram','SettingsController@telegram')->name('telegram.setting');

//==================================Recaptcha================================//
Route::post('/recaptcha-settings',['as' => 'recaptcha.settings.store','uses' =>'SettingsController@recaptchaSettingStore'])->middleware(['auth','XSS']);
