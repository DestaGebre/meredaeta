<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Hitsuy;
use App\DateConvert;

use  App\Zobatat;
use  App\Woreda;
use App\Tabia;
use App\meseretawiWdabe;
use App\Wahio;
use App\Constant;
use App\UserAction;
use DB;

use Illuminate\Http\Request;

class HitsuyController extends Controller
{
   
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('guest');
    // }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
			  
        ]);
    }
 
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
      $data = Hitsuy::all ();
      $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
	  return view ( 'membership.hitsuy',compact('data','zobadatas'));
        
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

    public function adjust($val, $place){
        $len = strlen($val);
        for($i = 0; $i < $place - $len; $i++){
            $val = '0' . $val;
        }
        return $val;
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
            'after'      => 'ዕለት ትውልዲ ዕለት ካብ ዝተመልመለሉ ዕለት ክቕድም ኣለዎ',
            'required' => ':attribute ብትኽክል ኣይኣተወን',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'digits' => 'ቑፅሪ ስልኪ 10 ድጂት ክኸውን ኣለዎ'

        ];
        // validate each attribute, $errors should be placed in the view
        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'fname' => 'required',
            'gfname' => 'required',
            'gender' => 'required|in:ተባ,ኣን', 
            'birthPlace' => 'required',            
            'occupation' => 'required|in:መምህራን,ተምሃሮ,ሰብ ሞያ,ደኣንት,ሸቃሎ,ገባር',
            'sme' => 'in:መፍረይቲ,ንግዲ,ግልጋሎት,ኮስንትራክሽን,ከተማ ሕርሻ',
            // 'position' => 'required|alpha',
            // 'fileNumber' => 'required', 
            //'address' => 'required|alpha_num',                         
            'tell' => 'digits:10',
            'dob' => 'required|ethiopian_date',
            'regDate' => 'required|ethiopian_date',
            'educationlevel' => 'required|in:ዘይተምሃረ,ቀለም,1,2,3,4,5,6,7,8,9,10,11,12,ሰርቲፊኬት,ዲፕሎማ,ዲግሪ,ማስተርስ,ፒ.ኤች.ዲ'

        ],$messages);
        $fieldNames = [
        'name' => 'ሽም ሕፁይ',            
        'fname' => 'ሽም ኣቦ',
        'gfname' => 'ሽም ኣቦሓጎ',
        'gender' => 'ፆታ', 
        'birthPlace' => 'ትውልዲ ቦታ',
        'occupation' => 'ማሕበራዊ መሰረት',
        'sme' => 'ደኣንት',
        'position' => 'ሓላፍነት',
        'fileNumber' => 'ቑፅሪ ፋይል', 
        //'address' => 'required|alpha_num',                         
        'tell' => 'ቑፅሪ ስልኪ',
        'email' => 'ኢሜይል',
        'dob' => 'ዕለት ትውልዲ',
        'regDate' => 'ዝተመልመለሉ ዕለት',
        'educationlevel' => 'ደረጃ ትምህርቲ'
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if(!Zobatat::where('zoneCode', $request->zone)->count()){
            $validator->errors()->add('duplicate', 'ዞባ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!Woreda::where('woredacode', $request->woreda)->count()){
            $validator->errors()->add('duplicate', 'ወረዳ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!Tabia::where('tabiaCode', $request->tabiaID)->count()){
            $validator->errors()->add('duplicate', 'ጣብያ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->count()){
            $validator->errors()->add('duplicate', 'መሰረታዊ ውዳበ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!Wahio::where('id', $request->proposerWahio)->count()){
            $validator->errors()->add('duplicate', 'ዋህዮ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(array_search(Auth::user()->usertype, ['zone', 'zoneadmin']) !== false) {
            if(Auth::user()->area != $request->zone){
                $validator->errors()->add('duplicate', 'ሕፁይ ንምምዝጋብ እኹል ፍቓድ ኣይብሎምን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        if(array_search(Auth::user()->usertype, ['woreda', 'woredaadmin']) !== false) {
            if(Auth::user()->area != $request->woreda){
                $validator->errors()->add('duplicate', 'ሕፁይ ንምምዝጋብ እኹል ፍቓድ ኣይብሎምን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if($request->occupation == 'ደኣንት' && !$request->sme){
          $validator->errors()->add('duplicate', 'ዓይነት ደኣንት ኣይተመልአን');
          return redirect()->back()->withErrors($validator)->withInput();
        }

        //Generating Customized ID,
        // $year="10";
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
        $zoneCode = $request->zone;
        $worCode = $request->woreda;
        $tabCode = $request->tabiaID;
        $zwtCode="$zoneCode$worCode$tabCode"; //this should be tabiaCode??should be set,
        $lastHitsuy = Hitsuy::where('hitsuyID','LIKE',$zwtCode.'%')->orderBy('hitsuyID', 'desc')->first();
        if($lastHitsuy){ //if there is last Hitsuy            
            $mID = substr($lastHitsuy->hitsuyID,10,6); //starting at 7th and length 3
            $lastID=sprintf('%06d', intval($mID) + 1);
            $finalID="$zwtCode/".$lastID;//."/".$year;
        }else{
            $finalID="$zwtCode/000001";//.$year;
        }


		$newMem = new Hitsuy;
    $newMem->hitsuyID = $finalID;
    $newMem->name = trim($request->name);
		$newMem->fname = trim($request->fname);
		$newMem->gfname = trim($request->gfname);
		$newMem->gender = $request->gender;
		$newMem->birthPlace = $request->birthPlace;
		$newMem->dob = DateConvert::correctDate($request->dob);
    if($request->occupation == 'ደኣንት'){
      $newMem->occupation = $request->sme;
    }
    else{
      $newMem->occupation = $request->occupation;
    }
		$newMem->position = $request->position;
		$newMem->sme = '';
		$newMem->regDate = DateConvert::correctDate($request->regDate);
        $newMem->proposerWidabe = $request->proposerWidabe;
		$newMem->proposerWahio = $request->proposerWahio;
		$newMem->proposerMem = $request->proposerMem;
		$newMem->fileNumber = $request->fileNumber;
		$newMem->region = $request->region;
		$newMem->tabiaID = $request->tabiaID;
		$newMem->address = $request->address;
        $newMem->educationlevel = $request->educationlevel;
        $newMem->skill = $request->skill;
		$newMem->tell = $request->tell;
		$newMem->email = $request->email;
		$newMem->isRequested = $request->isRequested;		
		$newMem->hasPermission = $request->hasPermission;
		$newMem->isWilling = $request->isWilling;
		$newMem->isReportedWahioHalafi = $request->isReportedWahioHalafi;
		$newMem->isReportedWahioMem = $request->isReportedWahioMem;
    $newMem->save(); 
    Toastr::info("ሕፁይ ብትኽክል ተፈጢሩ ኣሎ");
        UserAction::storeAction('', 'hitsuys', Constant::CREATE, Constant::HITSUY, ['መ.ቁ' => $request->hitsuyID,'ሽም' => $request->name,'ሽም ኣቦ' => $request->fname, 'ፆታ' => $request->gender, 'ዕለት ትውልዲ' => $request->dob, 'ዝተመልመለሉ ዕለት' => $request->regDate, 'ማሕበራዊ መሰረት' => $request->occupation,  'ውዳበ' => $request->proposerWidabe], false, []);  
		return back();

    }
    
	public function edithitsuy(Request $request)
    {
      $messages = [
            'after'      => 'ዕለት ትውልዲ ዕለት ካብ ዝተመልመለሉ ዕለት ክቕድም ኣለዎ',
            'required' => ':attribute ብትኽክል ኣይኣተወን',
            'alpha' => ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'digits' => 'ቑፅሪ ስልኪ 10 ድጂት ክኸውን ኣለዎ'

        ];
        // validate each attribute, $errors should be placed in the view
        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'fname' => 'required',
            'gfname' => 'required',
            'gender' => 'required|in:ተባ,ኣን', 
            'birthPlace' => 'required',            
            'occupation' => 'required|in:መምህራን,ተምሃሮ,ሰብ ሞያ,ደኣንት,ሸቃሎ,ገባር',
            'sme' => 'in:መፍረይቲ,ንግዲ,ግልጋሎት,ኮስንትራክሽን,ከተማ ሕርሻ',
            // 'position' => 'required|alpha',
            // 'fileNumber' => 'required', 
            //'address' => 'required|alpha_num',                         
            'tell' => 'digits:10',
            'dob' => 'required|ethiopian_date',
            'regDate' => 'required|ethiopian_date',
            'educationlevel' => 'required|in:ዘይተምሃረ,ቀለም,1,2,3,4,5,6,7,8,9,10,11,12,ሰርቲፊኬት,ዲፕሎማ,ዲግሪ,ማስተርስ,ፒ.ኤች.ዲ'

        ],$messages);
        $fieldNames = [
        'name' => 'ሽም ሕፁይ',            
        'fname' => 'ሽም ኣቦ',
        'gfname' => 'ሽም ኣቦሓጎ',
        'gender' => 'ፆታ', 
        'birthPlace' => 'ትውልዲ ቦታ',
        'occupation' => 'ማሕበራዊ መሰረት',
        'sme' => 'ደኣንት',
        'position' => 'ሓላፍነት',
        'fileNumber' => 'ቑፅሪ ፋይል', 
        //'address' => 'required|alpha_num',                         
        'tell' => 'ቑፅሪ ስልኪ',
        'email' => 'ኢሜይል',
        'dob' => 'ዕለት ትውልዲ',
        'regDate' => 'ዝተመልመለሉ ዕለት',
        'educationlevel' => 'ደረጃ ትምህርቲ'
        ];
        $validator->setAttributeNames($fieldNames);
        $validator->validate();
        if(!Zobatat::where('zoneCode', $request->zone)->count()){
            $validator->errors()->add('duplicate', 'ዞባ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!Woreda::where('woredacode', $request->woreda)->count()){
            $validator->errors()->add('duplicate', 'ወረዳ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!Tabia::where('tabiaCode', $request->tabiaID)->count()){
            $validator->errors()->add('duplicate', 'ጣብያ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!meseretawiWdabe::where('widabeCode', $request->proposerWidabe)->count()){
            $validator->errors()->add('duplicate', 'መሰረታዊ ውዳበ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(!Wahio::where('id', $request->proposerWahio)->count()){
            $validator->errors()->add('duplicate', 'ዋህዮ ኣብ መዝገብ የለን');
            return redirect()->back()->withErrors($validator)->withInput();
        }
        if(array_search(Auth::user()->usertype, ['zone', 'zoneadmin']) !== false) {
            if(Auth::user()->area != $request->zone){
                $validator->errors()->add('duplicate', 'ሕፁይ ንምምዝጋብ እኹል ፍቓድ ኣይብሎምን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }
        if(array_search(Auth::user()->usertype, ['woreda', 'woredaadmin']) !== false) {
            if(Auth::user()->area != $request->woreda){
                $validator->errors()->add('duplicate', 'ሕፁይ ንምምዝጋብ እኹል ፍቓድ ኣይብሎምን');
                return redirect()->back()->withErrors($validator)->withInput();
            }
        }

        if($request->occupation == 'ደኣንት' && !$request->sme){
          $validator->errors()->add('duplicate', 'ዓይነት ደኣንት ኣይተመልአን');
          return redirect()->back()->withErrors($validator)->withInput();
        }

	   $newMem = Hitsuy::find ( $request->id );
        $newMem->name = trim($request->name);
		$newMem->fname = trim($request->fname);
		$newMem->gfName = trim($request->gfName);
		$newMem->gender = $request->gender;
		$newMem->birthPlace = $request->birthPlace;
		$newMem->dob = $request->dob;
		$newMem->occupation = $request->occupation;
		$newMem->position = $request->position;
		$newMem->sme = $request->sme;
		$newMem->regDate = $request->regDate;
		$newMem->proposerWahio = $request->proposerWahio;
		$newMem->proposerMem = $request->proposerMem;
		$newMem->fileNumber = $request->fileNumber;
		$newMem->region = $request->region;
		$newMem->tabiaID = $request->tabiaID;
		$newMem->address = $request->address;
		$newMem->tell = $request->tell;
		$newMem->email = $request->email;
		$newMem->isRequested = $request->isRequested;
		$newMem->isRequested = $request->isRequested;
		$newMem->hasPermission = $request->hasPermission;
		$newMem->isWilling = $request->isWilling;
		$newMem->isReportedWahioHalafi = $request->isReportedWahioHalafi;
		$newMem->isReportedWahioMem = $request->isReportedWahioMem;
        $newMem->save();   
        
		$data->save ();
		
		return response ()->json ( $newMem );
		
	}
	  public function deleteHitsuy(Request $request)
    {
     
    	$data =Hitsuy::find($request->id)->delete();
        Toastr::info("ህፁይ ብትኽክል ተስተካኪሉ ኣሎ");
    	return response()->json($data);	
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
        //
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
