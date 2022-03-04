<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use DB;
use  App\ApprovedHitsuy;
use App\TopLeader;
use  App\Zobatat;

class TopLeadersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index()
    {
       $data = ApprovedHitsuy::where('approved_status','1')->get();    
       $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        
        return view ('leadership.topleadershipform',compact('data','zobadatas')); 
        
    }
     public function topleadersIndex()
    {
        //
        $data=TopLeader::all();    
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");
        $woredaname = DB::table("woredas")->pluck("name","woredacode");
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");   
        return view ('leadership.tleaderslist',compact('data','zobadatas','tabiadata','woredaname','woredadata') );
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        //
         $data = new TopLeader;
        $data->hitsuyID = $request->hitsuyID;
        $data->answer1 = $request->answer1;
        $data->answer2 = $request->answer2;
        $data->answer3 = $request->answer3;
        $data->answer4 = $request->answer4;
        $data->answer5 = $request->answer5;
        $data->answer6 = $request->answer6;
        $data->answer7 = $request->answer7;
        $data->answer8 = $request->answer8;
        $data->answer9 = $request->answer9;
        $data->answer10 = $request->answer10;
        $data->answer11 = $request->answer11;
        $data->answer12 = $request->answer12;
        $data->answer13 = $request->answer13;
        $data->answer14 = $request->answer14;
        $data->answer15 = $request->answer15;
        //$data->answer16 = $request->answer16;
        $data->result1 = $request->result1;
        $data->result2 = $request->result2;
        $data->result3 = $request->result3;
        $data->result4 = $request->result4;
        $data->result5 = $request->result5;
        $data->result6 = $request->result6;
        $data->result7 = $request->result7;
        $data->result8 = $request->result8;
        $data->result9 = $request->result9;
        $data->result10 = $request->result10;
        $data->result11 = $request->result11;
        $data->result12 = $request->result12;
        $data->result13 = $request->result13;
       // $data->result14 = $request->result14;     
        $data->remark = $request->remark;     
        $data->save();  
  
        Toastr::info("ላዕለዋይ ኣመራርሓ መምልኢ ማህደር ብትኽክል ተመዝጊቡ ኣሎ");
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
