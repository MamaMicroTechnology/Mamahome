
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

// chatting
Route::get('/token','TokenController@token');
Route::get('/logoutFromChat','TokenController@logout');
 Route::get('/assignStages','HomeController@stages');
// Shared View
Auth::routes();
Route::get('/myreport','HomeController@myreport');


Route::get('/status_wise_projects','HomeController@index1');


Route::get('/profile','HomeController@getMyProfile');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/authlogin','HomeController@authlogin');
Route::get('/payment','HomeController@getPayment');
Route::get('/changePassword','HomeController@changePassword');
Route::get('/forgotpassword','mamaController@forgotPw');
Route::get('/accept','HomeController@acceptConfidentiality');
Route::get('/getBrands','amController@getBrands');
Route::get('/showProjectDetails','HomeController@showProjectDetails');
Route::get('/admindailyslots','HomeController@projectadmin');
Route::get('/blocked_projects','HomeController@blocked');

Route::get('/contractorDetails','ContractorController@getContractorDetails');
Route::get('/updateContractors','ContractorController@getUpdates');
Route::get('/getContractorProjects','ContractorController@getProjects');
Route::get('/contractor_with_no_of_projects','ContractorController@getNoOfProjects');
Route::get('/viewProjects','ContractorController@viewProjects');
Route::get('/ameditProject','HomeController@editProject');

Route::get('/getSubCatPrices','HomeController@getSubCatPrices');
Route::get('/loadsubwards','HomeController@loadSubWards');
Route::get('/get_what_you_want','ContractorController@getWhatYouWant');
Route::get('/amorderss','amController@amorders');
Route::get('/placeOrder','amController@placeOrder');
Route::get('/updateStatusReq','HomeController@updateStatusReq');
Route::get('/requirement','HomeController@getRequirements');
Route::get('/getSubCat','HomeController@getSubCat');
Route::get('/getPrice','HomeController@getPrice');
Route::get('/inputview','HomeController@inputview');
Route::get('/getProjects','HomeController@getProjects');
Route::get('/showThisProject','HomeController@showProjectDetails');
Route::get('/enquirysheet','HomeController@enquirysheet');
Route::get('/enquiryCancell','HomeController@enquiryCancell');
Route::get('/myenquirysheet','HomeController@myenquirysheet');
Route::get('/editenq','HomeController@editEnq');
Route::get('/editenq1','HomeController@editEnq1');
Route::get('/eqpipelineedit','HomeController@eqpipelineedit');

Route::get('/getAddress','HomeController@getAddress');
Route::get('/marketing','marketingController@getHome');
Route::get('/wardsforle','HomeController@wardsForLe');
Route::get('/wardsforle','HomeController@wardsForLe');
Route::get('/deleteRoomType','HomeController@deleteRoomType');
Route::get('/dailywiseProjects','HomeController@dailywiseProjects');


//sales converter
Route::get('/scdashboard','HomeController@salesConverterDashboard');
Route::get('/projectDetailsForTL','HomeController@projectDetailsForTL');
Route::get('/chat','HomeController@getChat');

//marketing
Route::get('/marketingdashboard','marketingController@marketingDashboard');
Route::get('/marketingvendordetails','amController@vendorDetails');
Route::get('/marketingvendortype','amController@addvendortype');
Route::post('/marketingaddvendor','amController@addvendor');
Route::post('/marketingaddmanufacturer','mamaController@addManufacturer');
Route::get('/marketingpricing','amController@getPricing');
Route::post('/marketinginsertcat','mamaController@insertCat');
Route::get('/marketmanufacturerdetails','HomeController@manufacturerDetails');

// Orders
Route::get('/orders','HomeController@amorders');
Route::get('/updateampay','HomeController@updateampay');
Route::get('/confirmOrder','HomeController@confirmOrder');
Route::get('/cancelOrder','HomeController@cancelOrder');
Route::get('/updateamdispatch','HomeController@updateamdispatch');
Route::get('/deliverOrder','HomeController@deliverOrder');
Route::get('/{id}/printLPO','HomeController@printLPO');

Route::post('/uploadProfilePicture','HomeController@postMyProfile');
Route::post('/editinputdata','mamaController@editinputdata');
Route::post('/authlogout','HomeController@authlogout')->name('authlogout');
Route::post('/posting','mamaController@postOrder');
Route::post('/payment/response','HomeController@getPaymentResponse');
Route::post('/register','mamaController@postRegistration');
Route::post('/postchangepassword','mamaController@postChangePassword');
Route::post('/forgot','mamaController@forgot');
Route::post('/{id}/updateProject','mamaController@updateProject');
Route::post('/markProject','mamaController@markProject');
Route::post('/addRequirement','mamaController@addRequirement');
Route::post('/inputdata','HomeController@inputdata');
Route::post('/addCategory','marketingController@addCategory');
Route::post('/addSubCategory','marketingController@addSubCategory');
Route::post('/addBrand','marketingController@addBrand');
Route::post('/deleteCategory','marketingController@deleteCategory');
Route::post('/deleteCategory','marketingController@deleteCategory');
Route::post('/deleteSubCategory','marketingController@deleteSubCategory');
Route::post('/deletebrand','marketingController@deletebrand');
Route::post('/updateBrand','marketingController@updateBrand');
Route::post('/updateCategory','marketingController@updateCategory');
Route::post('/updateSubCategory','marketingController@updateSubCategory');
Route::post('/editEnquiry','mamaController@editEnquiry');
Route::post('/editManualEnquiry','mamaController@editManualEnquiry');

// Sales Engineer
Route::get('/date_wise_project','HomeController@datewise');
Route::get('/sedashboard','HomeController@salesEdashboard');
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
Route::get('/kra','HomeController@getKRA');
Route::get('/eqpipeline','HomeController@eqpipeline');
Route::get('/letraining','HomeController@letraining');
Route::get('/setraining','HomeController@setraining');




Route::post('/confirmUser','mamaController@confirmUser');
Route::post('/addProject','mamaController@addProject');
Route::post('/{id}/salesUpdateProject','mamaController@salesUpdateProject');
Route::post('/confirmedProject','HomeController@confirmedProject');
Route::post('/addmanufacturer','mamaController@addManufacturer');
Route::post('/deleteAsset','amController@deleteAsset');
Route::post('/deleteCertificate','amController@deleteCertificate');


// Admin
Route::group(['middleware' => ['admin']],function(){
    Route::get('/wardmaping','HomeController@getWardMaping');
    Route::get('/anr','HomeController@getAnR');
    Route::get('/viewEmployee','HomeController@viewEmployee');
    Route::get('/amdept','HomeController@amDept');
    Route::get('/quality','HomeController@quality');
    Route::get('/getquality','HomeController@getquality');
    Route::get('/mapping','HomeController@masterData');
    Route::get('/filter','HomeController@filter');
    Route::get('/amreports','HomeController@getAMReports');
    Route::get('/{id}/date','HomeController@amreportdates');
    Route::get('/{uid}/{date}/viewreports','HomeController@getViewReports');
    Route::get('/humanresources','HomeController@getHRPage');
    Route::get('/humanresources/{dept}','HomeController@getHRDept');
    Route::get('/finance','HomeController@getFinance');
    Route::get('/finance/{dept}','HomeController@getEmpDetails');
    Route::get('/getprojectsize','HomeController@getProjectSize');
    Route::get('/ampricing','HomeController@ampricing');
    Route::get('/adtraining','HomeController@adtraining');
    
    Route::get('/{id}/attendance','HomeController@hrAttendance');
    Route::get('/{uId}/{date}','HomeController@viewDailyReport');
    Route::get('/editEmployee','HomeController@editEmployee');
    Route::get('/manufacturerdetails','HomeController@manufacturerDetails');
    Route::get('/mhOrders','HomeController@getMhOrders');
    Route::get('/salesStatistics','HomeController@getSalesStatistics');
    Route::get('/activitylog','HomeController@activityLog');
    Route::get('/employeereports','HomeController@employeereports');
    Route::get('/viewallProjects','HomeController@viewallProjects');
    Route::get('/deleteProject','mamaController@deleteProject');
    Route::get('/salesreports','HomeController@salesreports');
    Route::post('/saveEdit','mamaController@save_edit');
    Route::get('/check','HomeController@getCheck');
    Route::get('/video','HomeController@trainingVideo');
    Route::post('/uploadfile','HomeController@uploadfile');
    Route::get('/deletelist','HomeController@deletelist');
    Route::get('/deleteentry','HomeController@deleteentry');
    Route::get('/getWards','HomeController@getWards');
    Route::post('/uploadvideo','HomeController@uploadvideo');
    Route::post('/saveMap','mamaController@saveMap');
    Route::post('/saveWardMap','mamaController@saveWardMap');
    
    Route::post('/addDepartment','mamaController@addDepartment');
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
    Route::post('/{uid}/{rid}/giveGrade','mamaController@giveGrade');
    Route::post('/{uid}/{rid}/giveRemarks','mamaController@giveRemarks');
    Route::post('/{id}/{rid}/editGrade','mamaController@editGrade');
    Route::post('/grade','mamaController@gradetoEmp');
    Route::post('/edit/save','mamaController@saveEdit');
    Route::post('/edit/bank_account','mamaController@saveBankDetails');
    Route::post('/edit/saveAssetInfo','mamaController@saveAssetInfo');
    Route::post('/edit/uploadCertificates','mamaController@uploadCertificates');
});

// Team Leader
Route::group(['middleware' => ['operationTL']],function(){
    Route::get('/assignDailySlots','HomeController@getSalesTL');
    Route::get('/assigndate','HomeController@assigndate');

    Route::get('/assignListSlots','HomeController@assignListSlots');
    Route::get('/teamLead','HomeController@teamLeadHome');
    Route::get('/tltraining','HomeController@tltraining');
   
    Route::post('/store','HomeController@store');
    Route::post('/datestore','HomeController@datestore');
    Route::get('/teamkra','amController@teamamKRA');
    Route::post('/teamaddKRA','amController@teamaddKRA');
    Route::get('/teamdeletekra','amController@deletekra');
    Route::post('/teamupdatekra','amController@updatekra');




    Route::get('/{id}/deleteReportImage','HomeController@deleteReportImage');
    Route::get('/{id}/deleteReportImage2','HomeController@deleteReportImage2');
    Route::get('salesreport','HomeController@salesreport');
    Route::get('/{id}/deleteReportImage3','HomeController@deleteReportImage3');
    Route::get('/{id}/deleteReportImage4','HomeController@deleteReportImage4');
    Route::get('/{id}/deleteReportImage5','HomeController@deleteReportImage5');
    Route::get('/{id}/deleteReportImage6','HomeController@deleteReportImage6');
    Route::get('/completedAssignment','mamaController@completedAssignment');
    
    Route::get('/completethis','HomeController@completethis');
    Route::get('/completethis1','HomeController@completethis1');
    Route::get('/tlsalesreports','HomeController@salesreports');
    Route::get('/tlmaps','HomeController@tlMaps');

    Route::post('/{id}/assignWards','mamaController@assignWards');
    Route::post('/{id}/morningRemark','mamaController@morningRemark');
    Route::post('/{id}/afternoonRemark','mamaController@afternoonRemark');
    Route::post('/{id}/eveningRemark','mamaController@eveningRemark');
    Route::post('/{id}/addTracing','mamaController@addTracing');
    Route::post('/{id}/addComment','mamaController@addComments');
    Route::post('/{id}/editMorningRemarks','mamaController@editMorninRemarks');
    Route::post('/{id}/editEveningRemarks','mamaController@editEveningRemarks');
    Route::post('/updateLogoutTime','mamaController@updateLogoutTime');
    Route::post('/markLeave','mamaController@markLeave');
    Route::post('/{id}/assignthisSlot','mamaController@assignthisSlot');
});

// Listing Engineer
Route::group(['middleware' => ['listingEngineer']],function(){
    Route::get('/listingEngineer','HomeController@listingEngineer');
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
    Route::get('/completed','mamaController@completedAssignment');
    Route::get('/requirementsroads','HomeController@getRequirementRoads');
    Route::get('/projectrequirement','HomeController@projectRequirement');
    Route::get('/changequality','HomeController@changequality');
    Route::get('/changequestion','HomeController@changequestion');
    Route::get('/{id}/confirmedOrder','HomeController@getConfirmOrder');
    Route::get('/{id}/placeOrder','HomeController@placeOrder');
    Route::get('/{id}/confirmOrder','mamaController@confirmOrder');
    Route::get('/{id}/printInvoice','HomeController@invoice');
    
    Route::post('/addProject','mamaController@addProject');
    Route::post('/addMorningMeter','mamaController@addMorningMeter');
    Route::post('/addMorningData','mamaController@addMorningData');
    Route::post('/afternoonMeter','mamaController@afternoonMeter');
    Route::post('/afternoonData','mamaController@afternoonData');
    Route::post('/eveningMeter','mamaController@eveningMeter');
    Route::post('/eveningData','mamaController@eveningData');
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

Route::group(['middleware'=>['asst']],function(){
    // main links
    Route::get('/amdashboard','amController@getAMDashboard');
    Route::get('/pricing','amController@getPricing');
    Route::get('/amfinance','amController@getamFinance');
    Route::get('/amhumanresources','amController@getamHRPage');
    Route::get('/amvendordetails','amController@vendorDetails');
    Route::get('/amdailyslots','amController@amdailyslots');
    Route::get('/amkra','amController@amKRA');
    Route::get('/editkra','amController@editkra');
    Route::get('/deletekra','amController@deletekra');
    Route::get('/amgetSubCatPrices','amController@amgetSubCatPrices');
    Route::get('/amenquirysheet','amController@enquirysheet');
    Route::get('/addvendortype','amController@addvendortype');
    Route::get('/salesreport','mamaController@salesreport');
    Route::get('/amviewattendance','HomeController@employeereports');
    Route::post('/saveEdit','mamaController@save_edit');
    Route::get('/check','HomeController@getCheck');
    Route::get('/video','HomeController@trainingVideo');
    Route::post('/uploadfile','HomeController@uploadfile');
    Route::get('/deletelist','HomeController@deletelist');
     Route::get('/asttraining','HomeController@asttraining');
    Route::post('/uploadvideo','HomeController@uploadvideo');
    
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
    Route::post('/updatekra','amController@updatekra');
    Route::post('/amaddvendor','amController@addvendor');
    Route::post('/getSalesReport','mamaController@getSalesReport');
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
    Route::get('/builderprojects','aeController@viewBuilderProjects');
    Route::get('/addBuilderProjects','aeController@addBuilderProjects');
    Route::post('/addBuilderDetails','aeController@postBuilderDetails');
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
    Route::get('/takesignature','logisticsController@takesignature');
    Route::get('/saveSignature','logisticsController@saveSignature');
});




Route::post('/toggle-approve',"HomeController@approval");
Route::post('/toggle-approve1',"HomeController@approval1");