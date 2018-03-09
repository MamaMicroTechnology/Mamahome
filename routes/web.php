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

Route::get('/', function () {
    return view('welcome');
});

// Shared View
Auth::routes();
Route::get('/profile','HomeController@getMyProfile');
Route::post('/uploadProfilePicture','HomeController@postMyProfile');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/authlogin','HomeController@authlogin');
Route::post('/authlogout','HomeController@authlogout')->name('authlogout');
Route::get('/payment','HomeController@getPayment');
Route::post('/posting','mamaController@postOrder');
Route::post('/payment/response','HomeController@getPaymentResponse');
Route::post('/register','mamaController@postRegistration');
Route::get('/changePassword','HomeController@changePassword');
Route::post('/postchangepassword','mamaController@postChangePassword');
Route::get('/forgotpassword','mamaController@forgotPw');
Route::post('/forgot','mamaController@forgot');
Route::get('/accept','HomeController@acceptConfidentiality');

// Admin
Route::group(['middleware' => ['admin']],function(){
    Route::get('/anr','HomeController@getAnR');
	Route::get('/viewEmployee','HomeController@viewEmployee');
	Route::get('/amdept','HomeController@amDept');
	Route::get('/quality','HomeController@quality');
	Route::get('/getquality','HomeController@getquality');
	Route::get('/mapping','HomeController@masterData');
	Route::post('/addDepartment','mamaController@addDepartment');
	Route::get('/filter','HomeController@filter');
	Route::post('/deleteDepartment','mamaController@deleteDepartment');
	Route::post('/addEmployee','mamaController@addEmployee');
	Route::post('/deleteEmployee','mamaController@deleteEmployee');
	Route::post('/{id}/assignDesignation','mamaController@assignDesignation');
	Route::post('/addDesignation','mamaController@addDesignation');
	Route::post('/deleteDesignation','mamaController@deleteDesignation');
	Route::post('/addWard','mamaController@addWard');
	Route::post('/addCountry','mamaController@addCountry');
	Route::post('/addTerritory','mamaController@addTerritory');
	Route::post('/addSubWard','mamaController@addSubWard');
    
	Route::post('/addState','mamaController@addState');
	Route::post('/addZone','mamaController@addZone');
	Route::get('/amreports','HomeController@getAMReports');
	Route::post('/{uid}/{rid}/giveGrade','mamaController@giveGrade');
	Route::get('/{id}/date','HomeController@amreportdates');
	Route::get('/{uid}/{date}/viewreports','HomeController@getViewReports');
	Route::post('/{uid}/{rid}/giveRemarks','mamaController@giveRemarks');
	Route::post('/{id}/{rid}/editGrade','mamaController@editGrade');
	Route::get('/humanresources','HomeController@getHRPage');
	Route::get('/humanresources/{dept}','HomeController@getHRDept');
	Route::get('/finance','HomeController@getFinance');
	Route::get('/finance/{dept}','HomeController@getEmpDetails');
    Route::get('/getprojectsize','HomeController@getProjectSize');
    Route::get('/ampricing','HomeController@ampricing');
    Route::get('/amorders','HomeController@amorders');
    Route::get('/confirmOrder','HomeController@confirmOrder');
    Route::get('/cancelOrder','HomeController@cancelOrder');
    Route::get('/showProjectDetails','HomeController@showProjectDetails');
    Route::get('/{id}/printLPO','HomeController@printLPO');
    Route::get('/{id}/attendance','HomeController@hrAttendance');
    Route::get('/{uId}/{date}','HomeController@viewDailyReport');
    Route::post('/grade','mamaController@gradetoEmp');
    Route::get('/admindailyslots','HomeController@projectadmin');
    Route::get('/editEmployee','HomeController@editEmployee');
    Route::post('/edit/save','mamaController@saveEdit');
    Route::post('/edit/bank_account','mamaController@saveBankDetails');
    Route::post('/edit/saveAssetInfo','mamaController@saveAssetInfo');
    Route::post('/edit/uploadCertificates','mamaController@uploadCertificates');
    Route::get('/manufacturerdetails','HomeController@manufacturerDetails');
    Route::get('/updateampay','HomeController@updateampay');
    Route::get('/updateamdispatch','HomeController@updateamdispatch');
    Route::get('/mhOrders','HomeController@getMhOrders');
    Route::get('/getSubCatPrices','HomeController@getSubCatPrices');
    Route::get('/salesStatistics','HomeController@getSalesStatistics');
});

// Team Leader
Route::group(['middleware' => ['operationTL']],function(){
	Route::get('/teamLead','HomeController@teamLeadHome');
	Route::post('/{id}/assignWards','mamaController@assignWards');
	// Route::get('/{id}/viewLeReport','HomeController@viewLeReport');
	Route::get('/{id}/deleteReportImage','HomeController@deleteReportImage');
	Route::get('/{id}/deleteReportImage2','HomeController@deleteReportImage2');
    Route::get('salesreport','HomeController@salesreport');
	Route::get('/{id}/deleteReportImage3','HomeController@deleteReportImage3');
	Route::get('/{id}/deleteReportImage4','HomeController@deleteReportImage4');
	Route::get('/{id}/deleteReportImage5','HomeController@deleteReportImage5');
	Route::get('/{id}/deleteReportImage6','HomeController@deleteReportImage6');
	Route::post('/{id}/morningRemark','mamaController@morningRemark');
	Route::post('/{id}/afternoonRemark','mamaController@afternoonRemark');
	Route::post('/{id}/eveningRemark','mamaController@eveningRemark');
	Route::post('/{id}/addTracing','mamaController@addTracing');
    Route::get('/completedAssignment','mamaController@completedAssignment');
    Route::get('/enquirysheet','HomeController@enquirysheet');
	Route::post('/{id}/addComment','mamaController@addComments');
	Route::post('/{id}/editMorningRemarks','mamaController@editMorninRemarks');
    Route::post('/{id}/editEveningRemarks','mamaController@editEveningRemarks');
    Route::post('/updateLogoutTime','mamaController@updateLogoutTime');
    Route::post('/markLeave','mamaController@markLeave');
});

// Listing Engineer
Route::group(['middleware' => ['listingEngineer']],function(){
	Route::get('/listingEngineer','HomeController@listingEngineer');
	Route::post('/addProject','mamaController@addProject');
	Route::post('/{id}/updateProject','mamaController@updateProject');
	Route::get('/leDashboard','HomeController@leDashboard');
	Route::get('/projectlist','HomeController@projectList');
	Route::get('/edit','HomeController@editProject');
	Route::get('/allProjects','HomeController@viewAll');
	Route::get('/{id}/viewDetails','HomeController@viewDetails');
	Route::get('/roads','HomeController@getRoads');
	Route::get('/projectlist','HomeController@viewProjectList');
	Route::get('/reports','HomeController@getMyReports');
	Route::get('/checkDupPhoneOwner', 'HomeController@checkDupPhoneOwner');
	Route::get('/checkDupPhoneConsultant', 'HomeController@checkDupPhoneConsultant');
	Route::get('/checkDupPhoneSite', 'HomeController@checkDupPhoneSite');
	Route::get('/checkDupPhoneContractor', 'HomeController@checkDupPhoneContractor');
	Route::get('/checkDupPhoneProcurement', 'HomeController@checkDupPhoneProcurement');
	Route::get('/updateContractor','HomeController@updateContractor');
	Route::get('/updateConsultant','HomeController@updateConsultant');
	Route::get('/updateProcurement','HomeController@updateProcurement');
 	Route::get('/completed','HomeController@updateAssignment');
	Route::get('/requirementsroads','HomeController@getRequirementRoads');
	Route::get('/projectrequirement','HomeController@projectRequirement');
    Route::get('/changequality','HomeController@changequality');
    Route::get('/changequestion','HomeController@changequestion');
	Route::get('/{id}/confirmedOrder','HomeController@getConfirmOrder');
	Route::post('/addMorningMeter','mamaController@addMorningMeter');
	Route::post('/addMorningData','mamaController@addMorningData');
	Route::post('/afternoonMeter','mamaController@afternoonMeter');
	Route::post('/afternoonData','mamaController@afternoonData');
	Route::post('/eveningMeter','mamaController@eveningMeter');
	Route::post('/eveningData','mamaController@eveningData');
	Route::get('/{id}/placeOrder','HomeController@placeOrder');
	Route::get('/{id}/confirmOrder','mamaController@confirmOrder');
	Route::get('/{id}/printInvoice','HomeController@invoice');
});
Route::get('/updateStatusReq','HomeController@updateStatusReq');
Route::post('/addRequirement','mamaController@addRequirement');
Route::get('/requirements','HomeController@getRequirements');
Route::get('/getSubCat','HomeController@getSubCat');
Route::get('/getPrice','HomeController@getPrice');
Route::get('/inputview','HomeController@inputview');
Route::post('/inputdata','HomeController@inputdata');
Route::get('/getProjects','HomeController@getProjects');
Route::get('/showThisProject','HomeController@showProjectDetails');
Route::get('/enquirysheet','HomeController@enquirysheet');

// Sales TL
Route::group(['middleware' => ['salesTL']],function(){
});

// Buyer End
Route::get('/blogin','BuyerController@buyerLogin');
Route::post('/blogin','BuyerController@postBuyerLogin');
Route::group(['middleware' => ['Buyer']],function(){
    Route::get('/buyerhome','BuyerController@buyerHome');
    Route::get('/buyerlogout','BuyerController@buyerLogout');
    Route::get('/myProfile','BuyerController@myProfile');
    Route::post('/updateProfile','BuyerController@updateProfile');
});

Route::post('/addmanufacturer','mamaController@addManufacturer');

// Sales Engineer
    Route::get('/updateOwner','HomeController@updateOwner');
    Route::get('/updateConsultant','HomeController@updateConsultant');
    Route::get('/updateContractor','HomeController@updateContractor');
    Route::get('/updateProcurement','HomeController@updateProcurement');
    Route::get('/salesEngineer','HomeController@getSalesEngineer');
    Route::get('/viewReport','HomeController@viewLeReport');
    Route::get('/{id}/confirmstatus','HomeController@confirmstatus');
    Route::get('/dailyslots','HomeController@dailyslots');
    Route::get('/{id}/confirmthis','HomeController@confirmthis');
    Route::get('/{id}/updatestatus','HomeController@updatestatus');
    Route::get('/{id}/updatelocation','HomeController@updatelocation');
    Route::get('/projectsUpdate','HomeController@projectsUpdate');
    Route::get('/getleinfo','HomeController@getleinfo');
    Route::get('/gettodayleinfo','HomeController@gettodayleinfo');
    Route::get('/registrationrequests','HomeController@regReq');
    Route::get('/salesAddProject','HomeController@listingEngineer');
    Route::get('/salescompleted','HomeController@updateSalesAssignment');
    Route::get('/{userid}/getLEDetails','HomeController@getLEDetails');
    Route::get('/{id}/updatemat','HomeController@updateMat');
    Route::get('/followupproject','HomeController@followup');
    Route::get('/updateNoteFollowUp','HomeController@updateNoteFollowUp');
    Route::post('/confirmUser','mamaController@confirmUser');
    Route::post('/addProject','mamaController@addProject');
    Route::post('/{id}/salesUpdateProject','mamaController@salesUpdateProject');
    Route::post('/confirmedProject','HomeController@confirmedProject');
    Route::get('/kra','HomeController@getKRA');

Route::get('/amorderss','amController@amorders');
Route::get('/placeOrder','amController@placeOrder');
Route::group(['middleware'=>['asst']],function(){
    // main links
	Route::get('/assignDailySlots','HomeController@getSalesTL');
	Route::post('/{id}/assignthisSlot','mamaController@assignthisSlot');
    Route::get('/completethis','HomeController@completethis');
    Route::get('/amdashboard','amController@getAMDashboard');
    Route::get('/pricing','amController@getPricing');
	Route::get('/amfinance','amController@getamFinance');
	Route::get('/amhumanresources','amController@getamHRPage');
    Route::get('/amvendordetails','amController@vendorDetails');
    Route::get('/amdailyslots','amController@amdailyslots');
    Route::get('/amkra','amController@amKRA');
    Route::get('/editkra','amController@editkra');
    Route::get('/deletekra','amController@deletekra');
    Route::post('/updatekra','amController@updatekra');
    Route::get('/getSubCatPrices','amController@amgetSubCatPrices');
    Route::get('/amgetSubCatPrices','amController@amgetSubCatPrices');
    Route::get('/amenquirysheet','amController@enquirysheet');
    Route::get('/addvendortype','amController@addvendortype');
    Route::post('/amaddvendor','amController@addvendor');
    Route::get('/salesreport','mamaController@salesreport');
    Route::post('/getSalesReport','mamaController@getSalesReport');
    
    Route::get('/updatepay','amController@updatepay');
    Route::get('/updatedispatch','amController@updatedispatch');
    Route::get('/confirmamOrder','amController@confirmamOrder');
    Route::get('/cancelamOrder','amController@cancelamOrder');
    Route::get('/confirmDelivery','amController@confirmDelivery');
	Route::get('/salesTL','HomeController@getSalesTL');
    
    // sub links
    Route::get('/amshowProjectDetails','amController@amshowProjectDetails');
	Route::get('/view','amController@getHRDept');
    Route::get('/amprintLPO','amController@printLPO');
	Route::get('/amfinanceview','amController@getamEmpDetails');
    Route::get('/amconfirmOrder','amController@confirmOrder');
    Route::get('/amcancelOrder','amController@cancelOrder');
	Route::get('/amdate','amController@amreportdates');
    Route::get('/ameditEmployee','amController@editEmployee');
    Route::get('/amviewEmployee','amController@viewEmployee');
    Route::get('/amattendance','amController@hrAttendance');
    Route::get('/viewdailyreport','amController@viewDailyReport');
    Route::get('/amadmindailyslots','amController@amprojectadmin');
    Route::get('/amviewreports','amController@getViewReports');
    Route::get('/updateUser','amController@updateUser');
    
    // post functions
	Route::post('/{id}/assignDailySlots','mamaController@assignDailySlots');
	Route::post('/amaddEmployee','mamaController@addEmployee');
    Route::post('/insertcat','mamaController@insertCat');
    Route::post('/amedit/save','mamaController@saveEdit');
    Route::post('/amedit/bank_account','mamaController@saveBankDetails');
    Route::post('/amedit/saveAssetInfo','mamaController@saveAssetInfo');
    Route::post('/amedit/uploadCertificates','mamaController@uploadCertificates');
    Route::post('/{uid}/{rid}/amgiveGrade','mamaController@giveGrade');
    Route::post('/{id}/{rid}/ameditGrade','mamaController@editGrade');
    Route::post('/amgrade','mamaController@gradetoEmp');
    Route::post('/addKRA','amController@addKRA');
    Route::post('/confirmDelivery','amController@postconfirmDelivery');
    Route::post('/inactiveEmployee','amController@inactiveEmployee');
    
    // not working
});
Route::group(['middleware'=>['AccountExecutive']],function(){
    Route::get('/accountExecutive','aeController@getAccountExecutive');
    Route::post('/addBuilderDetails','aeController@postBuilderDetails');
    Route::get('/builderprojects','aeController@viewBuilderProjects');
    Route::get('/addBuilderProjects','aeController@addBuilderProjects');
    Route::post('/addBuilderProject','aeController@addBuilderProject');
});
//Logistics
Route::group(['middleware'=>['Logistics']],function(){
    Route::get('/lcodashboard','logisticsController@dashboard');
    Route::get('/lcoorders','logisticsController@orders');
    Route::get('/lcoreport','logisticsController@report');
    Route::get('/{id}/showProjectDetails','logisticsController@showProjectDetails');
    Route::get('/confirmDelivery','logisticsController@confirmDelivery');
    Route::post('/confirmDelivery','logisticsController@postconfirmDelivery');
    Route::get('/deliveredorders','logisticsController@deliveredorders');
    // Route::get('/lcoreport','logisticsController@myreport');
});

Route::get('/marketing','marketingController@getHome');
Route::post('/addCategory','marketingController@addCategory');
Route::post('/addSubCategory','marketingController@addSubCategory');