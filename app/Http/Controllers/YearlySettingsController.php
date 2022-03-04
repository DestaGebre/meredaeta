<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\YearlySetting;

class YearlySettingsController extends Controller
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
         $data = YearlySetting::all ();
       return view ( 'settings.yearlysetting' )->withData ( $data );
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
            'code' => 'required|numeric',
            'type' => 'required',
            'amount' => 'required|numeric',
        ],$messages);
        $fieldNames = [
        'code' => 'ኮድ',
        'type' => 'ዓይነት ኣባል',
        'amount' => 'መጠን ክፍሊት'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $year = new YearlySetting;
        $year->code = $request->code;
        $year->type = $request->type;
        $year->amount = $request->amount;
        $year->save();   
        return[true, 'info', "ዓመታዊ ክፍሊት ተመዝጊቡ ኣሎ"];
    }
    public function editYearly(Request $request)
    {
        $messages = [            
            'required' => ':attribute ብትኽክል ኣይኣተወን።',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ።',
            'min' => ':attribute ልዕሊ :min ክኸውን ኣለዎ',
            'max' => ':attribute ትሕቲ :max ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(), [
            'code' => 'required|numeric',
            'type' => 'required',
            'amount' => 'required|numeric',
        ],$messages);
        $fieldNames = [
        'code' => 'ኮድ',
        'type' => 'ዓይነት ኣባል',
        'amount' => 'መጠን ክፍሊት'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }

        $year = YearlySetting::find ( $request->code );
        $year->type = $request->type;
        $year->amount = $request->amount;
        $year->save();   
        return[true, 'info', "ዓመታዊ ክፍሊት ተስተኻኪሉ ኣሎ"];
    }
    function deleteYearly(Request $request){
        $yearly = YearlySetting::where ('code', $request->code );
        $yearly->delete();
        return [true, "ወርሓዊ ክፍሊት ተሰሪዙ ኣሎ"];
    }
}
