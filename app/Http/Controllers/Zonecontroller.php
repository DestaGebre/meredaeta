<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Zobatat;

use Illuminate\Http\Request;




class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
        $data = Zobatat::all ();
	   return view ( 'geoStructure.zone' )->withData ( $data );
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
        Toastr::info("ዞባ ብትኽክል ተፈጢሩ ኣሎ");
		return back();
 		
		

    }

    public function adjust($val, $place){
        $len = strlen($val);
        for($i = 0; $i < $place - $len; $i++){
            $val = '0' . $val;
        }
        return $val;
    }

	 public function addZone(Request $request)
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
            'name' => 'required'
        ],$messages);
        $fieldNames = [
        'name' => 'ሽም ዞባ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Zobatat::where('zoneName',$request->name)->count()){
            $validator->errors()->add('duplicate', 'ዞባ '.$request->name.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
		$data = new Zobatat;
        if(!Zobatat::select('zoneCode')->orderBy('zoneCode','desc')->first()){
            $data->zoneCode = "01";
        }
        else{
            $data->zoneCode = $this->adjust(Zobatat::select('zoneCode')->orderBy('zoneCode','desc')->first()->toArray()['zoneCode']+1,2);
        }
		$data->zoneName=($request->name);
		$data->save ();

        return[true, 'info', "ዞባ ብትኽክል ተፈጢሩ ኣሎ",$data->zoneCode];
		
		

    }
	public function editZone(Request $request)
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
            'name' => 'required',
            'code' => 'required'
        ],$messages);
        $fieldNames = [
        'name' => 'ሽም ዞባ',
        'code' => 'ኮድ'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        else if(Zobatat::where('zoneName',$request->name)->count()){
            $validator->errors()->add('duplicate', 'ዞባ '.$request->name.' ኣብ መዝገብ ኣሎ እዩ');
            return [false, 'error', $validator->errors()->all()];
        }
	    $data = Zobatat::find ( $request->code );
		$data->zoneName = ($request->name);
		$data->save ();
		
		return[true, 'info', "ዞባ ተስተኻኺሉ ኣሎ",$data->zoneCode];
		
	}
	  public function deleteZone(Request $request)
    { 
    	$data =Zobatat::find($request->code);
        if($data){
            $data->delete();
            return [true, "ዞባ ብትኽክል ተሰሪዙ ኣሎ"];
        }
        return [true, "ዞባ ክርከብ ኣይኸኣለን"];
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
        $crud = Zobatat::find($id);
        
        return view('pages.zoneedit', compact('crud','id'));

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
        $crud = Zobatat::find($id);
        $crud->name = $request->get('name');
       
        $crud->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
		 
	}
    

