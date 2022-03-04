<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda;





class WoredaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
      
  	   $data = Woreda::with('zonat')->get();
	   $zobadata =Zobatat::all ();
	   return view ( 'woredapages.index', compact('data','zobadata'));
    } 
        
    public function zonelist()
    {
       
		
		
		

		return response ()->json ( $zobadata );
		
		

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
	 public function addWoreda(Request $request)
    {
       
		
		$dataworeda = new Woreda;
		$dataworeda->zoneCode=($request->zcode);
		$dataworeda->name=($request->wname);
		$dataworeda->woredacode=($request->wcode);
		$dataworeda->isUrban=($request->urban);		
		$dataworeda->save ();
		return response ()->json ( $dataworeda );
		Toastr::info("ወረዳ ብትኽክል ተፈጢሩ ኣሎ");
		
		
		
		
	
		

    }
	public function editWoreda(Request $request)
    {
	   $data = Woreda::find ( $request->wcode );
		$data->zoneCode = ($request->zonecode);
		$data->name = ($request->woredaname);
		$data->isUrban = ($request->urban);
		$data->save ();
		
		return response ()->json ( $data );
		
	}
	public function deleteWoreda(Request $request)
    {
     
	$data =Woreda::find($request->id)->delete();
    
	return response()->json($data);
}

   
    public function edit($id)
    {
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

    }

   
   
		 
	}
    

