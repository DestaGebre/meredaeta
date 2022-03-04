<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;

use PDF;
use DB;
use App\Tabia;
use App\Woreda;

class PdfDemoController extends Controller
{
	public function index(){

        $Tabias = DB::table('hitsuys')
   ->join('midebas', 'hitsuys.hitsuyID', '=', 'midebas.hitsuyID')->get(); 


   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');

        
      return view('customer', ['Tabias'=>$Tabias]);
    	
    }

    public function samplePDF()
    {
       /* $html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
        		<h4>by<br/>Learn Infinity</h4>';
      

        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output('SamplePDF.pdf'); */
    }


    public function savePDF()
    {    
    	/*
        $html_content = '<h1>Generate a PDF using TCPDF in laravel </h1>
        		<h4>by<br/>Learn Infinity</h4>';
      

        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(public_path(uniqid().'_SamplePDF.pdf'), 'F'); */
    }


    

    public function downloadPDF()
    {

         $Tabias = DB::table('hitsuys')
   ->leftjoin('education_informations', 'hitsuys.hitsuyID', '=', 'education_informations.hitsuyID')->get(); 

          $zobatat = DB::table('zobatats')->get();
   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');
   
        
      return view('report.hilwiabalreport', compact('Tabias','zobatat'));
        
    }


    public function HtmlToPDF()
    {    

    //	$Tabias = Tabia::all();

//$Tabias = DB::table('tabias')
  // ->join('woredas', 'tabias.woredacode', '=', 'woredas.woredacode')->get();
   $Tabias = DB::table('hitsuys')
   ->join('midebas', 'hitsuys.hitsuyID', '=', 'midebas.hitsuyID')->get(); 

$zobatat = DB::table('zobatats')->get();
   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');
   
        
      
   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');

    	
       //return view('customer', ['Tabias'=>$Tabias]);
       

        $pdf = PDF::loadView('pdf.customer', ['zobatat'=>$zobatat]);
        //$pdf->setPaper([0, 0, 596.85, 1085.98], 'landscape');
        $pdf->setPaper('A4', 'landscape');
        //$pdf->loadHTML($cart_body);//body -> html content which needs to be converted as pdf..
        //$pdf->render();
        //$output = $dompdf->output();
        return $pdf->stream('hilwiabalreport.pdf'); //Stream  */
        //$pdf->setPaper([0, 0, 685.98, 396.85], 'landscape');
        //return $pdf->download('review.pdf'); //Download        
        


        /*$view = \View::make('HtmlToPDF');
        $html_content = $view->render();
      

        PDF::SetTitle('Sample PDF');
        PDF::AddPage();
        PDF::writeHTML($html_content, true, false, true, false, '');

        PDF::Output(uniqid().'_SamplePDF.pdf'); */
    }
    public function HtmlToPDF1()
    {    

    //  $Tabias = Tabia::all();

//$Tabias = DB::table('tabias')
  // ->join('woredas', 'tabias.woredacode', '=', 'woredas.woredacode')->get();
   $Tabias = DB::table('hitsuys')->get(); 


   // DB::table('woredas')->where('Mekelle', $Tabias)->pluck('name');

      
       //return view('customer', ['Tabias'=>$Tabias]);
       

        $pdf = PDF::loadView('pdf.wesekngudiletnreport', ['Tabias'=>$Tabias]);
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


    public function HtmlToPDF2()
    {    
        $weredatat = DB::table('woredas')->get(); 
        $pdf = PDF::loadView('pdf.variationtopleader', ['weredatat'=>$weredatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('variationtopleader.pdf'); //Stream  */
    }
    public function HtmlToPDF3()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totaltopleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totaltopleader.pdf'); //Stream  */
    }
public function HtmlToPDF4()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.nominattopleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('nominattopleader.pdf'); //Stream  */
    }
    public function HtmlToPDF5()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.penalitytopleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('penalitytopleader.pdf'); //Stream  */
    }
    public function HtmlToPDF6()
    {    
        $weredatat = DB::table('woredas')->get();  
        $pdf = PDF::loadView('pdf.variationmiddleleader', ['weredatat'=>$weredatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('variationmiddleleader.pdf'); //Stream  */
    }
    public function HtmlToPDF7()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalmiddleleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalmiddleleader.pdf'); //Stream  */
    }
    public function HtmlToPDF8()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.nominatmiddleleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('nominatmiddleleader.pdf'); //Stream  */
    }
    public function HtmlToPDF9()
    {    
        $weredatat = DB::table('woredas')->get(); 
        $pdf = PDF::loadView('pdf.variationworedaleader', ['weredatat'=>$weredatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('variationworedaleader.pdf'); //Stream  */
    }
    public function HtmlToPDF10()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalworedaleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalworedaleader.pdf'); //Stream  */
    }
public function HtmlToPDF11()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.penalityworedaleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('penalityworedaleader.pdf'); //Stream  */
    }
    public function HtmlToPDF12()
    {    
        $weredatat = DB::table('woredas')->get(); 
        $pdf = PDF::loadView('pdf.variation1stleader', ['weredatat'=>$weredatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('variation1stleader.pdf'); //Stream  */
    }
    public function HtmlToPDF13()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.total1stleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('total1stleader.pdf'); //Stream  */
    }
    public function HtmlToPDF14()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.nominat1stleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('nominat1stleader.pdf'); //Stream  */
    }
    public function HtmlToPDF15()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalwtleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalwtleader.pdf'); //Stream  */
    }
    public function HtmlToPDF16()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalwnleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalwnleader.pdf'); //Stream  */
    }
    public function HtmlToPDF17()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalmwtleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalmwtleader.pdf'); //Stream  */
    }
    public function HtmlToPDF18()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalmwnleader', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalmwnleader.pdf'); //Stream  */
    }
     public function HtmlToPDF19()
    {    
        $zobatat = DB::table('zobatats')->get(); 
        $pdf = PDF::loadView('pdf.totalleaders', ['zobatat'=>$zobatat]);
        $pdf->setPaper('A4', 'landscape');        
        return $pdf->stream('totalleaders.pdf'); //Stream  */
    }

}