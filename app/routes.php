<?php
ob_end_clean();
ob_start();

### Routes for Dashboard related URL's start ###
Route::any('/', 'HomeController@home'); // 'HomeController@index')

/* =========== Outer Routes Start =============== */
Route::get('/contact', 'ContactController@index');
Route::get('/email_test', 'EmailTestController@index');
/* =========== Outer Routes End =============== */

/* =========== Cron Job Start =============== */
Route::get('/jobs_email_client', 'CronJobController@jobs_email_client');
Route::get('/jobs-send-bookkeeping', 'CronJobController@send_bookkeeping_to_task');
Route::get('/jobs/send-vat-totask', 'CronJobController@send_vat_totask');
Route::any('/checklist/auto-email-send', 'CronJobController@auto_email_send');
/* =========== Cron Job End =============== */

Route::get('/dashboard', array('before' => 'valid_user', 'uses' => 'HomeController@dashboard'));

Route::get('/db_connect', 'HomeController@db_connect');
Route::any('/organisation-clients',array('as'=>'organisation-clients','uses'=>'HomeController@organisation_clients' ));
Route::any('/orgunicorporated', 'HomeController@orgunicorporated');
Route::get('/orgpdf', 'HomeController@orgpdf');

Route::any('/orgpdf/{search}/{type}', 'HomeController@orgpdf');


Route::get('/download_orgexcel', 'HomeController@download_orgexcel');

Route::any('/client/onboard-client', 'ClientController@onboard_client');
Route::any('/client/indonboard-client', 'ClientController@indonboard_client');

Route::any('/client/onboardsnotes', 'ClientController@onboardsnotes');
Route::any('/client/indonboardsnotes', 'ClientController@indonboardsnotes');
Route::any('/onboardsave-made-up-date', 'ClientController@onboardsave');
Route::any('/indonboardsave-made-up-date', 'ClientController@indonboardsave');

Route::any('/client/getonboardsnotes', 'ClientController@getonboardsnotes');


Route::any('/client/indgetonboardsnotes', 'ClientController@indgetonboardsnotes');

Route::any('/client/add-checklist', 'ClientController@add_checklist');
Route::any('/client/indadd-checklist', 'ClientController@indadd_checklist');
Route::any('/delete-checklist-type', 'ClientController@delete_checklist');
Route::any('/client/getowner', 'ClientController@getowner');
Route::any('/client/indgetowner', 'ClientController@indgetowner');
Route::any('/client/ajax-get-store-data', 'ClientController@ajax_get_store_data');
Route::any('/client/store-data-action', 'ClientController@store_data_action');
Route::any('/client/action', 'ClientController@action');


Route::any('/individual-clients', array('as' => 'individual-clients', 'uses' => 'HomeController@individual_clients' ));
Route::any('/indpdf/{search}/{type}', 'HomeController@indpdf');

Route::get('/indeditclientpdf/{cid}', 'ClientController@indeditclientpdf');
Route::get('/orgeditclientpdf/{cid}', 'ClientController@orgeditclientpdf');
Route::get('/indexcel', 'HomeController@indexcel');



Route::any('/individual/add-client', array("as"=>"add_individual_client", "uses"=>'HomeController@add_individual_client'));
Route::post('/individual/insert-client-details', array("as"=>"insert_individual_client", "uses"=>'HomeController@insert_individual_client'));
Route::any('/individual/get-office-address', array("as"=>"get_office_address", "uses"=>'HomeController@get_office_address'));
Route::any('/individual/save-relationship', array("as"=>"save_relationship", "uses"=>'HomeController@save_relationship'));
Route::any('/individual/save-userdefined-field', array("as"=>"save_userdefined_field", "uses"=>'HomeController@save_userdefined_field'));
Route::any('/individual/show-new-tables', array("as"=>"show_new_table", "uses"=>'HomeController@show_new_table'));
Route::any('/individual/search-individual-client', array("as"=>"search_individual_client", "uses"=>'HomeController@search_individual_client'));


Route::any('/organisation/add-client', array("as"=>"add_organisation_client", "uses"=>'HomeController@add_organisation_client'));
Route::any('/organisation/save-services', array("as"=>"save_services", "uses"=>'HomeController@save_services'));

Route::any('/organisation/insert-client-details', array("as"=>"insert_organisation_client", "uses"=>'HomeController@insert_organisation_client'));

Route::any('/search/search-client', array("as"=>"search_client", "uses"=>'HomeController@search_client'));
Route::any('/search/search-all-client', array("as"=>"search_all_client", "uses"=>'HomeController@search_all_client'));
### Routes for Dashboard related URL's end ###

### Routes for practice details related URL's start ###
Route::get('/practice-details', 'PracticeDetailsController@index');
Route::post('/insertPracticeDetails', 'PracticeDetailsController@insertPracticeDetails');
Route::post('/ajaxSearchByCity', 'PracticeDetailsController@ajaxSearchByCity');
Route::post('/ajaxSearchGetState', 'PracticeDetailsController@ajaxSearchGetState');
Route::get('/php_info', 'PracticeDetailsController@php_info');
Route::any('/downloadExel', array("as"=>"download/downloadExel", "uses"=>'PracticeDetailsController@downloadExel'));
Route::any('/download/downloadPdf',array("as"=>"downloadPdf","uses"=>'PracticeDetailsController@downloadPdf'));
Route::any('/practice/delete-practice-logo', array("as"=>"delete_practice_logo", "uses"=>'PracticeDetailsController@delete_practice_logo'));
### Routes for practice details related URL's end ###

### Routes for user related URL's start ###
Route::post('/user_process', 'UserController@user_process');
Route::get('/user-list', 'UserController@user_list');
Route::get('/add-user', 'UserController@add_user');
Route::any('/getmailid', 'UserController@getmailid'); 
Route::any('/user/invited-user-action', 'UserController@getInvitedClientAction');
Route::any('/user/get-all-staff-details', 'UserController@getAllStaffDetails');


Route::get('/send_mail', 'UserController@send_mail');
Route::any('/delete-users', array("as"=>"user/delete-users", "uses"=>'UserController@delete_users'));
Route::get('/edit-user/{id}', 'UserController@edit_user');
Route::post('/save-edit', 'UserController@saveedit');
Route::get('/pdf', 'UserController@pdf');

Route::any('/download/downloadExcel', array("as"=>"user/download_excel", "uses"=>'UserController@download_excel'));
Route::any('/user/create-password/{id}', array("as"=>"create_user_password", "uses"=>'UserController@create_user_password'));
Route::any('/create-password-process', array("as"=>"create_new_password", "uses"=>'UserController@create_new_password'));
Route::any('/update-status', array("as"=>"update_status", "uses"=>'UserController@update_status'));
Route::any('/user/get-relation-client/{id}', array("as"=>"get_relation_client", "uses"=>'UserController@get_relation_client'));
Route::any('/user/delete-user-client', array("as"=>"delete_user_client", "uses"=>'UserController@delete_user_client'));
Route::any('/user/update-related-company-status', array("as"=>"update_related_company_status", "uses"=>'UserController@update_related_company_status'));




### Routes for user related URL's end ###


### Routes for Email Settings related URL's start ###
Route::any('/email-settings', array("as"=>"email_settings/index", "uses"=>'EmailSettingsController@index'));

Route::any('/template/edit_template', array("as"=>"show_edit_template", "uses"=>'EmailSettingsController@show_edit_template'));
Route::any('/template/get_template', array("as"=>"get_template", "uses"=>'EmailSettingsController@get_template'));
Route::any('/template/add_template', array("as"=>"add_email_template", "uses"=>'EmailSettingsController@add_email_template'));
Route::any('/template/delete-email-template', array("as"=>"delete_email_template", "uses"=>'EmailSettingsController@delete_email_template'));
Route::any('/template/delete-attach-file', array("as"=>"delete_attach_file", "uses"=>'EmailSettingsController@delete_attach_file'));
Route::any('/template/edit-email-template', array("as"=>"edit_email_template", "uses"=>'EmailSettingsController@edit_email_template'));
Route::any('/template/get-edit-template-type', array("as"=>"get_edit_template_type", "uses"=>'EmailSettingsController@get_edit_template_type'));
### Routes for Email Settings related URL's end ###

### Routes for Email Tempalate related URL's start ###

Route::get('/email/template/getdetails/{id}', 'EmailTemplateController@getTemplate');
Route::get('/email/template', 'EmailTemplateController@index');
Route::get('/email/template/add/{copyId?}', 'EmailTemplateController@add');
Route::post('/email/template/add', 'EmailTemplateController@add');
Route::get('/email/template/edit/{id}', 'EmailTemplateController@edit');
Route::post('/email/template/edit', 'EmailTemplateController@edit');
Route::get('/email/template/delete/{id}', 'EmailTemplateController@delete');

Route::get('/email/template/getByType/{id}/{format}', 'EmailTemplateController@getTemplatesByID');

Route::get('/ses', 'EmailTemplateController@ses');
Route::get('/test', 'EmailTemplateController@placeholdersKV');
Route::any('/template/email-templates-action',  'EmailTemplateController@email_templates_action');

### Routes for Email Tempalate related URL's end ###


### Routes for Email Tempalate Types related URL's start ###

Route::get('/template/type/new', 'TemplateTypeController@newType');
Route::get('/template/type/add', 'TemplateTypeController@add');

### Routes for Email Tempalate Types related URL's start ###
	

### Routes for Placeholders related URL's start ###

Route::get('/placeholders', 'PlaceHoldersController@index');
Route::get('/placeholder/{id}', 'PlaceHoldersController@getDetails');
Route::post('/placeholder/add', 'PlaceHoldersController@add');
Route::get('/placeholder/by-module/{module}', 'PlaceHoldersController@byModule');
Route::get('/placeholder/delete/{id}', 'PlaceHoldersController@delete');
Route::get('/table/fields/{table}', 'PlaceHoldersController@getTableFields');

Route::get('/placeholders/sync', 'PlaceHoldersController@syncAllTable2Placeholders');

### Routes for Placeholders related URL's start ###
	
	
### Routes for Settings related URL's start ###
Route::any('/settings-dashboard', array('as' => 'settings-dashboard', 'uses' => 'SettingsController@index' ));
Route::any('/client-list-allocation/{service_id}/{client_type}',  'ClientListAllocationController@index');
Route::any('/search-allocation-clients',  'ClientListAllocationController@search_allocation_clients');
Route::any('/save-bulk-allocation',  'ClientListAllocationController@save_bulk_allocation');
Route::any('/save-manual-staff',  'ClientListAllocationController@save_manual_staff');
Route::any('/allocationClientsByService',  'ClientListAllocationController@allocationClientsByService');
Route::any('/pdfclistallocation/{service_id}/{client_type}',  'ClientListAllocationController@pdfclistallocation');
Route::any('/excelclistallocation/{service_id}/{client_type}',  'ClientListAllocationController@excelclistallocation');

Route::any('/allocation/get-client-allocation', 'ClientListAllocationController@get_client_allocation');
Route::any('/save-client-allocation',  'ClientListAllocationController@save_client_allocation');
Route::any('/save-bulk-client-allocation','ClientListAllocationController@save_bulk_client_allocation');
Route::any('/cla/action',  'ClientListAllocationController@action');

### Routes for registration URL's start ###
Route::get('/admin-signup', 'AdminController@signup');
Route::post('/signup-process', 'AdminController@signup_process');
Route::get('/login', 'AdminController@login');
Route::post('/login-process', 'AdminController@login_process');
Route::get('/admin-logout', 'AdminController@logout');
Route::get('/forgot-password', 'AdminController@forgot_password');
Route::post('/password-send', 'AdminController@password_send');
Route::get('/admin-profile', 'AdminController@adminprofile');
Route::get('/change-password', 'AdminController@change_password');
Route::post('/new-pass', 'AdminController@new_pass');
Route::get('/profile-edit', 'AdminController@profile_edit');
Route::post('/profile-update', 'AdminController@profile_update');
Route::any('/admin/activation/{id}', array("as"=>"activation", "uses"=>'AdminController@activation'));
Route::any('/file-and-sign/login', 'AdminController@login');
Route::any('/admin/invited-login/{id}', array("as"=>"invited_login", "uses"=>'AdminController@invited_login'));

### Routes for Client URL's start ###
Route::any('/individual/get-country-code', array("as"=>"get_country_code", "uses"=>'ClientController@get_country_code'));
Route::any('/individual/delete-user-field', array("as"=>"delete_user_field", "uses"=>'ClientController@delete_user_field'));
Route::any('/delete-individual-clients', array("as"=>"delete_individual_client", "uses"=>'ClientController@delete_individual_client'));
Route::any('/client/search-tax-address', array("as"=>"search_tax_address", "uses"=>'ClientController@search_tax_address'));
Route::any('/client/add-business-type', array("as"=>"add_business_type", "uses"=>'ClientController@add_business_type'));
Route::any('/client/delete-org-name', array("as"=>"delete_org_name", "uses"=>'ClientController@delete_org_name'));
Route::any('/client/add-vat-scheme', array("as"=>"add_vat_scheme", "uses"=>'ClientController@add_vat_scheme'));
Route::any('/client/delete-vat-scheme', array("as"=>"delete_vat_scheme", "uses"=>'ClientController@delete_vat_scheme'));
Route::any('/client/get-oldcont-address', array("as"=>"get_oldcont_address", "uses"=>'ClientController@get_oldcont_address'));
Route::any('/client/get-orgoldcont-address', array("as"=>"get_orgoldcont_address", "uses"=>'ClientController@get_orgoldcont_address'));
Route::any('/client/add-services', array("as"=>"add_services", "uses"=>'ClientController@add_services'));
Route::any('/client/delete-services', array("as"=>"delete_services", "uses"=>'ClientController@delete_services'));
Route::any('/client/insert-section', array("as"=>"insert_section", "uses"=>'ClientController@insert_section'));
Route::any('/client/delete-section', array("as"=>"delete_section", "uses"=>'ClientController@delete_section'));
Route::any('/client/get-subsection', array("as"=>"get_subsection", "uses"=>'ClientController@get_subsection'));
Route::any('/client/edit-org-client/{id}/{type}', array("as"=>"edit_org_client", "uses"=>'ClientController@edit_org_client'));

Route::any('/client/edit-ind-client/{id}/{type}', array("as"=>"edit_ind_client", "uses"=>'ClientController@edit_ind_client'));


Route::any('/client/delete-client-service', array("as"=>"delete_client_services", "uses"=>'ClientController@delete_client_services'));

Route::any('/client/save-client', array("as"=>"save_client", "uses"=>'ClientController@save_client'));
Route::any('/client/archive-client', array("as"=>"archive_client", "uses"=>'ClientController@archive_client')); 
Route::any('/client/show-archive-client', array("as"=>"show_archive_client", "uses"=>'ClientController@show_archive_client'));
Route::any('/client/edit-relation-type', array("as"=>"edit_relation_type", "uses"=>'ClientController@edit_relation_type'));
Route::any('/client/delete-relationship', array("as"=>"delete_relationship", "uses"=>'ClientController@delete_relationship'));
Route::any('/client/save-database-relationship', array("as"=>"save_database_relationship", "uses"=>'ClientController@save_database_relationship'));
Route::any('/client/save-acting-relationship', array("as"=>"save_acting_relationship", "uses"=>'ClientController@save_acting_relationship'));
Route::any('/client/get-corporation-address', array("as"=>"get_corporation_address", "uses"=>'ClientController@get_corporation_address'));
Route::any('/client/acting-relationship', array("as"=>"acting_relationship", "uses"=>'ClientController@acting_relationship'));
Route::any('/client/add-to-client', array("as"=>"add_to_client", "uses"=>'ClientController@add_to_client'));
Route::any('/client/delete-acting', array("as"=>"delete_acting", "uses"=>'ClientController@delete_acting'));
Route::any('/client/save-database-acting', array("as"=>"save_database_acting", "uses"=>'ClientController@save_database_acting'));
Route::any('/client/get-name-and-type', array("as"=>"get_name_and_type", "uses"=>'ClientController@get_name_and_type'));
Route::any('/client/delete-addtolist-client', array("as"=>"delete_addtolist_client", "uses"=>'ClientController@delete_addtolist_client'));
Route::any('/client/save-officers-into-relation', array("as"=>"save_officers_into_relation", "uses"=>'ClientController@save_officers_into_relation'));
Route::any('/client/get-officers-client', array("as"=>"get_officers_client", "uses"=>'ClientController@get_officers_client'));
Route::any('/client/client-details-by-client_id/{client_id}', array("as"=>"client_details_by_client_id", "uses"=>'ClientController@client_details_by_client_id'));
Route::any('/client/delete-files', array("as"=>"delete_files", "uses"=>'ClientController@delete_files'));
Route::any('/client/upload-other-files', array("as"=>"upload_other_files", "uses"=>'ClientController@upload_other_files'));
Route::any('/client/ajax-client-details', array("as"=>"ajax_client_details", "uses"=>'ClientController@ajax_client_details'));
Route::any('/client/all-org-clients', 'ClientController@all_org_clients');
Route::any('/client/open-message-pop', 'ClientController@open_message_pop');
Route::any('/client/invite-client-action', 'ClientController@invite_client_action');
Route::any('/client/save-client-address', 'ClientController@save_client_address');

Route::any('/client/delete-client-address', 'ClientController@delete_client_address');
Route::any('/client/gat-client-address-by-id', 'ClientController@gat_client_address_by_id');
Route::any('/client/ajax-chlogin-details', 'ClientController@ajax_chlogin_details');


### Routes for Client URL's end ###

Route::any('/chdata/index', array("as"=>"index", "uses"=>'ChdataController@index'));

Route::get('/chdatapdf', 'ChdataController@chdatapdf');
Route::get('/chdataexcel', 'ChdataController@chdataexcel');

Route::any('/chdata-details/{number}', 'ChdataController@chdata_details');
Route::get('/chadtadetailspdf/{number}', 'ChdataController@chadtadetailspdf');
Route::get('/chadtadetailsexcel/{number}', 'ChdataController@chadtadetailsexcel');
Route::any('/chdata/autologin/{number}/{auth_code}', 'ChdataController@autologin');
Route::any('/chdata/remotecall/{u1}/{p1}', 'ChdataController@remotecall');



Route::any('/officers-details', 'ChdataController@officers_details');
Route::any('/import-from-ch/{back_url}', 'ChdataController@import_from_ch');
Route::any('/company-search', 'ChdataController@search_company');
Route::any('/company-details', 'ChdataController@company_details');
Route::any('/import-company-details/{number}', 'ChdataController@import_company_details');
Route::any('/goto-edit-client', 'ChdataController@goto_edit_client');
Route::any('/chdata/get-shareholders-client','ChdataController@get_shareholders_client');
Route::any('/chdata/bulk-company-upload-page/{url}', 'ChdataController@bulk_company_upload_page');
Route::any('/chdata/bulk-file-upload', 'ChdataController@bulk_file_upload');

Route::any('/xls_to_array', 'ChdataController@xls_to_array');

Route::any('/chdata/manage-tasks', 'ChdataController@manage_tasks');
Route::post('/chdata/save-edit-status', 'ChdataController@save_edit_status');
Route::post('/chdata/send-manage-task', 'ChdataController@send_manage_task');
Route::post('/chdata/delete-manage-task', 'ChdataController@delete_manage_task');
Route::post('/chdata/change-job-status', 'ChdataController@change_job_status');
Route::post('/chdata/delete-single-task', 'ChdataController@delete_single_task');
Route::post('/chdata/send-global-task', 'ChdataController@send_global_task');
## Company House Data End ##


##Invitedclient
Route::get('/client-portal', 'InvitedclientController@Invitedclient_dashboard');
Route::get('/invitedclient-details', 'InvitedclientController@my_details');
Route::post('/invitedclient/insert-client-details', 'InvitedclientController@insert_invitedclient_client');
Route::get('/invitedclient-relationship', 'InvitedclientController@relationship');
Route::post('/relationship/insert-client-relationship', array("as"=>"insert_relationship_client", "uses"=>'InvitedclientController@insert_relationship_client'));
Route::get('/search-invited-client', 'InvitedclientController@search_invited_client');
Route::any('/tsxreturninfromation/{id}/{type}/{page_open}/{tax_year}', 'InvitedclientController@tsxreturninfromation');
Route::any('/pdfclientupload', 'InvitedclientController@pdfclientupload');
Route::any('/pdfclientdelete', 'InvitedclientController@pdfclientdelete');
Route::any('/notessave', 'InvitedclientController@notessave');
Route::any('/ic/ajax-client-details', 'InvitedclientController@ajax_client_details');
Route::any('/ic/get-taxreturn-details', 'InvitedclientController@get_taxreturn_details');
Route::any('/ic/update-checklist', 'InvitedclientController@update_checklist');
Route::any('/ic/save-messages', 'InvitedclientController@save_messages');
Route::any('/ic/action-messages', 'InvitedclientController@action_messages');


Route::any('/delete-contact-report', 'SiteManagerController@delete_contact_report');
Route::any('/get-contact-report', 'SiteManagerController@get_contact_report');

##Invitedclient


##
Route::any('/organisation/editserv-services', array("as"=>"edit_services", "uses"=>'HomeController@edit_services'));
Route::any('/organisation/delete-editservices', array("as"=>"delete_editservices",  "uses"=>'ClientController@delete_editservices'));


##

//Route::any('/noticeboard/{page_open}', array("as"=>"notice_board", "uses"=>'NoticeboardController@notice_board'));
Route::any('/noticeboard/{page_open}', 'NoticeboardController@notice_board');

Route::any('/index_template', array("as"=>"index_template", "uses"=>'NoticeboardController@index_template'));
Route::get('/edit-template/{id}', 'NoticeboardController@edit_template');
Route::get('/delete-template/{id}', 'NoticeboardController@delete_template');
Route::any('/swap-board1', 'NoticeboardController@swap_board1');
Route::get('/delete-attachment/{id}', 'NoticeboardController@delete_attachment');
Route::any('/editnotice-template', array("as"=>"show_edit_noticetemplate", "uses"=>'NoticeboardController@show_edit_noticetemplate'));
Route::any('/edit-notice-template', array("as"=>"edit_notice_template", "uses"=>'NoticeboardController@edit_notice_template'));
Route::any('/insert-noticeboard', array("as"=>"insert_noticeboard", "uses"=>'NoticeboardController@insert_noticeboard'));
Route::any('/notice-template',array("as"=>"notice_template","uses"=>'NoticeboardController@notice_template'));
Route::any('/excel-upload',array("as"=>"excel_upload","uses"=>'NoticeboardController@excel_upload'));
Route::any('/pdf-upload', array("as"=>"pdf_upload", "uses"=>'NoticeboardController@pdf_upload'));

Route::any('/viewfilenoticeboard', 'NoticeboardController@viewfilenoticeboard');
Route::any('/deletefilenoticeboard', 'NoticeboardController@deletefilenoticeboard');


Route::any('/staffmanagement', 'StaffmanagementController@staff_management');
Route::any('/staff-management', 'StaffmanagementController@staff_management');

Route::any('/staff-holidays/{type}/{tab_open}/{start_date}','StaffholidaysController@staff_holidays');
Route::any('/staffholidaysrequest', 'StaffholidaysController@staffholidaysrequest');
Route::any('/statechange', 'StaffholidaysController@statechange');
Route::any('/getrequestdetails', 'StaffholidaysController@getrequestdetails');
Route::any('/editstaffholidaysrequest', 'StaffholidaysController@editstaffholidaysrequest');
Route::any('/holidaypdf/{type}/{tab_open}/{filetype}', 'StaffholidaysController@holidaypdf');
Route::any('/save-holiday', 'StaffholidaysController@save_holiday');
Route::any('/save-staff-holiday', 'StaffholidaysController@save_staff_holiday');
Route::any('/sh/save-holiday-type', 'StaffholidaysController@save_holiday_type');
Route::any('/sh/delete-holiday-type', 'StaffholidaysController@delete_holiday_type');
Route::any('/sh/get-holiday-details', 'StaffholidaysController@get_holiday_details');
Route::any('/sh/get-confirm-rollover', 'StaffholidaysController@get_confirm_rollover');
Route::any('/sh/save-confirm-rollover', 'StaffholidaysController@save_confirm_rollover');
Route::any('/sh/get-staff-holiday', 'StaffholidaysController@get_staff_holiday');
Route::any('/sh/goto-rollfwd/{type}/{date}', 'StaffholidaysController@goto_rollfwd');
Route::any('/sh/search-holiday', 'StaffholidaysController@search_holiday');
Route::any('/sh/get-who-else-is-off', 'StaffholidaysController@get_who_else_is_off');
Route::any('/sh/get-check-task-deadlines', 'StaffholidaysController@get_check_task_deadlines');
Route::any('/sh/show-tasks', 'StaffholidaysController@show_tasks');

Route::any('/time-sheet-reports/{type}/{tab_no}', array("as"=>"time_sheet_reports", "uses"=>'TimesheetController@time_sheet_reports'));

Route::any('/timesheetpdf', 'TimesheetController@timesheetpdf');
Route::any('/timesheetexcel', 'TimesheetController@timesheetexcel');


Route::any('/cpd-and-courses/{type}/{page}', array("as"=>"cpd_and_courses", "uses"=>'CpdController@cpd_and_courses'));
Route::any('/insertcpd', array("as"=>"insertcpd", "uses"=>'CpdController@insertcpd'));
Route::any('/editcpd', array("as"=>"insertcpd", "uses"=>'CpdController@editcpd'));

Route::any('/getcpdnotes', 'CpdController@getcpdnotes');
Route::any('/delcourses', 'CpdController@delcourses');
Route::any('/getcourses', 'CpdController@getcourses');
Route::any('/pdfbookedcourses', 'CpdController@pdfbookedcourses');

Route::any('/excelbookedcourses', 'CpdController@excelbookedcourses');
Route::any('/cpd/add-course-name', 'CpdController@add_course_name');
Route::any('/cpd/delete-course-name', 'CpdController@delete_course_name');

Route::any('/save-details', 'ContactReportController@save_details');







Route::any('/calenderview',array("as"=>"calenderview","uses"=>'NoticeboardController@calenderview'));
Route::any('/get-calender',array("as"=>"get_calender","uses"=>'NoticeboardController@get_calender'));

/*=============== Staff Data Start =================*/
Route::any('/staff-details', array("as"=>"staff_data", "uses"=>'StaffdataController@staff_data'));
Route::any('/staff/archive-staff', 'StaffdataController@archive_staff');
Route::any('/staffpdf/{search}', 'StaffdataController@staffpdf');
Route::any('/staffexcel', 'StaffdataController@staffexcel');

Route::any('/staff/show-archive-staff', 'StaffdataController@show_archive_staff');

/*=============== Staff Data End =================*/

/*=============== Staff Profile Start =================*/
Route::get('/staff-profile', 'StaffprofileController@dashboard');
Route::get('/my-details/{user_id}/{type}', 'StaffprofileController@my_details');
Route::any('/statuschange', 'StaffprofileController@statuschange');
Route::any('/gettaskdetais', 'StaffprofileController@gettaskdetais');
Route::any('/sp/delete-profile-photo', 'StaffprofileController@delete_profile_photo');
Route::any('/sp/save-profile-photo', 'StaffprofileController@save_profile_photo');
Route::any('/sp/add-professional-body', 'StaffprofileController@add_professional_body');
Route::any('/sp/delete-professional-body', 'StaffprofileController@delete_professional_body');


Route::get('/pdfmy-details/{user_id}/{type}', 'StaffprofileController@pdfmy_details');

Route::any('/delete-stafffile', 'StaffprofileController@delete_stafffile');
Route::any('/add-position-type', array("as"=>"add_position_type", "uses"=>'StaffprofileController@add_position_type'));
Route::any('/delete-position-type', array("as"=>"delete_position_type", "uses"=>'StaffprofileController@delete_position_type'));
Route::any('/add-department-type', array("as"=>"add_department_type", "uses"=>'StaffprofileController@add_department_type'));
Route::any('/delete-department-type', array("as"=>"delete_department_type", "uses"=>'StaffprofileController@delete_department_type'));
Route::post('/staff/user-details-process', 'StaffprofileController@user_details_process');
Route::get('/profile/to-list/{page_open}', 'StaffprofileController@to_list');

Route::any('/todolistnewtask', 'StaffprofileController@todolistnewtask');
Route::any('/view-tasknotes', 'StaffprofileController@viewtasknotes');

Route::any('/deletetask/{dele_id}', 'StaffprofileController@deletetask');

Route::post('/prof-file', 'StaffprofileController@prof_file');
Route::get('/staffholidays', 'StaffprofileController@getstaffholidays');
/*=============== Staff Profile End =================*/



/*=============== Jobs Dashboard Section Start =================*/
Route::any('/jobs-dashboard', array("as"=>"dashboard", "uses"=>'JobsController@dashboard'));
Route::any('/vat-returns/{service_id}/{page_open}/{staff_id}', array("as"=>"index", "uses"=>'VatReturnsController@index'));
Route::any('/vatreturn/manage-tasks', array("as"=>"manage_tasks", "uses"=>'VatReturnsController@manage_tasks'));
Route::any('/ch-annual-return/{service_id}/{page_open}/{staff_id}','ChAnnualReturnController@index');
Route::any('/chdownload/{service_id}/{page_open}/{staff_id}/{type}','ChAnnualReturnController@chdownload');
Route::any('/jobs/send-manage-task', 'JobsController@send_manage_task');
Route::any('/jobs/update-staff-filter', 'JobsController@update_staff_filter');
Route::any('/jobs/delete-single-task', 'JobsController@delete_single_task');
Route::any('/jobs/delete-completed-task', 'JobsController@delete_completed_task');
Route::post('/jobs/change-job-status', 'JobsController@change_job_status');
Route::post('/jobs/show-jobs-notes', 'JobsController@show_jobs_notes');
Route::post('/jobs/save-jobs-notes', 'JobsController@save_jobs_notes');
Route::post('/jobs/send-global-task', 'JobsController@send_global_task');
Route::post('/jobs/save-made-up-date', 'JobsController@save_made_up_date');
Route::post('/jobs/sync-jobs-clients', 'JobsController@sync_jobs_clients');
Route::post('/jobs/save-jobs-startdate', 'JobsController@save_jobs_startdate');
Route::post('/jobs/save-start-days', 'JobsController@save_start_days');
Route::post('/jobs/save-email-client-days', 'JobsController@save_email_client_days');
Route::post('/jobs/get-all-contacts', 'JobsController@get_all_contacts');
Route::post('/jobs/save-jobs-email', 'JobsController@save_jobs_email');
Route::any('/jobs/{service_id}/{page_open}/{staff_id}', 'JobsController@index');

Route::post('/jobs/save-task-name', 'JobsController@save_task_name');
Route::post('/jobs/tasks-email', 'JobsController@tasks_email');

Route::any('/jobsdownload/{service_id}/{page_open}/{staff_id}/{type}','JobsController@jobsdownload');



Route::any('/jobs/send-job-to-task', 'JobsController@send_job_to_task');
Route::any('/jobs/get-account-details', 'JobsController@get_account_details');
Route::any('/jobs/save-account-details', 'JobsController@save_account_details');
Route::any('/jobs/get-ajax-data', 'JobsController@get_ajax_data');
Route::any('/jobs/ajax-tax-return-period', 'JobsController@ajax_tax_return_period');
Route::any('/jobs/save-bookkeeping', 'JobsController@save_bookkeeping');
Route::any('/jobs/delete-job-freq', 'JobsController@delete_job_freq');
Route::any('/jobs/ajax-vat-stagger', 'JobsController@ajax_vat_stagger');
Route::any('/jobs/send-jobs-to-task', 'JobsController@send_jobs_to_task');
Route::any('/jobs/check-already-sent', 'JobsController@check_already_sent');
Route::any('/jobs/ajax-get-taxyear', 'JobsController@ajax_get_taxyear');
Route::any('/jobs/save-taxyear', 'JobsController@save_taxyear');
Route::any('/jobs/send-audits-job', 'JobsController@send_audits_job');
Route::any('/jobs/save-taxreturn-checklist', 'JobsController@save_taxreturn_checklist');
Route::any('/jobs/ajax-taxreturn-details', 'JobsController@ajax_taxreturn_details');
Route::any('/jobs/action-taxreturn-details', 'JobsController@action_taxreturn_details');
Route::any('/jobs/get-taxreturn', 'JobsController@get_taxreturn');
Route::any('/jobs/notification-modal', 'JobsController@notification_modal');
Route::any('/jobs/delete-client-from-tasks', 'JobsController@delete_client_from_tasks');

Route::any('/jobs/ajax-tasks-table-data', 'JobsController@ajax_tasks_table_data');
Route::any('/jobs/tasks-action', 'JobsController@tasks_action');
Route::any('/jobs/save-job-account-details', 'JobsController@save_job_account_details');
/*=============== Jobs Dashboard Section End =================*/

/*=============== Staff Appraisal Section Start =================*/
Route::any('/staff-appraisal/{tab_no}/{page_open}', 'StaffAppraisalController@index');
Route::post('/getjobforappraisee', 'StaffAppraisalController@getjobforappraisee');
Route::any('/addnewtergetobject', 'StaffAppraisalController@addnewtergetobject');
Route::any('/deladdnewtergetobject', 'StaffAppraisalController@deladdnewtergetobject');
Route::any('/sm/save-appraisal', 'StaffAppraisalController@save_appraisal');
Route::any('/sm/delete-appraisal', 'StaffAppraisalController@delete_appraisal');
Route::any('/sm/get-previous-roll', 'StaffAppraisalController@get_previous_roll');
Route::any('/sm/ajax-appraisal-details', 'StaffAppraisalController@ajax_appraisal_details');
Route::any('/sm/get-appraisal-notes', 'StaffAppraisalController@get_appraisal_notes');
Route::any('/sm/save-appraisal-notes', 'StaffAppraisalController@save_appraisal_notes');
Route::any('/sm/ajax-delete-objective', 'StaffAppraisalController@ajax_delete_objective');
Route::any('/sm/save-appraisal-sign', 'StaffAppraisalController@save_appraisal_sign');

/*=============== Staff Appraisal Section End =================*/

/*==================Time Sheet Start ==============*/
Route::post('/timesheet/insert-time-sheet', array("as"=>"insert-time-sheet", "uses"=>'TimesheetController@insert_time_sheet'));
Route::post('/timesheet/timesheet-templates', array("as"=>"timesheet-templates", "uses"=>'TimesheetController@timesheet_templates'));
Route::post('/timesheet/edit-time-sheet', array("as"=>"edit-time-sheet", "uses"=>'TimesheetController@edit_time_sheet'));

Route::post('/timesheet/insertclient-time-sheet', 'TimesheetController@insertclient_time_sheet');
Route::any('/pdfclient-time-sheet/{ctr_client}/{ctr_serv}/{fromdpick2}/{todpick}', 'TimesheetController@pdfclient_time_sheet');

Route::any('/pdfclientnotstaff-time-sheet/{ctr_client}/{fromdpick2}/{todpick}', 'TimesheetController@pdfclientnotstaff_time_sheet');

Route::any('/excelclient-time-sheet/{ctr_client}/{ctr_serv}/{fromdpick2}/{todpick}', 'TimesheetController@excelclient_time_sheet');

Route::any('/excelclientnotstaff-time-sheet/{ctr_client}/{fromdpick2}/{todpick}', 'TimesheetController@excelclientnotstaff_time_sheet');


Route::any('/pdfstaffnoclient-time-sheet/{str_staff}/{fromdpick2}/{todpick}', 'TimesheetController@pdfstaffnoclient_time_sheet');
Route::any('/pdfstaff-time-sheet/{str_staff}/{str_client}/{fromdpick2}/{todpick}', 'TimesheetController@pdfstaff_time_sheet');

Route::any('/excelstaff-time-sheet/{str_staff}/{str_client}/{fromdpick2}/{todpick}', 'TimesheetController@excelstaff_time_sheet');

Route::any('/excelstaffnoclient-time-sheet/{str_staff}/{fromdpick2}/{todpick}', 'TimesheetController@excelstaffnoclient_time_sheet');



Route::post('/timesheet/insertstaff-time-sheet', 'TimesheetController@insertstaff_time_sheet');

Route::post('/timesheet/fetcheditclient-time-sheet', 'TimesheetController@editclient_time_sheet');
Route::post('/timesheet/editclient-time-report', 'TimesheetController@editclient_time_report');


Route::post('/timesheet/fetcheditstaff-time-sheet', 'TimesheetController@fetcheditstaff_time_sheet');
Route::post('/timesheet/editstaff-time-report', 'TimesheetController@editstaff_time_report');
Route::post('/timesheet/delete-time-sheet', 'TimesheetController@delete_time_report');
Route::any('/timesheet/client-timereport', 'TimesheetController@client_timereport');
Route::any('/timesheet/staff-timereport', 'TimesheetController@staff_timereport');
Route::any('/timesheet/staffdemo', 'TimesheetController@staffdemo');
Route::any('/timesheet/expense-type-action', 'TimesheetController@expense_type_action');
Route::any('/timesheet/view-timesheet-report/{page_type}/{report_type}', 'TimesheetController@view_timesheet_report');
Route::any('/timesheet/display-timesheet', 'TimesheetController@display_timesheet');

Route::any('/download-time-sheet/{client_id}/{expense_id}/{fromdate}/{todate}/{type}/{sheet_type}', 'TimesheetController@download_time_sheet');
Route::any('/timesheet/update-file', 'TimesheetController@update_file');

/*==================Time Sheet End ==============*/
 

/*==================HMRC==============*/
Route::any('/hmrc/testperson', 'HmrcController@testperson');
Route::any('getclientdetails', 'HmrcController@getclientdetails');
Route::any('getindclientdetails', 'HmrcController@getindclientdetails');
Route::any('relationbetween', 'HmrcController@relationbetween');

Route::any('/hmrc', 'HmrcController@hmrc');
Route::any('/hmrc/authorisations/{page_open}', 'HmrcController@authorisations');
//Route::get('/hmrc/authorisations/{page_open}',array('uses' =>'HmrcController@authorisations'));
Route::post('/hmrc/rsponce', array('uses' => 'HmrcController@getFormData'));
Route::any('/hmrc/emails', 'HmrcController@emails');
Route::any('/hmrc/tool', 'HmrcController@tool');
Route::any('/hmrc/taxrates', 'HmrcController@taxrates');
Route::any('/hmrcrevenue', 'HmrcController@hmrcrevenue');
Route::any('/getresponsibleperson', 'HmrcController@getresponsibleperson');
Route::get('/hmrc/technicalupdates/{button?}', 'HmrcController@technicalupdates');
Route::get('/generate-form/{client_id}', 'HmrcController@generate_form');
Route::any('/pdfload/{button}', 'HmrcController@pdfload');

/*==================HMRC ==============*/
/*================== Notes Start ==============*/
Route::any('/profile-notes', array("as"=>"index", "uses"=>'NotesController@index'));

Route::any('/staffprof-notes', 'NotesController@staffprofnotes');
Route::any('/deletestaffprof-notes', 'NotesController@deletestaffprof_notes');
Route::any('/editmodestaff-notes', 'NotesController@edit_viewstaffnotes');
Route::any('/view-staffnotes', 'NotesController@view_staffnotes');
Route::any('/editstaff-notes', 'NotesController@edit_staffnotes');


Route::any('/org-notes', 'NotesController@orgnotes');
Route::any('/view-orgnotes', 'NotesController@view_orgnotes');
Route::any('/editorg-notes', 'NotesController@edit_orgnotes');
Route::any('/deleteorg-notes', 'NotesController@deleteorg_notes');
Route::any('/editmodeorg-notes', 'NotesController@editmodeorg_notes');
/*================== Notes End ==============*/

/*================== Notes Start ==============*/
Route::any('/edit-service-id', 'ClientListAllocationController@edit_service_id');
/*================== Notes End ==============*/

/*================== Contacts Letters Emails Start ==============*/
Route::any('/contacts-letters-emails/{step_id}/{address_type}','ContactsLettersEmailsController@index');
Route::any('/massemail-settings', 'ContactsLettersEmailsController@massemail');
Route::any('/cletab1pdf', 'ContactsLettersEmailsController@cletab1pdf');
Route::get('/contacts-letters-emails/email', 'ContactsLettersEmailsController@email');
Route::any('/contacts/pagination', 'ContactsLettersEmailsController@pagination');


Route::any('/send-letters-emails', 'ContactsLettersEmailsController@send_letteremail');
Route::post('/send-letters-emails/send', 'ContactsLettersEmailsController@send_letteremail_send');
Route::post('/demo', 'ContactsLettersEmailsController@demo');
Route::get('/demo', 'ContactsLettersEmailsController@demo');

Route::any('/gettemplatename', 'ContactsLettersEmailsController@gettemplatename');

Route::post('/send-letters-emails/email-pdf-download', 'ContactsLettersEmailsController@prepare_email_pdf_download');
Route::post('/send-letters-emails/email-pdf-preview', 'ContactsLettersEmailsController@prepare_email_pdf_download');
Route::get('/send-letters-emails/generate-email/{as}', 'ContactsLettersEmailsController@generate_email');

/*================== Contacts Letters Emails End ==============*/


Route::any('/contacts/show-contacts-notes', 'ContactsLettersEmailsController@show_contacts_notes');
Route::any('/contacts/save-contacts-notes', 'ContactsLettersEmailsController@save_contacts_notes');
Route::any('/contacts/save-contacts-group', 'ContactsLettersEmailsController@save_contacts_group');
Route::any('/contacts/insert-contact-details', 'ContactsLettersEmailsController@insert_contact_details');
Route::any('/contacts/search-address', 'ContactsLettersEmailsController@search_address');
Route::any('/contacts/save-edit-group', 'ContactsLettersEmailsController@save_edit_group');
Route::any('/contacts/copy-to-group', 'ContactsLettersEmailsController@copy_to_group');
Route::any('/contacts/delete-group', 'ContactsLettersEmailsController@delete_group');
Route::any('/contacts/delete-from-group', 'ContactsLettersEmailsController@delete_from_group');
Route::any('/contacts/show-contact-group', 'ContactsLettersEmailsController@show_contact_group');
Route::any('/contacts/get-contact-details', 'ContactsLettersEmailsController@get_contact_details');
Route::any('/contacts/delete-contact-address', 'ContactsLettersEmailsController@delete_contact_address');
Route::any('/contacts/view-contact-address', 'ContactsLettersEmailsController@view_contact_address');
Route::any('/contacts/view-client-address', 'ContactsLettersEmailsController@view_client_address');


Route::any('/contacts/get-contact-org', 'ContactsLettersEmailsController@get_contact_org');
Route::any('/contacts/get-tab-details', 'ContactsLettersEmailsController@get_tab_details');
Route::any('/contacts/get-tab-others', 'ContactsLettersEmailsController@get_tab_others');


Route::any('/pdfindex/{step_id}/{address_type}', 'ContactsLettersEmailsController@pdfindex');
Route::any('/excelindex/{step_id}/{address_type}', 'ContactsLettersEmailsController@excelindex');

/*================== Contacts Letters Emails End ==============*/

Route::any('/knowledgebase', 'KnowledgeBaseController@index');

Route::any('/knowledgebase-notesinsert', 'KnowledgeBaseController@knowledgebase_notesinsert');
Route::any('/editmodekbase-notes', 'KnowledgeBaseController@editmodekbase_notes');

Route::any('/view-article', 'KnowledgeBaseController@view_article');

Route::any('/editsave-article', 'KnowledgeBaseController@editsave_article');

Route::any('/deletearticle-notes', 'KnowledgeBaseController@delete_article');
Route::any('/deletearticlefile', 'KnowledgeBaseController@deletearticlefile');


/*Route::any('/view-orgnotes', 'NotesController@view_orgnotes');
Route::any('/editorg-notes', 'NotesController@edit_orgnotes');
Route::any('/deleteorg-notes', 'NotesController@deleteorg_notes');
Route::any('/editmodeorg-notes', 'NotesController@editmodeorg_notes');
*/

/*================== CRM Start ==============*/
Route::any('/crm/{page_open}/{owner_id}/{noConflict}', 'CrmController@index');
Route::any('/crm/save-leads-data', 'CrmController@save_leads_data');
Route::any('/crm/add-new-source', 'CrmController@add_new_source');
Route::any('/crm/delete-source-name', 'CrmController@delete_source_name');
Route::any('/crm/get-form-dropdown', 'CrmController@get_form_dropdown');
Route::any('/crm/save-edit-status', 'CrmController@save_edit_status');
Route::any('/crm/delete-leads-details', 'CrmController@delete_leads_details');
Route::any('/crm/sendto-another-tab', 'CrmController@sendto_another_tab');
Route::any('/crm/get-client-address', 'CrmController@get_client_address');
Route::any('/crm/show-graph', 'CrmController@show_graph');
Route::any('/crm/graph-page', 'CrmController@graph_page');
Route::any('/crm/archive-leads','CrmController@archive_leads'); 
Route::any('/crm/show-archive-leads', 'CrmController@show_archive_leads');
Route::any('/crm/report', 'CrmController@report');
Route::any('/crm/show-leads-report', 'CrmController@show_leads_report');
Route::any('/crm/save-close-date', 'CrmController@save_close_date');
Route::any('/crm/save-new-leads', 'CrmController@save_new_leads');
Route::any('/crm/sendto-client-list', 'CrmController@sendto_client_list');
Route::any('/pdfcrm/{page_open}/{owner_id}', 'CrmController@crmpdf');

Route::any('/excelcrm/{page_open}/{owner_id}', 'CrmController@excelcrm');

Route::post('/crm/ajax-save-status', 'CrmController@ajax_save_status');
Route::post('/crm/change-renewal-status', 'CrmController@change_renewal_status');
Route::post('/crm/delete-archived-client', 'CrmController@delete_archived_client');
Route::post('/crm/invoice-by-contactid', 'CrmController@invoice_by_contactid');
Route::post('/crm/update-invoice', 'CrmController@update_invoice');
Route::post('/crm/merge-xero-clients', 'CrmController@merge_xero_clients');
Route::post('/crm/address-by-client-type', 'CrmController@address_by_client_type');
Route::post('/crm/get-auto-collect', 'CrmController@get_auto_collect');
Route::post('/crm/save-auto-collect', 'CrmController@save_auto_collect');
Route::post('/crm/check-collection-date', 'CrmController@check_collection_date');
Route::post('/crm/send-to-collect', 'CrmController@send_to_collect');
Route::post('/crm/delete-invoice', 'CrmController@delete_invoice');
Route::post('/crm/delete-todolist', 'CrmController@delete_todolist');
Route::post('/crm/action', 'CrmController@action');


Route::any('/pdfreport/{status}/{owner}/{from}/{to}/{isdeleted}/{isarchive}', 'CrmController@pdfreport');
Route::any('/excelreport/{status}/{owner}/{from}/{to}/{isdeleted}/{isarchive}', 'CrmController@excelreport');
Route::any('/xero-api', 'CrmController@xero_api');
Route::any('/page-xero-balance', 'CrmController@page_xero_balance');
/*================== CRM End ==============*/
 
/*================== CRM Renewals Start ==============*/
Route::any('/pdfdwonload/{client_id}/{client_type}/{tab_no}', 'RenewalsController@pdfdwonload');
Route::any('/renewals/{client_id}/{client_type}/{tab_no}', 'RenewalsController@index');
Route::any('/renewals/save-notes', 'RenewalsController@save_notes');
Route::any('/renewals/get-renewals-details', 'RenewalsController@get_renewals_details');
Route::any('/renewals/delete-notes', 'RenewalsController@delete_notes');
Route::any('/renewals/save-tasks', 'RenewalsController@save_tasks');
Route::any('/renewals/get-task-details', 'RenewalsController@get_task_details');
Route::any('/renewals/delete-tasks', 'RenewalsController@delete_tasks');
Route::any('/renewals/get-contact-address', 'RenewalsController@get_contact_address');
Route::any('/renewals/delete-opportunity', 'RenewalsController@delete_opportunity');
Route::any('/renewals/save-opportunity-data', 'RenewalsController@save_opportunity_data');
Route::any('/renewals/get-contact-details', 'RenewalsController@get_contact_details');
Route::any('/renewals/save-billing-data', 'RenewalsController@save_billing_data');
Route::any('/renewals/ajax-billing-details', 'RenewalsController@ajax_billing_details');
Route::any('/renewals/save-account-details', 'RenewalsController@save_account_details');
Route::any('/renewals/save-client-details', 'RenewalsController@save_client_details');
Route::any('/renewals/send-manage-task', 'RenewalsController@send_manage_task');
Route::any('/renewals/get-date-format', 'RenewalsController@get_date_format');
Route::any('/renewals/delete-renewal-history', 'RenewalsController@delete_renewal_history');
Route::any('/renewals/send-global-task', 'RenewalsController@send_global_task');
Route::any('/renewals/delete-single-task', 'RenewalsController@delete_single_task');
Route::any('/renewals/get-sign-off-date', 'RenewalsController@get_sign_off_date');
/*================== CRM Renewals End ==============*/

/*================== Profile To Do List Start ==============*/
Route::any('/todo-list/{tab_no}', 'TodoListController@index');
Route::any('/savetask', 'TodoListController@savetask');
Route::any('/ajax-save-task', 'TodoListController@ajax_save_task');
Route::any('/ajax-delete-task', 'TodoListController@ajax_delete_task');
Route::any('/pdfpendingtask/{tab}', 'TodoListController@pdfpendingtask');
Route::any('/excelpendingtask/{tab}', 'TodoListController@excelpendingtask');
Route::any('/todolist/action', 'TodoListController@action');

/*================== Profile To Do List End ==============*/


Route::any('/fileandsign', 'FileandsignController@fileandsign');
Route::any('/file-share', 'FileandsignController@file_share');

Route::any('/quotes', 'QuotesController@quotes');
Route::any('/quotefilefile-upload', 'QuotesController@quotefilefile_upload');

Route::any('/renewals', 'CrmController@renewals');

Route::any('/inboxmail', 'CrmController@inboxmail');
Route::any('/getmail', 'CrmController@getmail');
Route::any('/indonboard', 'HomeController@indonboard');

/*================== Client Onboarding Start ==============*/
Route::any('/onboard', 'ClientOnboardingController@index');
Route::any('/pdfonboard/{search}/{type}', 'ClientOnboardingController@pdfindex');
//Route::any('/excelonboard', 'ClientOnboardingController@excelindex');

Route::any('/onboarding/insert-onboarding', 'ClientOnboardingController@insert_onboarding');
Route::any('/onboarding/ajax-task-details', 'ClientOnboardingController@ajax_task_details');
Route::any('/pdfdownloadajax-task-details/{client_id}', 'ClientOnboardingController@pdfdownloadajax_task_details');

Route::any('/onboarding/ajax-new-task', 'ClientOnboardingController@ajax_new_task');
Route::any('/onboarding/delete-task-details', 'ClientOnboardingController@delete_task_details');
Route::any('/onboarding/delete-onboarding-clients', 'ClientOnboardingController@delete_onboarding_clients');
Route::any('/onboarding/add-task-date', 'ClientOnboardingController@add_task_date');
Route::any('/onboarding/autosend-days', 'ClientOnboardingController@autosend_days');
Route::any('/onboarding/custom-checklist-action','ClientOnboardingController@custom_checklist_action');
/*================== Client Onboarding End ==============*/


Route::any('/billings-subscriptions', 'BillingsController@billings_subscriptions');
Route::any('/payment/{msg}', 'BillingsController@payment');
Route::any('/store-payment-data', 'BillingsController@store_payment_data');

/*=================== Admin Portal start ==============*/
Route::any('/admin/{page_open}', 'SiteManagerController@index');
Route::any('/sm/delete-user', 'SiteManagerController@delete_user');
Route::any('/sm/save-paypal-settings', 'SiteManagerController@save_paypal_settings');
/*=================== Admin Portal end ================*/

/* ================= Tax Cards ===================== */
Route::any('/tc/dashboard', 'TaxCardsController@dashboard');



Route::post('payment', array(
    'as' => 'payment',
    'uses' => 'BillingsController@postPayment',
));

// this is after make the payment, PayPal redirect back to your site
Route::get('payment/status', array(
    'as' => 'payment.status',
    'uses' => 'BillingsController@getPaymentStatus',
));

/* =============== Client POrtal ============== */
Route::get('/client-portal/files', 'ClientPortalController@files');

/* =============== Custom Tasks ================ */
Route::get('/custom-tasks/{service_id}/{page_open}/{staff_id}/{field1}/{field2}', 'CustomJobsController@index');
Route::post('/ct/get-all-clients', 'CustomJobsController@get_all_clients');
Route::post('/ct/get-table-data', 'CustomJobsController@get_ajax_datatable');
Route::post('/ct/custom-task-action', 'CustomJobsController@custom_task_action');
Route::post('/ct/delete-task-name', 'CustomJobsController@delete_task_name');
Route::any('/ct/download/{service_id}/{page_open}/{staff_id}/{type}','CustomJobsController@download');
Route::post('/ct/change-task-status', 'CustomJobsController@change_task_status');
Route::any('/ct/send-jobs-to-task', 'CustomJobsController@send_jobs_to_task');
Route::any('/ct/task-details-by-id', 'CustomJobsController@task_details_by_id');
Route::any('/ct/save-task-details', 'CustomJobsController@save_task_details');

/* =============== Checklist ================ */
Route::any('/checklist-details/{check_id}', 'ChecklistController@index');
Route::any('/checklist/add-checklist', 'ChecklistController@add_checklist');
Route::any('/checklist/ajax-check-details', 'ChecklistController@ajax_check_details');
Route::any('/checklist/insert-onboarding', 'ChecklistController@insert_onboarding');
Route::any('/checklist/add-task-date', 'ChecklistController@add_task_date');
Route::any('/checklist/status-view/{table_id}', 'ChecklistController@status_view');
Route::any('/checklist/update-status', 'ChecklistController@update_status');
Route::any('/checklist/save-check-details', 'ChecklistController@save_check_details');

### Routes for Settings Reminder Notification ###
Route::any('/reminder-notification/{page_open}',  'ReminderNotificationController@index');
Route::any('/reminder/view-template',  'ReminderNotificationController@view_template');
Route::any('/reminder/template-action',  'ReminderNotificationController@template_action');

/* ================== Letters Section =========================*/
Route::any('/letters',  'LettersController@dashboard');
Route::any('/letters/generate-letter/{page_open}/{letter_id}/{copyId?}/{type?}',  'LettersController@generate_letter');
Route::any('/letters/generate-letter-action',  'LettersController@generate_letter_action');
Route::any('/letters/view-letter/{page_open}',  'LettersController@view_letter');
Route::any('/letters/templates',  'LettersController@templates');
Route::any('/letters/template-action/{template_id?}/{copyId?}', 'LettersController@template_action');

Route::any('/letters/letter-head',  'LettersController@letter_heads_listing');
Route::get('/letters/letter-head/add',  'LettersController@add_letter_head');
Route::post('/letters/letter-head/add',  'LettersController@upload_letter_head'); // with ajax
Route::post('/letters/letter-head/remove',  'LettersController@delete_letter_head');
Route::post('/letters/letter-head/makedefault',  'LettersController@make_default_letter_head');



/* =========================== Nuz ============================== */

	/*================= CRM DASHBOARD ===============*/
	Route::any('/crm/proposals', 'ProposalController@dashboard');

	// Route::any('/crm/tax/edit/{tax_id}', 'TaxController@edit_tax');
	// Route::any('/crm/tax/check_tax/{tax_id}', 'TaxController@check_tax');
	// Route::any('/crm/tax/delete/{tax_id}', 'TaxController@delete_tax');
	
	/*================== CRM DASHBOARD End ==============*/
	
	/*================= CRM TAX ===============*/
	Route::any('/crm/tax', 'ProposalController@tax');
	Route::any('/crm/tax/edit/{tax_id}', 'ProposalController@edit_tax');
	Route::any('/crm/tax/check_tax/{tax_id}', 'ProposalController@check_tax');
	Route::any('/crm/tax/delete/{tax_id}', 'ProposalController@delete_tax');
	
	/*================== CRM TAX End ==============*/
	
	/*================= CRM SERVICE ===============*/
	Route::any('/crm/product', 'ProposalController@product');
	Route::any('/crm/service/{is_archive?}', 'ServiceController@service');
	Route::any('/crm/product/edit/{product_id}', 'ProposalController@edit_product');
	Route::any('/crm/product/check_product/{product_id}', 'ProposalController@check_product');
	Route::any('/crm/product/delete/{product_id}', 'ProposalController@delete_product');

	Route::any('/service/save-tax-action', 'ServiceController@save_tax_action');


	Route::any('/crm/branding', 'ProposalSettingsController@branding');
	Route::any('/settings/action', 'ProposalSettingsController@action');
	Route::any('/crm/terms', 'ProposalSettingsController@terms');
	Route::any('/crm/apps', 'ProposalSettingsController@apps');
	Route::any('/crm/apps-xero', 'ProposalSettingsController@apps_xero');
	
	/*================== CRM SERVICE End ==============*/
	
	/*================= CRM ATTACHMENT ===============*/
	Route::any('/crm/attachment/{is_archive?}', 'ProposalController@attachment');
	Route::any('/crm/attachment/preview/{attachment_id}', 'ProposalController@preview_attachment');
	Route::any('/crm/attachment/check_attachment/{attachment_id}', 'ProposalController@check_attachment');
	Route::any('/delete-attachment', 'ProposalController@delete_attachment');
	Route::any('/crm/attachment/download/{attachment_id}', 'ProposalController@getDownload');
	
	/*================== CRM ATTACHMENT End ==============*/
	
	/*================= CRM PROPOSAL ===============*/
	Route::any('/crm/viewAllProposal', 'ProposalController@viewAllProposal');
	Route::any('/crm/viewAllProposal/check_proposal/{proposal_id}','ProposalController@check_proposal');
	Route::any('/crm/createProposal', 'ProposalController@createProposal');
	Route::any('/crm/getTaxes', 'ProposalController@getTaxes');
	Route::any('/crm/getServicesProducts', 'ProposalController@getServicesProducts');
	Route::post('/crm/saveProposal', 'ProposalController@saveProposal');
	Route::get('/crm/attachFile/{proposal_id}', 'ProposalController@attachFile');
	Route::post('/crm/saveProposalAttachment', 'ProposalController@saveProposalAttachment');
	Route::get('/crm/additionalNote/{proposal_id}', 'ProposalController@additionalNote');
	Route::post('/crm/saveAdditionalNote', 'ProposalController@saveAdditionalNote');
	Route::get('/crm/selectTemplate/{proposal_id}', 'ProposalController@selectTemplate');
	Route::any('/crm/proposalPreview', 'ProposalController@proposalPreview');
	Route::get('/crm/editProposal/{proposal_id}', 'ProposalController@createProposal');
	Route::get('/crm/editAttachFile/{proposal_id}', 'ProposalController@attachFile');
	Route::get('/crm/editAdditionalNote/{proposal_id}', 'ProposalController@additionalNote');
	Route::get('/crm/editSelectTemplate/{proposal_id}', 'ProposalController@selectTemplate');
	Route::get('/crm/deleteProposal/{proposal_id}', 'ProposalController@deleteProposal');
	Route::get('/crm/sendProposalViaEmailForm/{proposal_id}', 'ProposalController@sendProposalViaEmailForm');
	Route::post('/crm/sendProposalViaEmail', 'ProposalController@sendProposalViaEmail');
	Route::get('/crm/saveProposalAsDraftFromEmailForm/{proposal_id}', 'ProposalController@saveProposalAsDraftFromEmailForm');
	Route::post('/crm/ajaxSaveServiceOrProduct', 'ProposalController@ajaxSaveServiceOrProduct');
	Route::get('/crm/getAttachmentInfo', 'ProposalController@getAttachmentInfo');
	Route::get('/crm/loadProposalPreview/{proposal_id}', 'ProposalController@loadProposalPreview');
	Route::get('/crm/downloadProposal/{proposal_attach_merger}/{proposal_id}', 'ProposalController@downloadProposal');
	Route::get('/crm/saveProposalAsDraft/{proposal_id}', 'ProposalController@saveProposalAsDraft');
	Route::get('/crm/loadProposalPreviewFromGrid/{proposal_id}','ProposalController@loadProposalPreview');
	Route::get('/crm/paymentTerms/{proposal_id}', 'ProposalController@paymentTerms');
	Route::post('/crm/createInvoice', 'ProposalController@createInvoice');
	Route::get('/crm/previewInvoice/{invoice_id}', 'ProposalController@previewInvoice');
	Route::get('/crm/downloadInvoice/{invoice_pdf}/{invoice_id}', 'ProposalController@downloadInvoice');
	Route::get('/crm/saveInvoiceAsDraft/{invoice_id}', 'ProposalController@saveInvoiceAsDraft');
	Route::get('/crm/editInvoice/{proposal_id}/{invoice_id}', 'ProposalController@paymentTerms');
	Route::get('/crm/sendInvoiceViaEmailForm/{invoice_id}/{proposal_id}', 'ProposalController@sendInvoiceViaEmailForm');
	Route::get('/crm/saveInvoiceAsDraftFromEmailForm/{invoice_id}', 'ProposalController@saveInvoiceAsDraftFromEmailForm');
	Route::post('/crm/sendInvoiceViaEmail', 'ProposalController@sendInvoiceViaEmail');
	Route::get('/crm/viewAllInvoice', 'ProposalController@viewAllInvoice');
	Route::get('/crm/getBillsByInvoice', 'ProposalController@getBillsByInvoice');
	Route::get('/crm/viewAllInvoice/check_invoice/{invoice_id}', 'ProposalController@check_invoice');
	Route::get('/crm/previewInvoiceFromGrid/{invoice_id}', 'ProposalController@previewInvoice');
	Route::get('/crm/deleteInvoice/{invoice_id}/{proposal_id}', 'ProposalController@deleteInvoice');
	Route::get('/crm/viewAllBills', 'ProposalController@viewAllBills');
	Route::get('/crm/amountReceiveForm', 'ProposalController@amountReceiveForm');
	Route::any('/crm/getInvoicesViaAjax', 'ProposalController@getInvoicesViaAjax');
	Route::post('/crm/getBillingAmount', 'ProposalController@getBillingAmount');
	Route::post('/crm/saveAmountReceive', 'ProposalController@saveAmountReceive');
	Route::get('/crm/deleteBill/{bill_id}', 'ProposalController@deleteBill');
	Route::get('/crm/editBill/{bill_id}', 'ProposalController@editBill');
	Route::get('/crm/copyProposal/{proposal_id}', 'ProposalController@createProposal');
	Route::get('/crm/copyAttachFile/{proposal_id}/{copy_proposal_id}', 'ProposalController@attachFile');
	Route::get('/crm/copyAdditionalNote/{proposal_id}/{copy_proposal_id}','ProposalController@additionalNote');
	Route::get('/crm/copyAdditionalNote/{proposal_id}/{copy_proposal_id}','ProposalController@additionalNote');
	Route::get('/crm/viewAllSchedule', 'ProposalController@viewAllSchedule');
	Route::get('/crm/makeSchedule/{proposal_id}', 'ProposalController@makeSchedule');
	Route::get('/crm/saveSchedule/{proposal_id}', 'ProposalController@saveSchedule');
	Route::get('/crm/toggleScheduleStatus/{status}/{schedule_id}', 'ProposalController@toggleScheduleStatus');
	Route::get('/crm/deleteSchedule/{schedule_id}', 'ProposalController@deleteSchedule');

	Route::get('/crm/view-draft', 'ProposalController@viewDraft');
	Route::get('/crm/letter-template', 'ProposalController@letter_template');
	Route::get('/crm/pricing-template', 'ProposalController@pricing_template');
	Route::get('/crm/proposal-template', 'ProposalController@proposal_template');
	
	Route::get('/crm/cover-letter', 'ProposalController@cover_letter');
	Route::get('/crm/create-attachment', 'ProposalController@create_attachment');

	Route::any('/proposal/action', 'ProposalController@action');
	Route::get('/proposal/new-proposal/{prospect_id?}/{page_from?}', 'ProposalController@new_proposal');
	Route::get('/proposal/edit-proposal/{prospect_id?}/{page_from?}','ProposalController@new_proposal');
	Route::get('/proposal/copy-proposal/{prospect_id?}/{page_from?}','ProposalController@new_proposal');




	
	Route::get('/proposal-preview/{crmProposalId?}/{pageFrom?}/{isRejct?}','ProposalPreviewController@proposal_preview');
	Route::any('/proposal-preview/action', 'ProposalPreviewController@action');

	Route::any('/testemailtemplate', 'ProposalPreviewController@testemailtemplate');


	Route::get('/terms-delete/{id?}', 'ProposalController@delete_terms');


Route::get('/cron-test', 'CronJobController@cron_test');
Route::get('/cron-test1', 'CronJobController@cron_test1');
Route::get('/task-reminder-message', 'CronJobController@task_reminder_message');
Route::get('/cron-chaser-email', 'CronJobController@cron_chaser_email');
Route::get('/cron-send-vat-totask', 'CronJobController@cron_send_vat_totask');
	
/*================== CRM PROPOSAL End ================*/ 

/*================== COMMON CONTROLLER START ================*/ 
Route::any('/common/action', 'CommonController@action');
/*================== COMMON CONTROLLER End ================*/ 



	/*================== E-Sign section start ================*/ 
	// Route::get('/esign/index', 'ESignController@index');
	// Route::get('/delete/{id}', 'ESignController@deleteDoc');

	// Route::get('/upload', 'CreateSignController@index');
	// Route::post('/uploadFile', 'CreateSignController@upload');
	// Route::post('/createSignDoc', 'CreateSignController@createSign');

	// // guest sign 
	// Route::get('/passcode/{key}', 'SignDocController@index');
	// Route::post('/passcode/{key}', 'SignDocController@verifyPasscode');
	// Route::get('/signit', 'SignDocController@signDocument');
	// Route::post('/makesign', 'SignDocController@makeSign');
	// Route::get('/declinetosign', 'SignDocController@declineSign');
	// Route::post('/personalSign', 'SignDocController@personalSign');
	Route::any('/table_test', 'LettersController@table_test');


	// jTable ajax call section
	Route::post('/crm/clients/get-org-client', 'CrmController@ajax_get_org_client');
	Route::post('/jtable/action', 'JtableController@action');




