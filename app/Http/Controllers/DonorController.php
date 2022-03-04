<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Donor;
use DB;
use App\Constant;
use Illuminate\Http\Request;

class DonorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $data = Donor::paginate(Constant::PAGE_SIZE);
       return view ('payment.donor')->withData($data);
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
            'date_format' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'after' => 'ዝውውር ዝጅምረሉ ዕለት ካብ ዝውውር ዘብቅዐሉ ዕለት ክቕድም ኣለዎ'
        ];
        //
        $validator = \Validator::make($request->all(),[ 
            'donorType' => 'required',            
            'donorName' => 'required',
            'occupationArea' => 'required',
            'address' => 'required'
        ],$messages);
        $fieldNames = [
        'donorType' => 'ዓይነት ለጋሲ',            
        'donorName' => 'ሽም ለጋሲ',
        'occupationArea' => 'ዝተዋፈርሉ ዘርፊ',
        'address' => 'ኣድራሻ'
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        $append="donor";
        $today=date("Y-m-d");        
        $yearsub = substr($today,0,4);
        $monthsub = substr($today,5,2);
        $daysub = substr($today,8,2);
        $yearValue=intval($yearsub);
        $monthValue=intval($monthsub);
        $dayValue=intval($daysub);
        if (12 >=($monthValue) && ($monthValue) >= 10){ //if month value is between 10-12, subtract 8
            $year=$yearValue-7;
        }else if (8 >=($monthValue) && ($monthValue) >= 1){ //if month value is between 1-8, subtract 7
            $year=$yearValue-8;
        }else if ( ($monthValue) == 9){ //if month value is 9, check date subtract 8
            if (10 >=($dayValue) && ($dayValue) >= 1){
                $year=$yearValue-8;
            }else if (30 >=($dayValue) && ($dayValue) >= 11){
                $year=$yearValue-7;
            }else{
                
            }                
        }else{
                
        } 
        $year = substr($year,2,2);
        $year=intval($year);
        $lastDonor = Donor::orderBy('created_at', 'desc')->first();
        if($lastDonor){ //if there is last Donor            
            $mID = substr($lastDonor->donorId,6,4); //staring at 7th and length 3
            $lastID=sprintf('%04d', intval($mID) + 1);
            $finalID="$append/".$lastID."/".$year;
        }else{
            $finalID="$append/0001/".$year;
        }

        $donor = new Donor;
        $donor->donorId = $finalID;
        $donor->donorType = $request->donorType;
        $donor->donorName = $request->donorName;
        $donor->occupationArea = $request->occupationArea;
        $donor->address = $request->address;
        $donor->save();   
        Toastr::info("ለጋሲ ብትኽክል ተመዝጊቡ ኣሎ");
        return back();
    }
    public function editDonor(Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'id' => 'required',
            'donorType' => 'required',
            'donorName' => 'required',
            'occupationArea' => 'required',
            'address' => 'required'
            ],
            [
            'date_format' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ'
            ]);
        $fieldNames = [
        "id" => "ኮድ",
        "donorType" => "ዓይነት ለጋሲ",
        "donorName" => "ሽም ለጋሲ",
        "occupationArea" => "ዝተዋፈረሉ ዘርፊ",
        'address' => 'ኣድራሻ'];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Donor::where('donorId', $request->donorId)->count()){
            $validator->errors()->add('duplicate', 'ለጋሲ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
       $edi = Donor::find($request->id);
       $edi->donorType = $request->donorType;
        $edi->donorName = $request->donorName;
        $edi->occupationArea = $request->occupationArea;
        $edi->address = $request->address;
        $edi->save();           
        return [true, 'info', "ለጋሲ ብትኽክል ተስተኻኺሉ ኣሎ"];
    }
    public function deleteDonor(Request $request)
    {
     
    $donat =Donor::find($request->id)->delete();
    return [true, "ለጋሲ ብትኽክል ተሰሪዙ ኣሎ"];

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
