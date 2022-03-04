<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use  App\ApprovedHitsuy;
use  App\Zobatat;
use  App\Woreda; 
use  App\Tabia;
use  App\meseretawiWdabe;
use App\Constant;
use App\Filter;
use DB;

class meseretawiwidabeController extends Controller
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
       $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____');
  	   $data = meseretawiWdabe::with('widabes')->where('parentcode', 'LIKE', $code . '%')->paginate(Constant::PAGE_SIZE);
	   $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	   return view ( 'partyStructure.meseretawiwdabe', compact('data','zobadatas', 'zoneCode', 'filter'));
	   
    } 
	       
    public function searchtabias($woredacode)
    {
	  $data = DB::table("tabias")

                    ->where("woredacode",$woredacode)

                    ->pluck("tabiaName","tabiaCode");

        return json_encode($data);
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
	 public function addwidabe(Request $request)
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
            'tbid' => 'required',
            'wname' => 'required',
            'wtype' => 'in:ገባር,ተምሃሮ,መምህራን,ሰብ ሞያ,ሸቃሎ,መፍረይቲ,ከተማ ሕርሻ,ኮንስትራክሽን,ንግዲ,ግልጋሎት'
        ],$messages);
        $fieldNames = [
            'tbid' => 'ዝርከበሉ ጣብያ',
            'wname' => 'ሽም ውዳበ',
            'wtype' => 'ዓይነት ውዳበ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!Tabia::where('tabiaCode',$request->tbid)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ጣብያ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(meseretawiWdabe::where('widabeName',$request->wname)->where('tabiaCode',$request->tbid)->count()){
            $validator->errors()->add('duplicate', 'መሰረታዊ ውዳበ '.$request->tname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }

		$dataMwidabe= new meseretawiWdabe;
		$dataMwidabe->tabiaCode=($request->tbid);
        $dataMwidabe->parentcode = (Tabia::where('tabiaCode',$request->tbid)->first()->parentcode .$request->tbid);
		$dataMwidabe->widabeName=($request->wname);
        $dataMwidabe->type=($request->wtype);
        if(!meseretawiWdabe::select('widabeCode')/*->where('woredacode', $request->wcode)*/->orderBy('widabeCode','desc')->first()) {
            $dataMwidabe->widabeCode = "00001";
        }
        else {
            $dataMwidabe->widabeCode = $this->adjust(meseretawiWdabe::select('widabeCode')/*->where('woredacode', $request->wcode)*/->orderBy('widabeCode','desc')->first()->toArray()['widabeCode']+1, 5);
        }
		$dataMwidabe->save();
		return [true, 'info', "ውዳበ ብትኽክል ተፈጢሩ ኣሎ",$dataMwidabe->widabeCode];
		
    }
	public function editWidabe(Request $request)
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
            'tbid' => 'required',
            'wname' => 'required',
            'wcode' => 'required',
            'wtype' => 'in:ገባር,ተምሃሮ,መምህራን,ሰብ ሞያ,ሸቃሎ,መፍረይቲ,ከተማ ሕርሻ,ኮንስትራክሽን,ንግዲ,ግልጋሎት'
        ],$messages);
        $fieldNames = [
            'tbid' => 'ዝርከበሉ ጣብያ',
            'wname' => 'ሽም ውዳበ',
            'wcode' => 'ውዳበ ኮድ',
            'wtype' => 'ዓይነት ውዳበ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(!Tabia::where('tabiaCode',$request->tbid)->count()){
            $validator->errors()->add('not found', 'ዝርከበሉ ጣብያ ኣብ መዝገብ የለን');
            return [false, 'error', $validator->errors()->all()];
        }
        else if(meseretawiWdabe::where('widabeName',$request->wname)->where('tabiaCode',$request->tbid)->where('type', $request->wtype)->count()){
            $validator->errors()->add('duplicate', 'መሰረታዊ ውዳበ '.$request->tname.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
	    $dataMwidabe = meseretawiWdabe::find($request->wcode);
		$dataMwidabe->widabeName=($request->wname);   
        $dataMwidabe->tabiaCode=($request->tbid);
        $dataMwidabe->parentcode = (Tabia::where('tabiaCode',$request->tbid)->first()->parentcode .$request->tbid);
        if($dataMwidabe->type != $request->wtype){
            ApprovedHitsuy::where('assignedWudabe', $request->wcode)->update(['wudabeType' => $request->wtype]);
        }
        $dataMwidabe->type=($request->wtype); 
		$dataMwidabe->save ();
		
		return [true, 'info', "ውዳበ ተስተኻኺሉ ኣሎ"];
	}
	public function deleteWidabe(Request $request)
    {
        $data = meseretawiWdabe::find($request->code);
          if($data){
              $data->delete();
              return [true, 'መሰረታዊ ውዳበ ጠፊኡ ኣሎ'];
          }
          return [true, "መሰረታዊ ውዳበ ክርከብ ኣይኸኣለን"];
    }

   
    public function edit($id)
    {
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

    }

   
   
		 
	}
    

