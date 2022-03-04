<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\TrainingSetting;
use DB;

class TrainingSettingController extends Controller
{
    //
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index()
    {
         $data = TrainingSetting::all ();
       return view ( 'settings.trainingsetting' )->withData ( $data );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function searchtrainingsetting($mtype)
    {
	  $data = DB::table("training_settings")

                    ->where("trainee",$mtype)

                    ->pluck("trainingname","id");

        return json_encode($data);
    }
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $training = new TrainingSetting;
        $training->trainingname = $request->trainingname;
        $training->trainee = $request->trainee;
        $training->traininglength = $request->traininglength;
        $training->deadline = $request->deadline;
        $training->save();   
        Toastr::info("ዞባ ብትኽክል ተፈጢሩ ኣሎ");
        return back();
    }
}
