<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Zobatat;

use Illuminate\Http\Request;




class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $data = Zobatat::all ();
	   return view ( 'zonepages.index' )->withData ( $data );
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
        Toastr::info("ዞባ ብትኽክል ተፈጢሩ ኣሎ");
		return back();
 		
		

    }
	 public function addZone(Request $request)
    {
       
		
		$data = new Zobatat;
		$data->zoneCode=($request->fname);
		$data->zoneName=($request->lname);
		$data->save ();

		return response ()->json ( $data );
		Toastr::info("ዞባ ብትኽክል ተፈጢሩ ኣሎ");
		

    }
	public function editZone(Request $request)
    {
	   $data = Zobatat::find ( $request->fname );
		$data->zoneCode = ($request->fname);
		$data->zoneName = ($request->lname);
		$data->save ();
		
		return response ()->json ( $data );
		
	}
	  public function deleteZone(Request $request)
    {
     
	$data =Zobatat::find($request->id)->delete();
    Toastr::info("ዞባ ብትኽክል ተስተካኪሉ ኣሎ");
	return response()->json($data);
	
	
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
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

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
        $crud = Zobatat::find($id);
        $crud->name = $request->get('name');
       
        $crud->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
		 
	}
    

