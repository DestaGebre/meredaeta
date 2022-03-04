<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use DB;

class tabiaController extends Controller
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
	   return view ( 'tabiapages.index', compact('data','zobadatas'));	
	   
    } 
	
        public function myformAjax($id)
    {
        $cities = DB::table("demo_cities")
                    ->where("state_id",$id)
                    ->pluck("name","id");
        return json_encode($cities);
    }
    public function searchworedas($zoneCode)
    {
	  $cities = DB::table("woredas")

                    ->where("zonecode",$zoneCode)

                    ->pluck("name","woredacode");

        return json_encode($cities);
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
	 public function addTabia(Request $request)
    {
       
		
		$dataTabia= new Tabia;
		$dataTabia->woredacode=($request->wcode);
		$dataTabia->tabiaName=($request->tname);	
        $dataTabia->tabiaCode=($request->tcode);				
		$dataTabia->isUrban=($request->urban);		
		$dataTabia->save ();
		return response ()->json ( $dataTabia );
		Toastr::info("ጣብያ ብትኽክል ተፈጢሩ ኣሎ");
		
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
    

