<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\meseretawiWdabe;
use DB;

class meseretawiwidabeController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

  	   $data = Tabia::with('tabiatat')->get();
	   $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	   return view ( 'meseretawiwdabepages.meseretawiwdabe', compact('data','zobadatas'));	
	   
    } 
	
        public function myformAjax($id)
    {
        $cities = DB::table("demo_cities")
                    ->where("state_id",$id)
                    ->pluck("name","id");
        return json_encode($cities);
    }
    public function searchtabias($woredacode)
    {
	  $data = DB::table("tabias")

                    ->where("woredacode",$woredacode)

                    ->pluck("tabiaName","tabiaCode");

        return json_encode($data);
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
       
			
		$zoba = new Zobatat;
        $zoba->name = $request->name;
		$zoba->code = $request->code;
        $zoba->save();   
        Toastr::info("ወረዳ ብትኽክል ተፈጢሩ ኣሎ");
		return back();
 		
		

    }
	 public function addwidabe(Request $request)
    {
       
		
		$dataMwidabe= new meseretawiWdabe;
		$dataMwidabe->tabiaCode=($request->tbid);
		
		$dataMwidabe->widabeName=($request->wname);	
        $dataMwidabe->widabeCode=($request->wcode);	
		$dataMwidabe->save ();
		return response ()->json ( $dataMwidabe );
		Toastr::info("ውዳበ ብትኽክል ተፈጢሩ ኣሎ");
		
    }
	public function editZone(Request $request)
    {
	  $data = Zobatat::find ( $request->id );
		$data->code = ($request->fname);
		$data->name = ($request->lname);
		$data->save ();
		
		return response ()->json ( $data );
		Toastr::info("ወረዳ ብትኽክል ተስተካኪሉ ኣሎ");
	}
	public function deleteWoreda(Request $request)
    {
     
	Woreda::find($request->id)->delete();
   
	return response()->json();
	 Toastr::info("ወረዳ ብትኽክል ተደምሲሱ ኣሎ");
}

   
    public function edit($id)
    {
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

    }

   
   
		 
	}
    

