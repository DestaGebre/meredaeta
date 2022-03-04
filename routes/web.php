<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

use Illuminate\Support\Facades\Auth;
use App\Zobatat;
use App\Woreda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Kamaln7\Toastr\Facades\Toastr;

Route::group(['middleware' => 'App\Http\Middleware\SuperAdminMiddleware'],
    function(){
        Route::resource('directpromotion', 'DirectPromotion');
        Route::post('promote', 'DirectPromotion@promote');
        Route::resource('importwidabe', 'ImportWahioAndWidabe');
        Route::resource('importwidabeexcel', 'ImportWahioAndWidabe@importFile');
        Route::post('deletedocument', 'DocumentsController@deleteDoc');
        Route::resource('/generatereport', 'GenerateReport');
        Route::resource('/generatereportpost', 'GenerateReport@generate');

        // Zone
        Route::resource('/zone', 'Zonecontroller@index');
        Route::post('/zoneadd', 'Zonecontroller@addZone');
        Route::post('/zoneedit', 'Zonecontroller@editZone');
        Route::post('/zonedelete', 'Zonecontroller@deleteZone');
    }
);

Route::group(['middleware' => 'App\Http\Middleware\ZoneAdminMiddleware'],
    function(){
        Route::resource('woredaprogress', 'WoredaProgress');

        Route::post('/storerankworeda', 'SrireController@storerankWoreda');
        Route::resource('rankworeda', 'SrireController');
        Route::resource('rankworedalist', 'SrireController@rankWoredaList');
        Route::post('deleterankworeda', 'SrireController@rankworedadelete');
        Route::post('editrankworeda', 'SrireController@editrankWoreda');

        //Woreda routes
        Route::resource('/woreda', 'WoredaController@index');
        Route::post('/addWoreda', 'WoredaController@addWoreda');
        Route::post('/editWoreda', 'WoredaController@editWoreda');
        Route::post('/deleteWoreda', 'WoredaController@deleteWoreda') ;
    }
);

Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware'],
    function(){
        Route::post('registerUser', [
            'as' => 'register',
            'uses' => 'UserRegisterController@store'
        ]);
        Route::post('registerUser', [
            'as' => 'register',
            'uses' => 'UserRegisterController@store'
        ]);
        //Settings Routes
        Route::resource('/newdocument', 'DocumentsController');

        
        // Route::resource('/newannouncement', 'AnnouncementController');
        Route::post('addnewannouncement', 'AnnouncementController@addannouncement');
        Route::post('editannouncement', 'AnnouncementController@editannouncement');
        Route::post('deleteannouncement', 'AnnouncementController@deleteannouncement');
        Route::get('myform2/ajax/searchtraining/{mtype}','TrainingSettingController@searchtrainingsetting');
        Route::resource('trainingsetting', 'TrainingSettingController');
        Route::resource('yearlysetting', 'YearlySettingsController');
        Route::resource('yearlyedit', 'YearlySettingsController@editYearly');
        Route::resource('yearlydelete', 'YearlySettingsController@deleteYearly');
        Route::resource('mewachosetting', 'MewachoSettingsController');
        Route::resource('mewachoedit', 'MewachoSettingsController@editMewacho');
        Route::resource('mewachodelete', 'MewachoSettingsController@deleteMewacho');
        Route::resource('monthlysetting', 'MonthlySettingController');
        Route::resource('monthlyedit', 'MonthlySettingController@editMonthly');
        Route::resource('monthlydelete', 'MonthlySettingController@deleteMonthly');

        //tabia routes
        Route::get('/tabia', 'tabiaController@index');
        Route::post('/addTabia', 'tabiaController@addTabia');
        Route::post('/editTabia', 'tabiaController@editTabia');
        Route::post('/deleteTabia', 'tabiaController@deleteTabia') ;

        //meseretawiwidabe routes
        Route::Resource('/meseretawiwdabe', 'meseretawiwidabeController@index');
        Route::post('/addWidabe', 'meseretawiwidabeController@addwidabe');
        Route::post('/editWidabe', 'meseretawiwidabeController@editwidabe');
        Route::post('/deleteWidabe', 'meseretawiwidabeController@deletewidabe');
        Route::post('/editTabia', 'tabiaController@editTabia');
        Route::post('/deleteTabia', 'tabiaController@deleteTabia') ;

        //Wahio Routes
        Route::Resource('/wahio', 'wahioController@index');
        Route::post('/addWahio', 'wahioController@addWahio');
        Route::post('/editWahio', 'wahioController@editWahio');
        Route::post('/deleteWahio', 'wahioController@deleteWahio');
        Route::resource('import', 'ImportExcel');
        Route::resource('importexcel', 'ImportExcel@importFile');
        Route::resource('reset', 'ResetPassword');
        Route::resource('actions', 'UserActionController');
        Route::resource('actiondetails', 'UserActionController@details');
        Route::post('resetpassword', 'ResetPassword@reset');

        Route::post('/editeducation', 'EducationController@editeducation');
        Route::post('/deleteducation', 'EducationController@deleteducation');

        Route::post('/editexprience', 'WorkexprienceController@editexprience');
        Route::post('/deletexprience', 'WorkexprienceController@deletexprience');

    });
Route::group(['middleware' => 'App\Http\Middleware\StaffMiddleware'],
    function(){
        // Route::resource('/documentlist', 'DocumentsController@listDocuments');
        Route::get('/download/{title}', 'DocumentsController@download');
        Route::patch('newdocumentupload', 'DocumentsController@upload');
        Route::resource('/regionalreport', 'SixMonthReportController');
        Route::resource('/regionalreportexcel', 'SixMonthReportExcelController');
        Route::resource('/ketemareport', 'KetemaReportNew');
        Route::resource('/ketemareportnew', 'KetemaReportNew');
        Route::resource('/ketemareportexcel', 'KetemaReportExcelNew');
        Route::resource('/ketemareportexcelnew', 'KetemaReportExcelNew');
        Route::resource('/geterreport', 'GeterReportNew');
        Route::resource('/geterreportnew', 'GeterReportNew');
        Route::resource('/geterreportexcelnew', 'GeterReportExcelNew');
        Route::resource('/paymentreport', 'PaymentReport');
        Route::resource('/paymentreportexcel', 'PaymentReport@monthlyExcel');
        Route::resource('/paymentyearlyreport', 'PaymentReport@indexYearly');
        Route::resource('/paymentyearlyreportexcel', 'PaymentReport@yearlyExcel');
        Route::resource('/paymentmewachoreport', 'PaymentReport@indexMewacho');
        Route::resource('/paymentmewachoreportexcel', 'PaymentReport@mewachoExcel');
        Route::resource('/paymentgiftreport', 'PaymentReport@indexGift');
        Route::resource('/paymentgiftreportexcel', 'PaymentReport@giftExcel');
        Route::post('/hitsuypostpone', 'HitsuyMembershipController@postponeHitsuy');
        Route::post('/hitsuyreject', 'HitsuyMembershipController@rejectHitsuy');
        Route::post('/editmember', 'HitsuyMembershipController@editMember');
        Route::resource('membership', 'HitsuyMembershipController');

        Route::post('/hitsuyedit', 'HitsuyController@editMonthly');
        Route::post('/hitsuydelete', 'HitsuyController@deleteMonthly') ;
        Route::resource('hitsuy', 'HitsuyController');
        // Route::resource('directmembership', 'MembershipTemp');
    }
);
Route::get('/', function () {

    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return view('home.web.main'); //return view('auth.login');
});

Route::get ( '/zonelist', function () {
	$zonelist = Zobatat::all ();
	return view ( 'zonepages.index' )->withData ( $data );
} );
Route::get('/home', function () {
    return redirect('/dashboard');
});

Route::auth();

Route::get('/dashboard', 'HomeController@index');
Route::resource('profile', 'ProfileController');

Route::patch('profile/{profile}/password', 'ProfileController@update_password');
Route::resource('admin', 'AdminController');


// Route::get('/memapproval', function () {
//     return View::make('membership.memapproval');
// });
// Route::get('/membersReg', function () {
//     return View::make('membership.membersReg');
// });
// Route::get('/transfer', function () {
//     return View::make('membership.transfer');
// });
// Route::get('/mideba', function () {
//     return View::make('membership.mideba');
// });
// Route::get('/member', function () {
//     return View::make('membership.member');
// });

// Route::get('myformwizard', function()
// {
//     return View::make('leadership.mediumleadershipform');
// });
Route::get('evaluation', function()
{
    return View::make('evaluationpages.evaluation');
});

Route::get('dismissal', function()
{
    return View::make('membership.dismissal');
});
Route::get('main', function()
{
    return View::make('home.web.main');
});
Route::get('about', function()
{
    return View::make('home.web.about');
});
Route::get('structure', function()
{
    return View::make('home.web.structure');
});
Route::get('mehawur', function()
{
    return View::make('home.web.mehawur');
});
Route::get('download', function()
{
    return View::make('home.web.downloads');
});
Route::get('resources', function()
{
    return View::make('home.web.resources');
});
Route::get('vacancy', function()
{
    return View::make('home.web.vacancy');
});
Route::get('contact', function()
{
    return View::make('home.web.contact');
});

// Route::get('penalty', function()
// {
//     return View::make('membership.penalty');
// });
// Route::get('plan', function()
// {
//     return View::make('planing.plan');
// });
Route::get('educationlevel', function()
{
    return View::make('educationlevelpages.educationlevel');
});
Route::get('tariff', function()
{
    return View::make('payment.tariff');
});


// Route::get('trainingsetting', function()
// {
//     return View::make('trainingsettingpages.trainingsetting');
// });


// Route::get ( 'datatable', function () {
   
//     return  View::make('datatable.index');
// } );
// // Route::get('coreDegefti', function()
// // {
// //     return View::make('membership.coreDegefti');
// // });
// Route::get('officeplan', function()
// {
//     return View::make('planing.officeplan');
// });

// Route::get('memberlist', function()
// {
//     return View::make('membership.memberlist');
// });
//


Route::get('/PdfDemo', ['as'=>'PdfDemo','uses'=>'PdfDemoController@index']);

Route::get('/sample-pdf', ['as'=>'SamplePDF','uses'=>'PdfDemoController@samplePDF']);
Route::get('/save-pdf', ['as'=>'SavePDF','uses'=>'PdfDemoController@savePDF']);

Route::get('/download-pdf', ['as'=>'DownloadPDF','uses'=>'PdfDemoController@downloadPDF']);


Route::get('/html-to-pdf', ['as'=>'HtmlToPDF','uses'=>'PdfDemoController@htmlToPDF']);
Route::get('/html-to-pdf1', ['as'=>'HtmlToPDF1','uses'=>'PdfDemoController@htmlToPDF1']);
Route::get('/html-to-pdf2', ['as'=>'HtmlToPDF2','uses'=>'PdfDemoController@htmlToPDF2']);
Route::get('/html-to-pdf3', ['as'=>'HtmlToPDF3','uses'=>'PdfDemoController@htmlToPDF3']);
Route::get('/html-to-pdf4', ['as'=>'HtmlToPDF4','uses'=>'PdfDemoController@htmlToPDF4']);
Route::get('/html-to-pdf5', ['as'=>'HtmlToPDF5','uses'=>'PdfDemoController@htmlToPDF5']);
Route::get('/html-to-pdf6', ['as'=>'HtmlToPDF6','uses'=>'PdfDemoController@htmlToPDF6']);
Route::get('/html-to-pdf7', ['as'=>'HtmlToPDF7','uses'=>'PdfDemoController@htmlToPDF7']);
Route::get('/html-to-pdf8', ['as'=>'HtmlToPDF8','uses'=>'PdfDemoController@htmlToPDF8']);
Route::get('/html-to-pdf9', ['as'=>'HtmlToPDF9','uses'=>'PdfDemoController@htmlToPDF9']);
Route::get('/html-to-pdf10', ['as'=>'HtmlToPDF10','uses'=>'PdfDemoController@htmlToPDF10']);
Route::get('/html-to-pdf11', ['as'=>'HtmlToPDF11','uses'=>'PdfDemoController@htmlToPDF11']);
Route::get('/html-to-pdf12', ['as'=>'HtmlToPDF12','uses'=>'PdfDemoController@htmlToPDF12']);
Route::get('/html-to-pdf13', ['as'=>'HtmlToPDF13','uses'=>'PdfDemoController@htmlToPDF13']);
Route::get('/html-to-pdf14', ['as'=>'HtmlToPDF14','uses'=>'PdfDemoController@htmlToPDF14']);
Route::get('/html-to-pdf15', ['as'=>'HtmlToPDF15','uses'=>'PdfDemoController@htmlToPDF15']);
Route::get('/html-to-pdf16', ['as'=>'HtmlToPDF16','uses'=>'PdfDemoController@htmlToPDF16']);
Route::get('/html-to-pdf17', ['as'=>'HtmlToPDF17','uses'=>'PdfDemoController@htmlToPDF17']);
Route::get('/html-to-pdf18', ['as'=>'HtmlToPDF18','uses'=>'PdfDemoController@htmlToPDF18']);
Route::get('/html-to-pdf19', ['as'=>'HtmlToPDF19','uses'=>'PdfDemoController@htmlToPDF19']);




Route::get('/addworedalist/{id}', 'tabiaController@tabiaController') ;
Route::get('myform/ajax/{zoneCode}','tabiaController@searchworedas');

// Route::get('add-to-log', 'LogController@myTestAddToLog');

// Route::get('logActivity', 'LogController@logActivity');



Route::get('/addworedalist/{id}', 'tabiaController@tabiaController') ;
Route::get('myform2/ajax/{woredacode}','meseretawiwidabeController@searchtabias');


Route::get('/addworedalist/{id}', 'wahioController@tabiaController') ;
Route::get('myform2/ajax/wahio/{tid}','wahioController@searchmeseretawidabe');
Route::get('myform2/ajax/wahio/meseretawi/{mid}','wahioController@searchwahio');
Route::get('myform2/ajax/hitsuy/{wid}','wahioController@searchhitsuy'); 
Route::get('myform2/ajax/allhitsuy/{wid}','wahioController@searchallhitsuy'); 
// Route::get('myform2/ajax/hitsuyposition/{wid}','wahioController@searchpositionhitsuy'); 
Route::get('myform2/ajax/hitsuymeseretawi/{wid}','wahioController@searchhitsuymeseretawi'); 
Route::get('myform2/ajax/mediumleader/{wid}','wahioController@searchmeduimleader');

Route::get('myform2/ajax/topleader/{wid}','wahioController@searchtopleader');
Route::get('myform2/ajax/firstinstantleader/{wid}','wahioController@searchfirstinstantleader');
Route::get('myform2/ajax/expert/{wid}','wahioController@searchexpert');
Route::get('myform2/ajax/lowleader/{wid}','wahioController@searchlowleader');
Route::get('myform2/ajax/taramember/{wid}','wahioController@searchtaramember');

Route::post('/storerankwahio', 'SrireController@storerankWahio');
Route::get('/rankwahiolist', 'SrireController@rankwahioList');
Route::post('/storerankmwidabe', 'SrireController@storerankMwidabe');
Route::get('/rankmwidabe', 'SrireController@rankmwidabeindex');
Route::post('deleterankmwidabe', 'SrireController@rankmwidabedelete');
Route::post('editrankmwidabe', 'SrireController@editrankMwidabe');
Route::get('/rankmwidabelist', 'SrireController@rankmwidabeList');
Route::get('/rankwahio', 'SrireController@rankwahioindex');
Route::post('deleterankwahio', 'SrireController@rankwahiodelete');
Route::post('editrankwahio', 'SrireController@editrankWahio');

// Route::post('/hitsuyadd', 'HitsuyController@store');
// Route::resource('crud', 'HitsuyController');
// Route::get('add-to-log', 'LogController@myTestAddToLog');

// Route::get('logActivity', 'LogController@logActivity');

//hitsuy routes
// Route::post('/hitsuyadd', 'HitsuyController@store');

Route::get('/corelist', 'CoreDegeftiController@listCore');
Route::resource('/leaderlist', 'LeaderList');
Route::resource('/leaderlistexcel', 'LeaderList@leaderListExcel');
Route::get('/corelistexcel', 'CoreDegeftiController@listCoreExcel');
Route::resource('coreDegefti', 'CoreDegeftiController');
Route::get('/core', 'CoreDegeftiController@listCoreTwo');

// Monthly Report
Route::get('/yearlyreport', 'MonthlyController@indexforyearlyreport');
Route::resource('monthlyreport', 'MonthlyController');
// Route::resource('hitsuyinetreport', 'HitsuyinetreportController');
Route::resource('hilwiabalreport', 'hilwiabalreportController');
Route::resource('abalnamerarnreport', 'abalnamerarnreportController');
Route::resource('variationtopleader', 'variationtopleaderController');
Route::resource('totaltopleader', 'totaltopleaderController');
Route::resource('nominattopleader', 'nominattopleaderController');
Route::resource('penalitytopleader', 'penalitytopleaderController');
Route::resource('variationworedaleader', 'variationworedaleaderController'); 
Route::resource('totalworedaleader', 'totalworedaleaderController'); 
Route::resource('penalityworedaleader', 'penalityworedaleaderController');
Route::resource('variationmiddleleader', 'variationmiddleleaderController'); 
Route::resource('totalmiddleleader', 'totalmiddleleaderController');
Route::resource('nominatmiddleleader', 'nominatmiddleleaderController'); 
Route::resource('variation1stleader', 'variation1stleaderController');
Route::resource('total1stleader', 'total1stleaderController');
Route::resource('nominat1stleader', 'nominat1stleaderController');
Route::resource('totalmwnleader', 'totalmwnleaderController'); 
Route::resource('totalmwtleader', 'totalmwtleaderController'); 
Route::resource('totalwnleader', 'totalwnleaderController'); 
Route::resource('totalwtleader', 'totalwtleaderController');
Route::resource('totalleaders', 'totalleadersController');

Route::resource('deanttirahabalat', 'deanttirahabalatController');
// Route::resource('meseretawiwidabenwahion', 'meseretawiwidabenwahionController');


//Membership routes
Route::get('/memberhistory/{title?}', 'MemberHistory@index');
Route::get('/removedlist', 'HitsuyMembershipController@listRemoved');
Route::get('/removedlistexcel', 'HitsuyMembershipController@listRemovedExcel');
Route::get('/hitsuylist', 'HitsuyMembershipController@listHitsuy');
Route::get('/hitsuylistexcel', 'HitsuyMembershipController@listHitsuyExcel');
Route::get('/dismissedlist', 'HitsuyMembershipController@listDismissed');
Route::get('/dismissedlistexcel', 'HitsuyMembershipController@listDismssedExcel');
Route::get('/memberlist', 'HitsuyMembershipController@listMembers');
Route::get('/memberlistexcel', 'HitsuyMembershipController@listMembersExcel');
Route::get('/wahioleaders', 'HitsuyMembershipController@wahioleadersindex');
Route::post('/wahioleaders', 'HitsuyMembershipController@wahioleadersupdate');
Route::get('/meseretawileaders', 'HitsuyMembershipController@meseretawileadersindex');
Route::post('/meseretawileaders', 'HitsuyMembershipController@meseretawileadersupdate');

//Add user
Route::resource('adduser', 'UserRegisterController');
Route::resource('users', 'UserRegisterController@listUsers');

//Penalty Routes
Route::post('/editpenalty', 'PenalityController@editPenality');
Route::post('/deletepenalty', 'PenalityController@deletePenality');
Route::resource('penalty', 'PenalityController');

//transfer Routes
Route::get('/transferlist', 'TransferController@listTransfers');
Route::post('/edittransfer', 'TransferController@editTransfer');
Route::post('/deletetransfer', 'TransferController@deleteTransfer');
Route::resource('transfer', 'TransferController');

//mdeba Routes
Route::post('/editmideba', 'MidebaController@editMideba');
Route::post('/deletemideba', 'MidebaController@deleteMideba');
Route::resource('mideba', 'MidebaController');

//gift route
Route::post('/editgift', 'GiftController@editGift');
Route::post('/deletegift', 'GiftController@deleteGift');
Route::resource('gift', 'GiftController');

//donor route
Route::post('/editdonor', 'DonorController@editDonor');
Route::post('/deletedonor', 'DonorController@deleteDonor');
Route::resource('donor', 'DonorController');

//dismiss route
Route::post('/editdismiss', 'DismissController@editDismiss');
Route::post('/deletedismiss', 'DismissController@deleteDismiss');
Route::resource('dismiss', 'DismissController');

//Education route
Route::get('/educationinfo', 'EducationController@educationIndex');
Route::resource('education', 'EducationController');

//Exprience route
Route::get('/careerinfo', 'WorkexprienceController@exprienceIndex');
Route::resource('exprience', 'WorkexprienceController');

//Training Routes
Route::resource('training', 'TrainingController');

//Payment Routes
Route::get('/mewacho', 'PaymentController@indexformewachomain');
Route::get('/mewachodetail', 'PaymentController@indexformewacho');
Route::get('/monthly', 'PaymentController@indexformonthly');
Route::post('/storemonthly', 'PaymentController@storeMonthly');
Route::resource('monthlylist', 'PaymentController@monthlyList');
Route::post('/storemewacho', 'PaymentController@storeMewacho');
Route::resource('yearly', 'PaymentController');
Route::resource('yearlylist', 'PaymentController@yearlyList');

//Leaders Evaluation Routes
Route::get('/mdmleaderslist', 'MediumLeadersController@middleleadersIndex');
Route::resource('mediumleader', 'MediumLeadersController@middleleadersIndex');
Route::resource('mediumleaderform', 'MediumLeadersController');
Route::post('deletemediumleader', 'MediumLeadersController@deleteMedium');
Route::post('editmediumleader', 'MediumLeadersController@editMedium');
//top leaders evaluaton route
Route::get('/topleaderslist', 'SuperLeaderController@topleadersIndex');
Route::resource('topleader', 'SuperLeaderController@topleadersIndex');
Route::resource('topleaderform', 'SuperLeaderController');
Route::post('edittopleader', 'SuperLeaderController@editTop');
Route::post('deletetopleader', 'SuperLeaderController@deleteTop');
Route::resource('topleaderdetails', 'EvaluationDetailController@topleaderDetails');
Route::resource('mediumleaderdetails', 'EvaluationDetailController@mediumleaderDetails');
Route::resource('firstinstantleaderdetails', 'EvaluationDetailController@firstinstantleaderDetails');
Route::resource('lowleaderdetails', 'EvaluationDetailController@lowleaderDetails');
Route::resource('expertdetails', 'EvaluationDetailController@expertDetails');
Route::resource('teramemberdetails', 'EvaluationDetailController@teramemberDetails');
//first instant leader
Route::get('/1stleaderslist', 'FirstInstantLeadersController@firstinstantleadersIndex');
Route::resource('firstinstantleaderform', 'FirstInstantLeadersController');
Route::resource('firstinstantleader', 'FirstInstantLeadersController@firstinstantleadersIndex');
Route::resource('editfirstinstantleader', 'FirstInstantLeadersController@editFirst');
Route::resource('deletefirstinstantleader', 'FirstInstantLeadersController@deleteFirst');
//expert 
Route::get('/expertslist', 'ExpertsController@expertsIndex');
Route::resource('expertform', 'ExpertsController');
Route::resource('expert', 'ExpertsController@expertsIndex');
Route::resource('editexpert', 'ExpertsController@editExpert');
Route::resource('deleteexpert', 'ExpertsController@deleteExpert');
//lowerleader
Route::get('/lowerleaderslist', 'LowerLeadersController@lowerleadersIndex');
Route::resource('lowleaderform', 'LowerLeadersController');
Route::resource('lowleader', 'LowerLeadersController@lowerleadersIndex');
Route::resource('editlowleader', 'LowerLeadersController@editLower');
Route::resource('deletelowleader', 'LowerLeadersController@deleteLower');
//taramemeber
Route::get('/taramemberslist', 'TaraMembersController@taramembersIndex');
Route::resource('taramember', 'TaraMembersController');
Route::resource('edittaramember', 'TaraMembersController@editTara');
Route::resource('deletetaramember', 'TaraMembersController@deleteTara');

//Planning
Route::resource('officeplan', 'OfficeplanController');
Route::resource('officeplanedit', 'OfficeplanController@editPlan');
Route::resource('officeplandelete', 'OfficeplanController@deletePlan');
Route::resource('zoneplan', 'ZoneplanController');
Route::resource('zoneplanedit', 'ZoneplanController@editPlan');
Route::resource('zoneplandelete', 'ZoneplanController@deletePlan');
Route::resource('woredaplan', 'WoredaplanController');
Route::resource('woredaplanedit', 'WoredaplanController@editPlan');
Route::resource('woredaplandelete', 'WoredaplanController@deletePlan');
Route::resource('meseretawiwidabeplan', 'MeseretawiwidabeaplanController');
Route::resource('meseretawiwidabeplanlist', 'MeseretawiwidabeaplanController@listPlan');
Route::resource('deletemeseretawiwidabeplan', 'MeseretawiwidabeaplanController@delete');
Route::resource('meseretawiwidabeedit', 'MeseretawiwidabeaplanController@editPlan');
Route::resource('meseretawiwidabedelete', 'MeseretawiwidabeaplanController@deletePlan');
Route::resource('wahioplan', 'WahioplanController');
Route::resource('wahioplanlist', 'WahioplanController@listPlan');
Route::resource('deletewahioplan', 'WahioplanController@delete');
Route::resource('wahioedit', 'WahioplanController@editPlan');
Route::resource('wahiodelete', 'WahioplanController@deletePlan');
Route::resource('individualplan', 'IndividualplanController');
Route::resource('individualplanlist', 'IndividualplanController@listPlan');
Route::resource('deleteindividualplan', 'IndividualplanController@delete');


// Auth::routes();

// Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::post('/deleteItem', function(Request $request) {
    Toastr::info("ዞባ ብትኽክል ተደምሲሱ ኣሎ");
	Zobatat::find($request->id)->delete();

	return response()->json();
} );
Route::post('/editItem', function(Request $request) {
	
	$rules = array (
			
			
	);
	$validator = Validator::make ( Input::all (), $rules );
	if ($validator->fails ())
		return Response::json ( array (
				
				'errors' => $validator->getMessageBag ()->toArray () 
		) );
	else {
		
		$data = Zobatat::find ( $request->id );
		$data->code = ($request->fname);
		$data->name = ($request->lname);
		$data->save ();
		Toastr::info("ዞባ ብትኽክል ተስተካኪሉ ኣሎ");
		return response ()->json ( $data );
		 
	}
} );
Route::post('/addItem', function(Request $request) {	
	   		$rules = array (
			
			
	);
	$validator = Validator::make ( Input::all (), $rules );
	if ($validator->fails ())
		return Response::json ( array (
				
				'errors' => $validator->getMessageBag ()->toArray () 
		) );
	else {
		$data = new Zobatat;
		$data->code=($request->fname);
		$data->name=($request->lname);
		Toastr::info("ዞባ ብትኽክል ተፈጢሩ ኣሎ");
		$data->save ();
		
		return response ()->json ( $data );
		
		}
	
} );




