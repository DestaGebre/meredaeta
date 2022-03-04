<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Monthly;
use DB;

use Illuminate\Http\Request;

class deanttirahabalatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){

        $Tabias = DB::table('hitsuys')
   ->join('midebas', 'hitsuys.hitsuyID', '=', 'midebas.hitsuyID')->get(); 


   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');

        
      return view('report.deanttirahabalat', ['Tabias'=>$Tabias]);
        return view('PdfDemo');
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


    public function HtmlToPDF()
    {    

    //  $Tabias = Tabia::all();

//$Tabias = DB::table('tabias')
  // ->join('woredas', 'tabias.woredacode', '=', 'woredas.woredacode')->get();
   $Tabias = DB::table('hitsuys')
   ->join('midebas', 'hitsuys.hitsuyID', '=', 'midebas.hitsuyID')->get(); 


   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');

        
       //return view('customer', ['Tabias'=>$Tabias]);
       

        $pdf = PDF::loadView('pdf.customer', ['Tabias'=>$Tabias]);
        //$pdf->setPaper([0, 0, 596.85, 1085.98], 'landscape');
        $pdf->setPaper('A4', 'landscape');
        //$pdf->loadHTML($cart_body);//body -> html content which needs to be converted as pdf..
        //$pdf->render();
        //$output = $dompdf->output();
        return $pdf->stream('customer.pdf'); //Stream  */
        //$pdf->setPaper([0, 0, 685.98, 396.85], 'landscape');
        //return $pdf->download('review.pdf'); //Download        
        


        /*$view = \View::make('HtmlToPDF');
        $html_content = $view->render();
      

        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_SamplePDF.pdf'); */
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
