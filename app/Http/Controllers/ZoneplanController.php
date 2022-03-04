<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Zoneplan;
use DB;

class ZoneplanController extends Controller
{
    //
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index()
    {
         $data = Zoneplan::all ();
         $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	   return view ( 'planing.zoneplan',compact('data','zobadatas'));	   
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
        $messages = [            
            'required' => ':attribute ኣይተመልአን',
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'min' => ':attribute ድሕሪ 1950 ክኸውን ኣለዎ',
            'max' => ':attribute ቅድሚ '.(date('Y')-7).' ክኸውን ኣለዎ',
            'digits' => ':attribute በዓል ኣርባዕተ ኣሃዝ ክኸውን ኣለዎ'
        ];
        //
        $validator = \Validator::make($request->all(),[
            'zonecode' => 'required',
            'planyear' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7),
            'plantype' => 'required|in:ነበርቲ ተራ ኣባላት,ጠርነፍቲ መ/ውዳበ ዋህዮ,ኣባላት ተመሃሮ,ናይ ሰብ ሞያ,ጀማሪ ኣመራርሓ,ማእኸላይ ኣመራርሓ,ላዕለዋይ ኣመራርሓ',
            'amount' => 'required|integer',
            'descrpt' => 'required'
        ],$messages);
        $fieldNames = [
        'zonecode' => 'ዞባ',
        'planyear' => 'ዓመት ትልሚ',
        'plantype' => 'ዓይነት ትልሚ',
        'amount' => 'በዝሒ',
        'descrpt' => 'መብርሂ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $office = new Zoneplan;
        $office->zonecode = $request->zonecode;
        $office->planyear = $request->planyear;
		$office->plantype = $request->plantype;
		$office->amount = $request->amount;
		$office->descrpt = $request->descrpt;
        $office->save();
		return [true, "info", "ትልሚ ዞባ ብትኽክል ተፈጢሩ ኣሎ", $office->id];
		// return response ()->json ( $request->amount );
    }
    public function editPlan(Request $request){
        $messages = [            
            'required' => ':attribute ኣይተመልአን',
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'min' => ':attribute ድሕሪ 1950 ክኸውን ኣለዎ',
            'max' => ':attribute ቅድሚ '.(date('Y')-7).' ክኸውን ኣለዎ',
            'digits' => ':attribute በዓል ኣርባዕተ ኣሃዝ ክኸውን ኣለዎ'
        ];
        //
        $validator = \Validator::make($request->all(),[
            'id' => 'required',
            // 'zonecode' => 'required',
            'planyear' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7),
            'plantype' => 'required|in:ነበርቲ ተራ ኣባላት,ጠርነፍቲ መ/ውዳበ ዋህዮ,ኣባላት ተመሃሮ,ናይ ሰብ ሞያ,ጀማሪ ኣመራርሓ,ማእኸላይ ኣመራርሓ,ላዕለዋይ ኣመራርሓ',
            'amount' => 'required|integer',
            'descrpt' => 'required'
        ],$messages);
        $fieldNames = [
        'id' => 'ተራ ቑፅሪ',
        'zonecode' => 'ዞባ',
        'planyear' => 'ዓመት ትልሚ',
        'plantype' => 'ዓይነት ትልሚ',
        'amount' => 'በዝሒ',
        'descrpt' => 'መብርሂ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $data = Zoneplan::find ( $request->id );
        // $data -> zonecode = $request -> zonecode;
        $data -> planyear = $request -> planyear;
        $data -> plantype = $request -> plantype;
        $data -> amount = $request -> amount;
        $data -> descrpt = $request -> descrpt;
        $data -> save();

        return [true, "info", "ትልሚ ዞባ ተስተኻኺሉ ኣሎ", $data->id];
    }
    public function deletePlan(Request $request){
        Zoneplan::find($request->id)->delete();
        return [true, "ት፡ልሚ ዞባ ተሰሪዙ ኣሎ"];
    }
}
