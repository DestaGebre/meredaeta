<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Monthly;

use Illuminate\Http\Request;

class MonthlyController extends Controller
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
        $data = Monthly::all ();
	   return view ( 'payment.monthly' )->withData ( $data );
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
        
        $payment = new Monthly;
        $payment->memberID = $request->memberID;
		$payment->salary = $request->salary;
		$payment->memberID = $request->amount;
		$payment->salary = $request->month;
		$payment->memberID = $request->year;
        $payment->save();   
        Toastr::info("payment ብትኽክል ተፈጢሩ ኣሎ");
		return back();
    }
	public function editMonthly(Request $request)
    {
	   $data = Monthly::find ( $request->fname );
		$data->memberID = $request->memberID;
		$data->salary = $request->salary;
		$data->amount = $request->amount;
		$data->month = $request->month;
		$data->year = $request->year;
        $data->save();
		
		return response ()->json ( $data );
		
	}
	  public function deleteMonthly(Request $request)
    {
     
	$data =Monthly::find($request->id)->delete();
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
