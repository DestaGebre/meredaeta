<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\MonthlySetting;

class MonthlySettingController extends Controller
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
         $data = MonthlySetting::all ();
	   return view ( 'settings.monthlysetting' )->withData ( $data );
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
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ።',
            'min' => ':attribute ልዕሊ :min ክኸውን ኣለዎ',
            'max' => ':attribute ትሕቲ :max ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(), [
            'code' => 'required',
            'from' => 'required|numeric',
            'to' => 'required|numeric',
            'percent' => 'required|numeric|min:0|max:100'
        ],$messages);
        $fieldNames = [
        'code' => 'ኮድ',
        'from' => 'ደመወዝ ካብ',
        'to' => 'ደመወዝ ክሳብ',
        'percent' => 'ፐርሰንት'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $monthly = new MonthlySetting;
        $monthly->code = $request->code;
		$monthly->from = $request->from;
		$monthly->to = $request->to;
		$monthly->percent = $request->percent/100;
        $monthly->save();   
        return[true, 'info', "ወርሓዊ ክፍሊት ብትኽክል ተፈጢሩ ኣሎ"];
    }
    function editMonthly(Request $request){
        $messages = [            
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ።',
            'min' => ':attribute ልዕሊ :min ክኸውን ኣለዎ',
            'max' => ':attribute ትሕቲ :max ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(), [
            'code' => 'required',
            'from' => 'required|numeric',
            'to' => 'required|numeric',
            'percent' => 'required|numeric|min:0|max:100'
        ],$messages);
        $fieldNames = [
        'code' => 'ኮድ',
        'from' => 'ደመወዝ ካብ',
        'to' => 'ደመወዝ ክሳብ',
        'percent' => 'ፐርሰንት'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $monthly = MonthlySetting::find ( $request->code );
        $monthly->from = $request->from;
        $monthly->to = $request->to;
        $monthly->percent = $request->percent/100;
        $monthly->save();   
        return[true, 'info', "ወርሓዊ ክፍሊት ተስተኻኪሉ ኣሎ"];
    }
    function deleteMonthly(Request $request){
        $monthly = MonthlySetting::where ('code', $request->code );
        $monthly->delete();
        return [true, "ወርሓዊ ክፍሊት ተሰሪዙ ኣሎ"];
    }
}
