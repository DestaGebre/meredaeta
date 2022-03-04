<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Donor;
use  App\Gift;
use App\Constant;
use App\DateConvert;
use DB;

use Illuminate\Http\Request;

class GiftController extends Controller
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
        $data = Gift::paginate(Constant::PAGE_SIZE);
      //$donordatas=Donor::all();
       $donordatas = DB::table("donors")->pluck('donorName','donorId');
	   return view ('payment.gift',compact('data','donordatas'));


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


    public function correctDate($date){
        return date('Y-m-d',strtotime(str_replace('/','-',$date)));
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
            'donorId' => 'required',
            'giftType' => 'required',            
            'purpose' => 'required',
            'giftName' => 'required',
            'valuation' => 'required|numeric',
            'status' => 'required',
            'donationDate' => 'required|ethiopian_date'
        ],$messages);
        $fieldNames = [
        'donorId' => 'መፍለዪ ቑፅሪ ወሃቢ',
        'giftType' => 'ዓይነት ውህብቶ',            
        'purpose' => 'ዕላማ ውህብቶ',
        'giftName' => 'ሽም ውህብቶ',
        'valuation' => 'ግምት ውህብቶ',
        'status' => 'ኩነታት ውህብቶ',
        'donationDate' => 'ዝተዋሃበሉ ዕለት'
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if(!Donor::where('donorId', $request->donorId)->count()){
            $validator->errors()->add('duplicate', 'ለጋሲ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $gift = new Gift;
        $gift->donorId = $request->donorId;
		$gift->giftType = $request->giftType;
		$gift->purpose = $request->purpose;
		$gift->giftName = $request->giftName;
		$gift->valuation = $request->valuation;
		$gift->status = $request->status;
		$gift->donationDate = DateConvert::correctDate($request->donationDate);
        $gift->save();   
        Toastr::info("ውህብቶ ብትኽክል ተመዝጊቡ ኣሎ");
		return back();
    }
	public function editGift(Request $request)
    {
        //
        $validator = \Validator::make($request->all(),[ 
            'id' => 'required',
            'donorId' => 'required',
            'giftType' => 'required|in:ተሽከርከርቲ,ህንፃ,ቀዋሚ ንብረት,ሃላቂ ኣቕሓ,ጥረ ገንዘብ',
            'purpose' => 'required',
            'giftName' => 'required',
            'valuation' => 'required|numeric',
            'status' => 'required|in:ቃል ዝተኣተወ,ዝተወሃበ',
            'donationDate' => 'required|ethiopian_date'
        ],[
            'date_format' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'numeric' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'after' => 'ዝውውር ዝጅምረሉ ዕለት ካብ ዝውውር ዘብቅዐሉ ዕለት ክቕድም ኣለዎ'
        ]);
        $fieldNames = [
        'id' => 'ኮድ',
        'donorId' => 'መፍለዪ ቑፅሪ ወሃቢ',
        'giftType' => 'ዓይነት ውህብቶ',            
        'purpose' => 'ዕላማ ውህብቶ',
        'giftName' => 'ሽም ውህብቶ',
        'valuation' => 'ግምት ውህብቶ',
        'status' => 'ኩነታት ውህብቶ',
        'donationDate' => 'ዝተዋሃበሉ ዕለት'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }

	    $donation = Gift::find ( $request->id );
		$donation->giftType = $request->giftType;
		$donation->purpose = $request->purpose;
		$donation->giftName = $request->giftName;
		$donation->valuation = $request->valuation;
		$donation->status = $request->status;
		$donation->donationDate = DateConvert::correctDate($request->donationDate);
        $donation->save();   
        return [true, 'info', "ውህብቶ ብትኽክል ተስተኻኺሉ ኣሎ"];
		
	}
	public function deleteGift(Request $request)
    {
     
    	$donation =Gift::find($request->id)->delete();
        return [true, "ልገሳ ብትኽክል ተሰሪዙ ኣሎ"];
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
        $crud = Gift::find($id);
        
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
