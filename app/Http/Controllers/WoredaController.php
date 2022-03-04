<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda;
use App\Filter;
use DB;

class WoredaController extends Controller
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
       $code = ($zoneCode ? $zoneCode : '__');
  	   $data = Woreda::with('zonat')->where('zoneCode', '=', $code)->get();
	   $zobadata =Zobatat::all ();
       $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	   return view ( 'geoStructure.woreda', compact('data','zobadata','zobadatas', 'zoneCode', 'filter'));
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
    public function adjust($val, $place){
        $len = strlen($val);
        for($i = 0; $i < $place - $len; $i++){
            $val = '0' . $val;
        }
        return $val;
    }
	 public function addWoreda(Request $request)
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
            'zcode' => 'required',
            'wname' => 'required',
            'urban' => 'required'
        ],$messages);
        $fieldNames = [
            'zcode' => 'ዝርከበሉ ዞባ',
            'wname' => 'ሽም ወረዳ',
            'urban' => 'ዓይነት ወረዳ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!Zobatat::where('zoneCode',$request->zcode)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ዞባ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Woreda::where('name',$request->wname)/*->where('zoneCode',$request->zcode)*/->count()){
            $validator->errors()->add('duplicate', 'ወረዳ '.$request->wname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
  		$dataworeda = new Woreda;
  		$dataworeda->zoneCode=($request->zcode);
  		$dataworeda->name=($request->wname);
        if(!Woreda::select('woredacode')/*->where('zoneCode', $request->zcode)*/->orderBy('woredacode','desc')->first()){
            $dataworeda->woredacode = "001";
        }
        else{
  		    $dataworeda->woredacode = $this->adjust(Woreda::select('woredacode')/*->where('zoneCode', $request->zcode)*/->orderBy('woredacode','desc')->first()->toArray()['woredacode']+1, 3);
        }
  		$dataworeda->isUrban=($request->urban);		
  		$dataworeda->save ();
		return[true, 'info', "ወረዳ ብትኽክል ተፈጢሩ ኣሎ",$dataworeda->woredacode];

    }
	public function editWoreda(Request $request)
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
            'wcode' =>'required',
            'zcode' => 'required',
            'wname' => 'required',
            'urban' => 'required'
        ],$messages);
        $fieldNames = [
            'wcode' => 'ወረዳ ኮድ',
            'zcode' => 'ዝርከበሉ ዞባ',
            'wname' => 'ሽም ወረዳ',
            'urban' => 'ዓይነት ወረዳ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!Zobatat::where('zoneCode',$request->zcode)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ዞባ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Woreda::where('name',$request->wname)->where('isUrban',$request->urban)/*->where('zoneCode',$request->zcode)*/->count()){
            $validator->errors()->add('duplicate', 'ወረዳ '.$request->wname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
	   $data = Woreda::find ( $request->wcode );
		 $data->zoneCode = ($request->zcode);
		 $data->name = ($request->wname);
		 $data->isUrban = ($request->urban);
		 $data->save ();
		
		return [true, 'info', 'ወረዳ ተስትኻኺሉ ኣሎ'];
		
	}
	public function deleteWoreda(Request $request)
    {
     
    	$data =Woreda::where('woredacode', $request->code);
      if($data){
          $data->delete();
          return [true, 'ወረዳ ጠፊኡ ኣሎ'];
      }
      return [true, "ወረዳ ክርከብ ኣይኸኣለን"];
    }

   
    public function edit($id)
    {
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

    }

   
   
		 
	}
    

