<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Monthly;
use DB;
use Carbon\Carbon;

use Illuminate\Http\Request;

class totalworedaleaderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

         $Tabias = DB::table('hitsuys')
   ->leftjoin('education_informations', 'hitsuys.hitsuyID', '=', 'education_informations.hitsuyID')->get(); 

          $zobatat = DB::table('zobatats')->get();
   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');
   
        
      return view('report.totalworedaleader', compact('Tabias','zobatat'));
        
    }

    public function AgedBetween($query, $start, $end = null)
    {
        if (is_null($end)) {
            $end = $start;
        }
    
        $now = $this->freshTimestamp();
        $start = $now->subYears($start);
        $end = $now->subYears($end)->addYear()->subDay(); // plus 1 year minus a day
    
        return $query->whereBetween('dob', $start, $end);
    }
     public function downloadPDF()
    {   


     // $Tabias = Tabia::all();

        $Tabias = DB::table('tabias')
           ->join('woredas', 'tabias.woredacode', '=', 'woredas.woredacode')->get();

           // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');

           return view('customer', ['Tabias'=>$Tabias]);

        //$Tabias = Tabia::with('tabiatat')->get();
       /* $pdf = PDF::loadView('pdf.customer', ['Tabias'=>$Tabias]);

        $pdf->setPaper('A4', 'landscape');
        //return $pdf->download('review.pdf'); //Download        
        return $pdf->stream('customer.pdf',array("Attachment" => false)); //Stream  
        /*$html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
                <h4>by<br/>Learn Infinity</h4>';
      

        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_SamplePDF.pdf', 'D');*/
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
