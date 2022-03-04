<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\Wahio;
use  App\meseretawiWdabe;
use  App\ApprovedHitsuy;
use  App\Hitsuy;
use App\Constant;
use App\Filter;
use DB;

class wahioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     $filter = Filter::filter_values($request);
     $zoneCode = $filter['zoneCode'];
     $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____') . ($filter['widabe'] ? $filter['widabe']->widabeCode : '_____');
  	 $data = Wahio::with('wahiosmw')->where('parentcode', 'LIKE', $code . '%')->paginate(Constant::PAGE_SIZE);
	   $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	   return view ( 'kebabyawi.wahio', compact('data','zobadatas', 'zoneCode', 'filter'));	
	   
    } 
	        
	public function searchmeseretawidabe($tid)
    {
	  $data = DB::table("meseretawi_wdabes")

                    ->where("tabiaCode",$tid)

                    ->pluck("widabeName","widabeCode");

        return json_encode($data);
    }

	public function searchwahio($mid)
    {
	  $data = DB::table("wahios")

                    ->where("widabeCode",$mid)

                    ->pluck("wahioName","id");

        return json_encode($data);
    }
    public function searchhitsuy($wid)
    {
      $data = DB::table("approved_hitsuys")

                    ->where("assignedWahio",$wid)

                    ->where('approved_status','1')

                    ->pluck("membershipType","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);
            $kv = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("gfname");                                     

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    }
    public function searchallhitsuy($wid)
    {
      $data = DB::table("hitsuys")

                    ->where("proposerWahio",$wid)

                    ->whereIn('hitsuy_status',['ሕፁይ','ሕፁይነት ተናዊሑ','ኣባል'])

                    ->pluck("occupation","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);
            $kv = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("gfname");                                     

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    }

    public function searchhitsuymeseretawi($wid)
    {
      $data = DB::table("approved_hitsuys")

                    ->where("assignedWudabe",$wid)

                    ->where('approved_status','1')

                    ->pluck("membershipType","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);
            $kv = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("gfname");                                     

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    }

    public function searchmeduimleader($wid)
    {
      $data = DB::table("approved_hitsuys")

                    ->where("assignedWahio",$wid)
                    ->where('approved_status','1')
                    ->where("memberType","ማእኸላይ ኣመራርሓ")
                    ->pluck("membershipType","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);
            $kv = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("gfname");                                     

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    }
	public function searchtopleader($wid)
    {
      $data = DB::table("approved_hitsuys")

                    ->where("assignedWahio",$wid)
                    ->where('approved_status','1')
                    ->where("memberType","ላዕለዋይ ኣመራርሓ")
                    ->pluck("membershipType","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);
            $kv = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("gfname");                                     

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    }
     public function searchfirstinstantleader($wid)
    {
      $data = DB::table("approved_hitsuys")

                    ->where("assignedWahio",$wid)
                    ->where('approved_status','1')
                    ->where("memberType","ጀማሪ ኣመራርሓ")
                    ->pluck("membershipType","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);
            $kv = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")

                    ->where("hitsuyID",$key)->pluck("gfname");                                     

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    }  
    public function searchexpert($wid)
    {
      $data = DB::table("approved_hitsuys")
                      ->where("assignedWahio",$wid)
                      ->where('approved_status','1')
                    ->where("memberType","ሰብ ሞያ")
                    //->where([["assignedWahio",$wid],["memberType","ተራ ኣባል"],["approved_hitsuys.occupation",\App\ApprovedHitsuy::ምሁር]["approved_hitsuys.occupation",\App\ApprovedHitsuy::መምህር]])
                    ->pluck("membershipType","hitsuyID");
        $collection = collect([]);         
        foreach ($data as $key => $value) {
            $fn = collect([]);

            $kv = DB::table("hitsuys")
                    
                    ->where("hitsuyID",$key)->pluck("name");
            $kvf = DB::table("hitsuys")
                    
                    ->where("hitsuyID",$key)->pluck("fname");   
            $kvg = DB::table("hitsuys")
                    
                    ->where("hitsuyID",$key)->pluck("gfname"); 
                                                 

               $fn=$fn->prepend($kvg);
               $fn=$fn->prepend($kvf);
               $fn=$fn->prepend($kv);
               $fn=$fn->collapse();
               $fn=$fn->all();
               
               $collection->prepend($fn, $key);                      
        }                            
        return json_encode($collection);
    } 
 

        public function searchlowleader($wid)
        {
          $data = DB::table("approved_hitsuys")

                        ->where("assignedWahio",$wid)
                        ->where('approved_status','1')
                        ->where("memberType","ታሕተዋይ ኣመራርሓ")
                        ->pluck("membershipType","hitsuyID");
            $collection = collect([]);         
            foreach ($data as $key => $value) {
                $fn = collect([]);

                $kv = DB::table("hitsuys")
                        
                        ->where("hitsuyID",$key)->pluck("name");
                $kvf = DB::table("hitsuys")
                        
                        ->where("hitsuyID",$key)->pluck("fname");   
                $kvg = DB::table("hitsuys")
                        
                        ->where("hitsuyID",$key)->pluck("gfname"); 
                                                     

                   $fn=$fn->prepend($kvg);
                   $fn=$fn->prepend($kvf);
                   $fn=$fn->prepend($kv);
                   $fn=$fn->collapse();
                   $fn=$fn->all();
                   
                   $collection->prepend($fn, $key);                      
            }                            
            return json_encode($collection);
        }  
        public function searchtaramember($wid)
        {
          $data = DB::table("approved_hitsuys")

                        ->where("assignedWahio",$wid)
                        ->where('approved_status','1')
                        ->where("memberType","ተራ ኣባል")
                        ->pluck("membershipType","hitsuyID");
            $collection = collect([]);         
            foreach ($data as $key => $value) {
                $fn = collect([]);

                $kv = DB::table("hitsuys")                    
                        ->where("hitsuyID",$key)->pluck("name");
                $kvf = DB::table("hitsuys")                    
                        ->where("hitsuyID",$key)->pluck("fname");   
                $kvg = DB::table("hitsuys")                    
                        ->where("hitsuyID",$key)->pluck("gfname");                                                 
                   $fn=$fn->prepend($kvg);
                   $fn=$fn->prepend($kvf);
                   $fn=$fn->prepend($kv);
                   $fn=$fn->collapse();
                   $fn=$fn->all();
                   
                   $collection->prepend($fn, $key);                      
            }                            
            return json_encode($collection);
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
    
	 public function addWahio(Request $request)
    {       	
      $messages = [            
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ።',
            'min' => ':attribute ልዕሊ :min ክኸውን ኣለዎ',
            'max' => ':attribute ትሕቲ :max ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'date_format' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(), [
		
            'whname' => 'required',
            'widabeCode' => 'required',
            'wtype' => 'in:ሓረስታይ,ደቂ ኣንስትዮ,መንእሰይ,ተምሃሮ,መምህራን,ሰብ ሞያ,ሸቃሎ,መፍረይቲ,ከተማ ሕርሻ,ኮንስትራክሽን,ንግዲ,ግልጋሎት'
        ],$messages);
        $fieldNames = [
            'whname' => 'ሽም ዋህዮ',
            'widabeCode' => 'ዝርከበሉ ውዳበ',
            'wtype' => 'ዓይነት ዋህዮ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!meseretawiWdabe::where('widabeCode',$request->widabeCode)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ውዳበ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Wahio::where('wahioName',$request->whname)->where('widabeCode',$request->widabeCode)->count()){
            $validator->errors()->add('duplicate', 'ዋሀዮ '.$request->tname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
		$dataWahio= new Wahio ;
		$dataWahio->wahioName=($request->whname);	
		$dataWahio->widabeCode=($request->widabeCode);
    $dataWahio->parentcode = (meseretawiWdabe::where('widabeCode',$request->widabeCode)->first()->parentcode . $request->widabeCode);
    $dataWahio->type = ($request->wtype);
		        
		$dataWahio->save();
		return [true, 'info', "ዋሀዮ ብትኽክል ተፈጢሩ ኣሎ", $dataWahio->id];
		
    }
	 public function editWahio(Request $request)
    {
      $messages = [            
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ።',
            'min' => ':attribute ልዕሊ :min ክኸውን ኣለዎ',
            'max' => ':attribute ትሕቲ :max ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'date_format' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(), [
            'wcode' => 'required',
            'whname' => 'required',
            'widabeCode' => 'required',
            'wtype' => 'in:ሓረስታይ,ደቂ ኣንስትዮ,መንእሰይ,ተምሃሮ,መምህራን,ሰብ ሞያ,ሸቃሎ,መፍረይቲ,ከተማ ሕርሻ,ኮንስትራክሽን,ንግዲ,ግልጋሎት'
        ],$messages);
        $fieldNames = [
            'wcode' => 'ዋህዮ ኮድ',
            'whname' => 'ሽም ዋህዮ',
            'widabeCode' => 'ዝርከበሉ ውዳበ',
            'wtype' => 'ዓይነት ዋህዮ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!meseretawiWdabe::where('widabeCode',$request->widabeCode)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ውዳበ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Wahio::where('wahioName',$request->whname)->where('type', $request->type)->where('widabeCode',$request->widabeCode)->count()){
            $validator->errors()->add('duplicate', 'ዋሀዮ '.$request->tname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
    $dataWahio = Wahio::find ( $request->wcode );
    $dataWahio->wahioName=($request->whname);   
    $dataWahio->widabeCode = ($request->widabeCode); 
    $dataWahio->parentcode = (meseretawiWdabe::where('widabeCode',$request->widabeCode)->first()->parentcode . $request->widabeCode);
    $dataWahio->type = ($request->wtype);
    $dataWahio->save ();
    return [true, 'info', "ዋህዮ ተስተኻኺሉ ኣሎ"];
  }
  public function deleteWahio(Request $request)
    {
        $data = Wahio::find($request->code);
        if($data){
            $data->delete();
            return [true, 'ዋህዮ ጠፊኡ ኣሎ'];
        }
        return [true, "ዋህዮ ክርከብ ኣይኸኣለን"];
    }


   

   
   
		 
	}
    

