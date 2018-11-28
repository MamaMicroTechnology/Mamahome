
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
Route::get('phpinfo', function () {
    return phpinfo();
});
Route::get('/', function () {
    return view('welcome');
});
Route::get('/getid','HomeController@getid');
Route::get('/getsubwards','AssignManufacturersController@getsubwards');
Route::get('/manuenquirysheet','AssignManufacturersController@manuenquirysheet');
Route::get('/simple','HomeController@simple');
Route::get('/ticket','HomeController@tickets');
Route::get('/enq','HomeController@enqticket');
Route::get('/noneed','AssignManufacturersController@indexnumber');
Route::post('/noneed','AssignManufacturersController@noneed');
Route::get('/subwardfind','AssignManufacturersController@find');
Route::get('/findsubward','AssignManufacturersController@findsubward');
Route::get('/subfind','AssignManufacturersController@subfind');
//tl dashboard work
Route::get('/delete_enquiry','TlController@delete_enquiry');
Route::get('/search_enquiry','TlController@search_enquiry');
Route::get('/manu_map','TlController@manumap');



Route::get('/ticketchat','HomeController@chat');
 Route::get('/assign_manufacturer','HomeController@manufacturerwise');
 Route::post('/Manufacturestore','AssignManufacturersController@Manufacturestore');
 Route::get('/sales_manufacture','AssignManufacturersController@sales_manufacture');
Route::post('/manuinputdata','AssignManufacturersController@inputdata');
Route::get('/menqedit','AssignManufacturersController@editEnq');
Route::post('/addcat','AssignManufacturersController@addcat');
Route::get('/catofficer','AssignManufacturersController@catsalesreports');
Route::get('/manudailyslot','AssignManufacturersController@dailyslots');
Route::get('/monthlyreport','AssignManufacturersController@getreport');

Route::get('/manudailyslot','AssignManufacturersController@manudailyslots');
Route::get('/getprojectsize','HomeController@getProjectSize');
Route::get('/projectandward','AssignManufacturersController@projectsize');


// chatting
Route::get('/Unupdated','HomeController@Unupdated');
Route::get('/cat','HomeController@Assigncat');

Route::get('/token','TokenController@token');
Route::get('/logoutFromChat','TokenController@logout');
 Route::get('/assignStages','HomeController@stages');
 Route::get('/h','HomeController@hstore');
 Route::get('/viewMap','HomeController@viewMap');
 Route::post('/saveinvoice','marketingController@saveinvoice');
 Route::post('/postcat','marketingController@postcat');
 Route::post('/price','marketingController@price');
 Route::get('/allprice','HomeController@allprice');
 Route::get('/assigntl','HomeController@assigntl');
 Route::post('/tlward','HomeController@tlward');


 Route::get('/pending','marketingController@pending');
Route::get('/map','HomeController@display');
Auth::routes();
Route::get('/myreport','HomeController@myreport');

Route::POST('/projectstore','HomeController@projectstore');
Route::POST('/projectstore1','HomeController@projectstore1');
Route::POST('/reject','HomeController@reject');

Route::POST('/enquirystore','HomeController@enquirystore');
Route::POST('/check','mamaController@check');

// Shared View
Auth::routes();
Route::get('/myreport','HomeController@myreport');
Route::get('/invoice','logisticsController@getinvoice');
Route::get('/inputinvoice','logisticsController@inputinvoice');
Route::get('/status_wise_projects','HomeController@index1');
Route::get('/allProjectsWithWards','HomeController@allProjectsWithWards');
Route::get('/profile','HomeController@getMyProfile');
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/authlogin','HomeController@authlogin');
Route::get('/payment','HomeController@getPayment');
Route::get('/checkdetailes','mamaController@checkdetailes');
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
Route::get('/underperson','ContractorController@getNoOfProjects1');

Route::get('/viewProjects','ContractorController@viewProjects');
Route::get('/ameditProject','HomeController@editProject');

Route::get('/getSubCatPrices','HomeController@getSubCatPrices');
Route::get('/loadsubwards','HomeController@loadSubWards');
Route::get('/get_what_you_want','ContractorController@getWhatYouWant');
Route::get('/amorderss','amController@amorders');
Route::get('/placeOrder','amController@placeOrder');
Route::get('/updateStatusReq','HomeController@updateStatusReq');
Route::get('/requirements','HomeController@inputview');
Route::get('/getSubCat','HomeController@getSubCat');
Route::get('/getPrice','HomeController@getPrice');
Route::get('/inputview','HomeController@inputview');
Route::get('/manuenquiry','AssignManufacturersController@manuenquiry');

Route::get('/getProjects','HomeController@getProjects');
Route::get('/showThisProject','HomeController@showProjectDetails');

Route::get('/enquiryCancell','HomeController@enquiryCancell');
Route::get('/myenquirysheet','HomeController@myenquirysheet');
Route::get('/editenq','HomeController@editEnq1');
Route::get('/editenq1','HomeController@editEnq1');
Route::get('/eqpipelineedit','HomeController@eqpipelineedit');
Route::get('/getquotation','mamaController@getquotation');
Route::get('/getprojects','mamaController@getquotation');



Route::get('/getAddress','HomeController@getAddress');
Route::get('/marketing','marketingController@getHome');
Route::get('/wardsforle','HomeController@wardsForLe');
Route::get('/wardsforle','HomeController@wardsForLe');
Route::get('/deleteRoomType','HomeController@deleteRoomType');
Route::get('/dailywiseProjects','HomeController@dailywiseProjects');
Route::get('/date_wise_project','HomeController@datewise');
Route::get('/status_wise_projects','HomeController@index1');
Route::get('/ordersformarketing','marketingController@ordersformarketing');
Route::get('/listeng','mamaController@listeng');
Route::get('/teamlisteng','mamaController@teamlisteng');
Route::get('/acceng','mamaController@acceng');
Route::get('/teamacceng','mamaController@teamacceng');
Route::get('/listeng/{name}','mamaController@getmap');
Route::get('/acceng/{name}','mamaController@getaccmap');
Route::post('/recordtime','mamaController@recordtime');
Route::Post('/lateremark','mamaController@recordtime');
Route::get('/latelogin','mamaController@latelogin');
Route::get('/teamlatelogin','mamaController@teamlatelogin');
Route::get('/adminlatelogin','mamaController@adminlatelogin');
Route::get('/hrlatelogins','mamaController@hrlatelogins');
Route::post('/logouttime','mamaController@logouttime');
Route::post('/approve','mamaController@approve');
Route::post('/reject','mamaController@reject');
Route::post('/adminapprove','mamaController@adminapprove');
Route::post('/adminreject','mamaController@adminreject');
Route::post('/hrapprove','mamaController@hrapprove');
Route::post('/hrreject','mamaController@hrreject');
Route::post('/logintime','mamaController@logintime');
Route::Post('/emplate','mamaController@logintime');
Route::Post('/earlyremark','mamaController@empreports');
Route::get('/loginhistory','HomeController@loginhistory');
Route::get('/breakhistory','HomeController@breakhistory');
Route::get('/minibreack','AssignManufacturersController@mini');


// Route::post('/emplogouttime','mamaController@emplogouttime');
Route::post('/teamlogin','mamaController@teamlogin');
Route::post('/teamlate','mamaController@teamlogin');
Route::post('/teamlogout','mamaController@teamlogout');
Route::get('/seniorteam','mamaController@seniorteam');
Route::get('/seniorteam1','mamaController@seniorteam1');
Route::get('/teamleader','mamaController@teamleader');
Route::get('/teamleader1','mamaController@teamleader1');
Route::get('/saleseng','mamaController@saleseng');
Route::get('/listatt','mamaController@listatt');
Route::get('/accexe','mamaController@accexe');
Route::get('/market','mamaController@market');
Route::get('/marketexe','mamaController@marketexe');
Route::get('/hr','mamaController@hr');
Route::get('/allteamleader','mamaController@allteamleader');
Route::get('/allsaleseng','mamaController@allsaleseng');
Route::get('/teamsales','mamaController@teamsales');
Route::get('/steam/{name}','mamaController@teammap');
Route::get('/viewEmployee','HomeController@viewEmployee');
Route::get('/ofcemp','mamaController@officeemp');
Route::get('/ofcemp/{name}','mamaController@officemap');
Route::get('/atreject','mamaController@atreject');
Route::get('/atapprove','mamaController@atapprove');
Route::post('/empreports','mamaController@empreports');
Route::get('/RandDdashboard','HomeController@getdashboard');
Route::get('/salesofficer','HomeController@getsalesofficer');
Route::post('/reportsRandD','HomeController@postdashboard');
Route::get('/breakreport','mamaController@breakreport');
Route::get('/holidays','mamaController@holidays');
Route::get('/deleteward','HomeController@deleteward');


//sales converter
Route::get('/scdashboard','HomeController@salesConverterDashboard');
Route::get('/projectDetailsForTL','HomeController@projectDetailsForTL');
Route::get('/projectsearch','HomeController@projectsearch');

Route::get('/chat','HomeController@getChat');
Route::get('/assignconverterSlots','HomeController@assignListSlots');
Route::get('/scmaps','HomeController@tlMaps');
Route::post('/{id}/converterassignWards','mamaController@assignWards');
Route::get('/scenquirysheet','HomeController@enquirysheet');
Route::get('/sctraining','HomeController@sctraining');
Route::get('/enquirywise','HomeController@enqwise');
Route::get('/storedetails','HomeController@storedetails');
Route::get('/lebrands','HomeController@lebrands');
Route::get('/storequery','HomeController@storequery');
Route::get('/manustorequery','HomeController@manustorequery');
Route::get('/getmaphistory','mamaController@getmap');
Route::get('/getmaphistory1','mamaController@getaccmap');


// Route::get('/starttimer','HomeController@starttimer');
Route::get('/starttimer','HomeController@starttimer');
Route::post('/breaktime','HomeController@breaktime');
Route::post('/sbreaktime','HomeController@sbreaktime');
Route::get('/breaks','HomeController@breaks');

//marketing
Route::get('/marketingdashboard','marketingController@marketingDashboard');
Route::get('/marketingvendordetails','amController@vendorDetails');
Route::get('/marketingvendortype','amController@addvendortype');
Route::post('/marketingaddvendor','amController@addvendor');
Route::post('/marketingaddmanufacturer','mamaController@addManufacturer');
Route::get('/marketingpricing','amController@getPricing');
Route::post('/marketinginsertcat','mamaController@insertCat');
Route::get('/marketmanufacturerdetails','HomeController@manufacturerDetails');
Route::get('/mrenquirysheet','HomeController@enquirysheet');
Route::get('/viewInvoices','marketingController@viewInvoices');

// Orders
Route::get('/orders','HomeController@amorders');
// Route::get('/orders','HomeController@amorders1');

Route::get('/updateampay','HomeController@updateampay');
Route::post('/confirmOrder','HomeController@confirmOrder');
Route::post('/generatequotation','mamaController@generatequotation');
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
Route::post('/addRequirements','mamaController@addRequirement');
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
Route::get('/assignListSlots','HomeController@assignListSlots');

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
Route::get('/salescompleted','HomeController@projectwisedel');
Route::post('/sms','HomeController@smstonumber');\
Route::get('/sms','HomeController@sms');
Route::post('/savenumber','HomeController@savenumber');
Route::get('/viewwardmap','HomeController@viewwardmap');
Route::get('/viewsubward','HomeController@viewsubward');
Route::get('/manufacturemap','HomeController@manufacturemap');


Route::get('/{userid}/getLEDetails','HomeController@getLEDetails');
Route::get('/{id}/updatemat','HomeController@updateMat');
Route::get('/followupproject','HomeController@followup');
// Route::get('/followup_project','HomeController@followup_projects');
Route::get('/updateNoteFollowUp','HomeController@updateNoteFollowUp');
Route::get('/kra','HomeController@getKRA');
Route::get('/eqpipeline','HomeController@eqpipeline');
Route::get('/eqpipe','HomeController@eqpipeline');
Route::get('/letraining','HomeController@letraining');
Route::get('/setraining','HomeController@setraining');
Route::post('/addDeliveryBoy','mamaController@addDeliveryBoy');
Route::post('/paymentmode','mamaController@paymentmode');


Route::post('/confirmUser','mamaController@confirmUser');
Route::post('/addProject','mamaController@addProject');
Route::post('/{id}/salesUpdateProject','mamaController@salesUpdateProject');
Route::post('/confirmedProject','HomeController@confirmedProject');
Route::post('/confirmedvisit','HomeController@confirmedvisit');
Route::post('/confirmedmanufacture','HomeController@confirmedmanufacture');
Route::post('/addmanufacturer','mamaController@addManufacturer');
Route::post('/deleteCertificate','amController@deleteCertificate');
Route::get('/lcoorders','logisticsController@orders');
Route::get('/manusearch','AssignManufacturersController@manusearch');

// Admin
Route::get('/deleteProject','mamaController@deleteProject');
Route::get('/deletemanu','mamaController@deletemanuProject');

Route::group(['middleware' => ['admin']],function(){
    Route::post('/aMaddPoints','mamaController@addPoints');
    Route::get('/wardmaping','HomeController@getWardMaping');
    Route::get('/anr','HomeController@getAnR');
   
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
    
    Route::get('/ampricing','HomeController@ampricing');
    Route::get('/setprice','HomeController@setprice');

    Route::get('/adtraining','HomeController@adtraining');
    Route::get('/adenquirysheet','HomeController@enquirysheet');

    Route::get('/{id}/attendance','HomeController@hrAttendance');
    Route::get('/{uId}/{date}','HomeController@viewDailyReport');
    Route::get('/editEmployee','HomeController@editEmployee');
    Route::get('/manufacturerdetails','HomeController@manufacturerDetails');
    Route::get('/mhOrders','HomeController@getMhOrders');
    Route::get('/salesStatistics','HomeController@getSalesStatistics');
    Route::get('/activitylog','HomeController@activityLog');
    Route::get('/employeereports','HomeController@employeereports');
    Route::get('/viewallProjects','HomeController@viewallProjects');

    Route::get('/salesreports','HomeController@salesreports');
    Route::post('/saveEdit','mamaController@save_edit');
    Route::get('/check','HomeController@getCheck');
    Route::get('/video','HomeController@trainingVideo');
    Route::post('/uploadfile','HomeController@uploadfile');
    Route::get('/deletelist','HomeController@deletelist');
    Route::get('/deleteentry','HomeController@deleteentry');
    Route::get('/getWards','HomeController@getWards');
    Route::get('/approvePoint','HomeController@approvePoint');
    Route::get('/assignadmin','HomeController@assignadmin');
    Route::get('/admincompleted','mamaController@completedAssignment');
    Route::get('/confidential','HomeController@confidential');
    Route::get('/letracking','HomeController@getLeTracking');
   
    Route::post('/storedate','HomeController@storedate');

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
    Route::get('/tlenquirysheet','HomeController@enquirysheet');
    Route::get('/teamLead','HomeController@teamLeadHome');
    Route::get('/tltraining','HomeController@tltraining');
    Route::get('/assign_project','HomeController@projectwise');
    Route::get('/assign_enquiry','HomeController@enquirywise');
    Route::get('/assign_number','HomeController@numberwise');
    Route::post('/storenumber','HomeController@storenumber');
    Route::post('/storecount','HomeController@storecount');
    Route::get('/assign_manufacturer','HomeController@manufacturerwise');


    


    Route::post('/store','HomeController@store');
    Route::post('/datestore','HomeController@datestore');
    Route::get('/teamkra','amController@teamamKRA');
    Route::post('/teamaddKRA','amController@teamaddKRA');
    Route::get('/teamdeletekra','amController@deletekra');
    Route::post('/teamupdatekra','amController@updatekra');
    Route::post('/addPoints','mamaController@addPoints');
    Route::get('/tltracking','HomeController@getLeTracking');


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

    
    Route::get('/listingEngineer','HomeController@listingEngineer');

// Listing Engineer
Route::group(['middleware' => ['listingEngineer']],function(){
    Route::get('/leDashboard','HomeController@leDashboard');
    Route::get('/sales','HomeController@sales');

    // Route::get('/enquirysheet','HomeController@enquirysheet');
    // Route::get('/projectlist','HomeController@projectList');
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
    Route::get('/checkmanu','HomeController@checkmanu');
    // Route::get('/updateContractor','HomeController@updateContractor');
    // Route::get('/updateConsultant','HomeController@updateConsultant');
    // Route::get('/updateProcurement','HomeController@updateProcurement');
    Route::get('/completed','mamaController@completedAssignment');
    Route::get('/requirementsroads','HomeController@getRequirementRoads');
    Route::get('/projectrequirement','HomeController@projectRequirement');
    Route::get('/changequality','HomeController@changequality');
    Route::get('/changequestion','HomeController@changequestion');
    Route::get('/{id}/confirmedOrder','HomeController@getConfirmOrder');
    Route::get('/{id}/placeOrder','HomeController@placeOrder');
    Route::get('/{id}/confirmOrder','mamaController@confirmOrder');
    Route::get('/{id}/printInvoice','HomeController@invoice');
    
    // Route::post('/addProject','mamaController@addProject');
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


    // main links
    Route::get('/amdashboard','amController@getAMDashboard');

    // main links
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
    Route::get('/astenquirysheet','HomeController@enquirysheet');
    Route::get('/addvendortype','amController@addvendortype');
    Route::get('/salesreport','mamaController@salesreport');
    Route::get('/amviewattendance','HomeController@employeereports');
    Route::get('/newamviewattendance','HomeController@newemployeereports');
    Route::post('/saveEdit','mamaController@save_edit');
    Route::get('/check','HomeController@getCheck');
    Route::get('/video','HomeController@trainingVideo');

//human resource//
    Route::get('/assets','amController@addassets'); 
    Route::get('/mhemployee','amController@mhemployee'); 
    Route::get('/viewasset','amController@getasset');
    Route::post('/inputasset','amController@storeasset');
    Route::post('/assetsimcard','amController@assetsimcard');
    Route::post('/addtype','amController@addtype');
    Route::get('/assignassets','amController@assignassets');
    Route::get('/assetsview','amController@getview');
    Route::get('/assignEmployee','amController@assignEmployee');
    Route::get('/editasset','amController@editasset');
    Route::post('/saveasset','amController@saveasset');
    Route::post('/saveassetinfo','amController@saveassetinfo');
    Route::get('/getname','amController@getname');
    Route::get('/getserial','amController@getserial');
    Route::get('/getdesc','amController@getdesc');
    Route::post('/deleteassetsimcard','amController@deleteassetsim');
    Route::post('/deleteAsset','amController@deleteAsset');
    Route::get('/deleteassets','amController@deleteassets');
    Route::post('/deletesim','amController@deletesim');
    Route::post('/savesiminfo','amController@savesiminfo');
    Route::get('/getbrand','amController@getbrand');
    Route::get('/signature','amController@signature');
    Route::get('/preview','amController@preview');
    Route::get('/viewmhemployee','amController@viewmhemployee');




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
Route::group(['middleware'=>['AccountExecutive']],function(){
    // Route::get('/accountExecutive','aeController@getAccountExecutive');
    Route::get('/accountExecutive','HomeController@leDashboard');
    Route::get('/builderprojects','aeController@viewBuilderProjects');
    Route::get('/addBuilderProjects','aeController@addBuilderProjects');
    Route::post('/addBuilderDetails','aeController@postBuilderDetails');
    Route::post('/addBuilderProject','aeController@addBuilderProject');
    Route::get('/deliveredOrders','aeController@getDeliveredOrders');
    });
    Route::get('/accountlistingEngineer','HomeController@listingEngineer');
    Route::get('/accountroads','HomeController@getRoads');
    Route::get('/accountrequirementsroads','HomeController@getRequirementRoads');
    Route::get('/accountreports','HomeController@getMyReports');

//Logistics
Route::group(['middleware'=>['Logistics']],function(){
    Route::get('/lcodashboard','logisticsController@dashboard');
   
    Route::get('/lcoreport','logisticsController@report');
    Route::get('/showProjectDetails','logisticsController@showProjectDetails');
    Route::get('/confirmDelivery','logisticsController@confirmDelivery');
    Route::post('/confirmDelivery','logisticsController@postconfirmDelivery');
    Route::get('/deliveredorders','logisticsController@deliveredorders');
    Route::get('/takesignature','logisticsController@takesignature');
    Route::post('/saveSignature','logisticsController@saveSignature');
    Route::post('/payment','logisticsController@payment');
    Route::post('/saveDeliveryDetails','logisticsController@saveDeliveryDetails');
    Route::post('/feedback','logisticsController@feedback');
    Route::post('/deposit','logisticsController@deposit');
    Route::get('/lcinvoice','logisticsController@lcinvoice');
});

Route::get('/payment','HomeController@payment');
Route::get('/projection','HomeController@getProjection');
Route::post('/lockProjection','HomeController@getLockProjection');

Route::post('/toggle-approve',"HomeController@approval");
Route::post('/toggle-approve1',"HomeController@approval1");
Route::get('/sendSMS', 'HomeController@sendSMS');
Route::get('/planning','HomeController@getLockedProjection');
Route::get('/stage','HomeController@getLockedStage');
Route::get('/reset','HomeController@getReset');
Route::get('/total','HomeController@getTotal');
Route::get('/yearly','HomeController@getYearlyPlanning');
Route::get('/fiveyears','HomeController@getFiveYears');
Route::get('/daily','HomeController@getDaily');
Route::post('/lockYearly','HomeController@lockYearly');
Route::get('/countryProjection','HomeController@getCountryProjection');
Route::get('/expenditure','HomeController@getExpenditure');
Route::post('/saveExpenditure','HomeController@saveExpenditure');
Route::get('/viewExpenditure','HomeController@viewExpenditure');
Route::get('/five_years_expenditure','HomeController@getFiveYearsExpenditure');
Route::get('/extensionPlanner','HomeController@getExtensionPlanner');
Route::get('/editProjectionPlanner','HomeController@getEditProjectionPlanner');
Route::get('/updateManufacturer','HomeController@getUpdateManufacturer');
Route::get('/updateManufacturerDetails','HomeController@updateManufacturerDetails');
// Auditor Dashboard
Route::get('/auditor','HomeController@getAuditorDashboard');
Route::post('/save','HomeController@save');
Route::post('/clearcheck','mamaController@clearcheck');
Route::get('/cashdeposit','marketingController@cashdeposit');
Route::post('/close','logisticsController@close');
Route::get('/addManufacturer','HomeController@addManufacturer');
Route::post('/saveManufacturer','mamaController@postSaveManufacturer');
Route::get('/viewManufacturer','HomeController@viewManufacturer');
Route::get('/auto',"HomeController@auto");
Route::post('/saveUpdatedManufacturer','mamaController@saveUpdatedManufacturer');
Route::get('/itdashboard','ItController@getItDashboard');
Route::post('/reportsForIt','ItController@postItReport');
Route::get('/unverifiedProjects','HomeController@getUnverifiedProjects');
Route::get('/projectWithNotes','HomeController@getProjectsBasedOnNotes');
Route::get('/newActivityLog','HomeController@getNewActivityLog');
Route::get('/bulkBusiness','ProjectionController@getBulkBusiness');
Route::post('/saveBulk','ProjectionController@saveProjection');
Route::get('/bulkView','ProjectionController@viewBulk');
Route::get('/fiveyearsWithZones','ProjectionController@fiveyearsWithZones');

// Finance
Route::get('/financeIndex','FinanceDashboard@financeIndex');
Route::get('/financeDashboard','FinanceDashboard@getFinanceDashboard');
Route::post('/clearOrderForDelivery','FinanceDashboard@clearOrderForDelivery');
Route::get('/downloadInvoice','FinanceDashboard@downloadInvoice')->name('downloadInvoice');
Route::get('/downloadTaxInvoice','FinanceDashboard@downloadTaxInvoice')->name('downloadTaxInvoice');
Route::get('/downloadpurchaseOrder','FinanceDashboard@downloadpurchaseOrder')->name('downloadpurchaseOrder');
Route::get('/downloadquotation','FinanceDashboard@downloadquotation')->name('downloadquotation');
Route::post('/savePaymentDetails','FinanceDashboard@savePaymentDetails');
Route::get('/financeAttendance','FinanceDashboard@getFinanceAttendance');
Route::get('/viewProformaInvoice','FinanceDashboard@getViewProformaInvoice');
Route::get('/viewPurchaseOrder','FinanceDashboard@getViewPurchaseOrder');
Route::post('/sendMessage','FinanceDashboard@sendMessage');
Route::get('/confirmpayment','FinanceDashboard@confirmpayment');
Route::get('/paymentmode','FinanceDashboard@paymentmode');
Route::post('/saveunitprice','FinanceDashboard@saveunitprice');
Route::post('/savesupplierdetails','FinanceDashboard@savesupplierdetails');
Route::get('/getgst','FinanceDashboard@getgst');






