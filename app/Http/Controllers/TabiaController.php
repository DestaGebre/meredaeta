<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use App\Filter;
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
       $filter = Filter::filter_values($request);
       $zoneCode = $filter['zoneCode'];
       $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___');
  	   $data = Tabia::with('tabiatat')->where('parentcode', 'LIKE', $code . '%')->get();
	   $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	   return view ( 'geoStructure.tabia', compact('data','zobadatas', 'zoneCode', 'filter'));
	   
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
       
			
		// $dataTabia= new Tabia;
  //       $dataTabia->woredacode=($request->wcode);
  //       $dataTabia->tabiaName=($request->tname);    
  //       $dataTabia->tabiaCode=($request->tcode);                
  //       $dataTabia->isUrban=($request->urban);      
  //       $dataTabia->save ();
  //       return response ()->json ( $dataTabia );
  //       Toastr::info("ጣብያ ብትኽክል ተፈጢሩ ኣሎ");
 		
		

    }
    public function adjust($val, $place){
        $len = strlen($val);
        for($i = 0; $i < $place - $len; $i++){
            $val = '0' . $val;
        }
        return $val;
    }
	 public function addTabia(Request $request)
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
            'tname' => 'required',
            'urban' => 'required'
        ],$messages);
        $fieldNames = [
            'wcode' => 'ዝርከበሉ ወረዳ',
            'tname' => 'ሽም ጣብያ',
            'urban' => 'ዓይነት ጣብያ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!Woreda::where('woredacode',$request->wcode)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ወረዳ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Tabia::where('tabiaName',$request->tname)->where('woredacode',$request->wcode)->count()){
            $validator->errors()->add('duplicate', 'ጣብያ '.$request->tname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
		
		$dataTabia= new Tabia;
		$dataTabia->woredacode=($request->wcode);
    $dataTabia->parentcode = (Woreda::where('woredacode',$request->wcode)->first()->zoneCode . $request->wcode);
		$dataTabia->tabiaName=($request->tname);
    if(!Tabia::select('tabiaCode')/*->where('woredacode', $request->wcode)*/->orderBy('tabiaCode','desc')->first()) {
        $dataTabia->tabiaCode = "0001";
    }
    else{
        $dataTabia->tabiaCode = $this->adjust(Tabia::select('tabiaCode')/*->where('woredacode', $request->wcode)*/->orderBy('tabiaCode','desc')->first()->toArray()['tabiaCode']+1, 4);
    }
		$dataTabia->isUrban=($request->urban);
		$dataTabia->save();
		return [true, 'info', "ጣብያ ብትኽክል ተፈጢሩ ኣሎ",$dataTabia->tabiaCode];
		
    }
    public function editTabia(Request $request)
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
            'tcode' => 'required',
            'wcode' => 'required',
            'tname' => 'required',
            'urban' => 'required'
        ],$messages);
        $fieldNames = [
            'tcode' => 'ጣብያ ኮድ',
            'wcode' => 'ዝርከበሉ ወረዳ',
            'tname' => 'ሽም ጣብያ',
            'urban' => 'ዓይነት ጣብያ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!Woreda::where('woredacode',$request->wcode)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ወረዳ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Tabia::where('tabiaName',$request->tname)->where('isUrban',$request->urban)->where('woredacode',$request->wcode)->count()){
            $validator->errors()->add('duplicate', 'ጣብያ '.$request->tname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
       $data = Tabia::find ( $request->tcode );
        $data->woredacode=($request->wcode);
        $data->parentcode = (Woreda::where('woredacode',$request->wcode)->first()->zoneCode . $request->wcode);
        $data->tabiaName=($request->tname);    
        $data->isUrban = ($request->urban);
        $data->save();
        
        return [true, 'info', 'ጣብያ ተስትኻኺሉ ኣሎ'];
        
    }
	
	public function deleteTabia(Request $request)
    {
        $data = Tabia::where('tabiaCode', $request->code);
          if($data){
              $data->delete();
              return [true, 'ጣብያ ጠፊኡ ኣሎ'];
          }
          return [true, "ጣብያ ክርከብ ኣይኸኣለን"];
    }

   
    public function edit($id)
    {
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

    }

   
   
		 
	}
    

