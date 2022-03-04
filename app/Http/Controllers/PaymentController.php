<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Hitsuy;
use  App\ApprovedHitsuy;
use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use App\Yearly;
use App\Monthly;
use App\Mewacho;
use App\MewachoSetting;
use App\Constant;
use App\Filter;
use DB;

use App\DateConvert;

class PaymentController extends Controller
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
    public function index(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->whereNotIn('occupation', ["ሲቪል ሰርቫንት", "መምህር", "ሰብ ሞያ"])/*->where('approved_status','1')*/;
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $mwidabedata = DB::table("meseretawi_wdabes")->pluck("widabeName","widabeCode");
        $wahiodata = DB::table("wahios")->pluck("wahioName","id");
        $yearlydata = DB::table("yearly_settings")->pluck("amount","type");

        $query1 = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->whereNotIn('occupation', ["ሲቪል ሰርቫንት", "መምህር", "ሰብ ሞያ"])/*->where('approved_status','1')*/;
        if($filter['widabe']){
            $query1 = $query1->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query1 = $query1->where('assignedWahio', $filter['wahio']->id);
        }

        $tempdata = $query1->pluck("membershipType","hitsuyID");
        $collectionyear = collect([]);       
        foreach ($tempdata as $key => $value) {
            $lastYear = Yearly::where('hitsuyID',$key)->orderBy('year', 'desc')->pluck('year')->first();
            $collectionyear->prepend($lastYear, $key);
        }
        
        return view('payment.yearly',compact('data','zobadatas','wahiodata','mwidabedata','collectionyear','yearlydata', 'zoneCode', 'filter'));
    }
    public function yearlyList(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $paid = $filter['paid'];
        $query = DB::table('approved_hitsuys')->join('hitsuys', 'hitsuys.hitsuyID', '=', 'approved_hitsuys.hitsuyID')->join('yearlies', 'yearlies.hitsuyID', '=', 'approved_hitsuys.hitsuyID')->where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->whereNotIn('approved_hitsuys.occupation', ["ሲቪል ሰርቫንት", "መምህር", "ሰብ ሞያ"])/*->where('approved_status','1')*/;
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        if($year && $paid !== '0'){
            $query = $query->where('yearlies.year', $year);
        }
        else if($year){
            $query = $query->where('yearlies.year', '!=', $year);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        
        return view('payment.yearlylist',compact('data','zobadatas', 'zoneCode', 'filter'));   
    }
    public function monthlyList(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $month = $filter['month'];
        $paid = $filter['paid'];
        $query = DB::table('approved_hitsuys')->join('hitsuys', 'hitsuys.hitsuyID', '=', 'approved_hitsuys.hitsuyID')->join('monthlies', 'monthlies.hitsuyID', '=', 'approved_hitsuys.hitsuyID')->where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->whereNotIn('approved_hitsuys.occupation', ["ሲቪል ሰርቫንት", "መምህር", "ሰብ ሞያ"])/*->where('approved_status','1')*/;
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $months = ['መስከረም', 'ጥቅምቲ', 'ሕዳር', 'ታሕሳስ', 'ጥሪ', 'ለካቲት', 'መጋቢት', 'ሚያዝያ', 'ግንቦት', 'ሰነ', 'ሓምለ', 'ነሓሰ'];
        if($year && $month>0 && $month<13 && $paid !== '0'){
            $query = $query->where('monthlies.year', $year)->where('monthlies.month', $months[$month-1]);
        }
        else if($year && $month>0 && $month<13){
            $query = $query->where('monthlies.year', '!=', $year)->where('monthlies.month', '!=', $months[$month-1]);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        
        return view('payment.monthlylist',compact('data','zobadatas', 'zoneCode', 'filter'));   
    }
    public function indexformonthly(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->whereIn('occupation', ["ሲቪል ሰርቫንት", "መምህር", "ሰብ ሞያ"])/*->where('approved_status','1')*/;
        if($filter['widabe']){
            $query = $query->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query = $query->where('assignedWahio', $filter['wahio']->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $mwidabedata = DB::table("meseretawi_wdabes")->pluck("widabeName","widabeCode");
        $wahiodata = DB::table("wahios")->pluck("wahioName","id");
        $monthlydata = DB::table("monthly_settings")->select("percent","from","to")->get()->toArray();

        $query1 = ApprovedHitsuy::where('zoneworedaCode','LIKE', $filter['new_value'] . '%')->whereIn('occupation', ["ሲቪል ሰርቫንት", "መምህር", "ሰብ ሞያ"])/*->where('approved_status','1')*/;
        if($filter['widabe']){
            $query1 = $query1->where('assignedWudabe', $filter['widabe']->widabeCode);
        }
        if($filter['wahio']){
            $query1 = $query1->where('assignedWahio', $filter['wahio']->id);
        }

        $tempdata = $query1->pluck("membershipType","hitsuyID");
        $collectionyear = collect([]);       
        $collectionmonth = collect([]);
        $collectionamount = collect([]);
        foreach ($tempdata as $key => $value) {
            $lastYear = Monthly::where('hitsuyID',$key)->orderBy('updated_at', 'desc')->pluck('year')->first();
            $lastmonth = Monthly::where('hitsuyID',$key)->orderBy('updated_at', 'desc')->pluck('month')->first();
            $lastamount = Monthly::where('hitsuyID',$key)->orderBy('updated_at', 'desc')->pluck('amount')->first();
            $collectionmonth->prepend($lastmonth, $key);
            $collectionyear->prepend($lastYear, $key);
            $collectionamount->prepend($lastamount, $key);
        }
        
        return view ('payment.monthly',compact('data','zobadatas','wahiodata','mwidabedata','collectionyear','collectionmonth','collectionamount','monthlydata', 'zoneCode', 'filter')); 
    }
    public function indexformewacho(Request $request)
    {
        $zoneCode = Auth::user()->area;
        $zoneName = null;
        $zobadatas = null;
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && $request->zone !== '0'){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
            }
            else
                $zoneCode = $request->zone;
        }
        $value = null;
        if($zoneCode == '0')
            $value = '';
        else
            $value = $zoneCode;
        if(strlen($zoneCode)==3){
            $value = '__'.$value;
        }
        // if member types are fixed improve the code
        $mewachoid=$request->mewacho;
        $mwname = DB::table("mewacho_settings")->where('id',$mewachoid)->first()->name;
        $mwidabedata = DB::table("meseretawi_wdabes")->pluck("widabeName","widabeCode");
        $wahiodata = DB::table("wahios")->pluck("wahioName","id");
        
        $membertype = DB::table("mewacho_settings")->where('id',$mewachoid)->pluck("mtype","mtype");
        $mewachoamount = DB::table("mewacho_settings")->where('id',$mewachoid)->pluck("amount","mtype");        
        // $membertypearr=json_decode($membertypearr); 
        // $membertype=$membertypearr[0];             
        // $mewachoamountarr=json_decode($mewachoamountarr);
        // $mewachoamount=$mewachoamountarr[0];                    
        // $data = ApprovedHitsuy::whereHas('hitsuy', function ($query) use($membertype) {
        //     $query->where('occupation', $membertype);
        // })->get();          
        // $tempdata = ApprovedHitsuy::whereHas('hitsuy', function ($query) use($membertype) {
        //     $query->where('occupation', $membertype);
        // })->pluck("membershipType","hitsuyID");  
        $collectionmewacho =[];    
        $data = ApprovedHitsuy::where('zoneworedaCode','LIKE', $value.'%')->where('approved_status','1')->paginate(Constant::PAGE_SIZE);
        $tempdata = ApprovedHitsuy::all()->pluck("membershipType","hitsuyID");
        foreach ($tempdata as $key => $value) {
            $lasthitsuy = Mewacho::where('hitsuyID',$key)->where('mewacho_id', $mewachoid)->pluck('hitsuyID')->first();
            if($lasthitsuy)
                $collectionmewacho[$lasthitsuy]="ተኸፊሉ";
        }
        
        return view ('payment.mewachodetail',compact('data', 'zoneCode', 'zobadatas','wahiodata','mwidabedata','collectionmewacho','membertype','mewachoamount','mwname', 'mewachoid'));
    }
    public function indexformewachomain()
    {
        // $currentdate='2010-03-15';
        $today = date('Y-m-d');
        $mewachodata = DB::table("mewacho_settings")->where('deadline','>=',$today)->pluck("name","id");
        return view ('payment.mewacho',compact('mewachodata')); 
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
            'max' => ':attribute ክሳብ '.(date('Y')-((date('m')>=10||(date('m')==9 && date('d')>11)) ? 7 :8)).' ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-((date('m')>=10||(date('m')==9 && date('d')>11)) ? 7 :8)),
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'year' => 'ዓመት',
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        //
        $memeberIDs=json_decode($request->memeberID);
        $yearlydata = DB::table("yearly_settings")->pluck("amount","type");

        DB::beginTransaction();
        foreach($memeberIDs as $hID){
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->count()){
                $validator->errors()->add('duplicate', 'ክፍሊት ኣይተመዝገበን መለለዪ ኣባል '.$hID.'  ኣብ መዝገብ ኣይተረኸበን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }
            if(Yearly::where('hitsuyID', $hID)->where('year', $request->year)->count()){
                $validator->errors()->add('duplicate', 'ክፍሊት ኣይተመዝገበን መለለዪ ኣባል '.$hID. ' ናይ ' . $request->year . ' ክፍሊት ከፊሉ ነይሩ እዩ');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }
            $data = new Yearly;                   
            $data->hitsuyID = $hID; 
            $data->year = $request->year;            
            $myType = Hitsuy::where('hitsuyID',$hID)->pluck('occupation')->first();
            if(!isset($yearlydata[$myType])){
                return [false,  'error', 'መጠን ክፍሊት ን'. $myType .' ኣይተወሰነን። በይዝኦን ንኣድሚንስትሬተር ይሕተቱ።'];
            }
            $data->amount = $yearlydata[$myType];
            $data->save();    
        }
        DB::commit();
        return [true, "info", "ዓመታዊ ክፍሊት ብትክክል ተመዝጊቡ ኣሎ"];
    }

    public function storeMonthly(Request $request)
    {
        $messages = [
            'required' => ':attribute ኣይተመልአን',
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'min' => ':attribute ድሕሪ 1950 ክኸውን ኣለዎ',
            'max' => ':attribute ክሳብ '.(date('Y')-((date('m')>=10||(date('m')==9 && date('d')>11)) ? 7 :8)).' ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-((date('m')>=10||(date('m')==9 && date('d')>11)) ? 7 :8)),
            'month' => 'required|in:መስከረም,ጥቅምቲ,ሕዳር,ታሕሳስ,ጥሪ,ለካቲት,መጋቢት,ሚያዝያ,ግንቦት,ሰነ,ሓምለ,ነሓሰ',
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'year' => 'ዓመት',
            'month' => 'ክፍሊት ወርሒ',
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        //
        $memeberIDs=json_decode($request->memeberID);
        $monthlydata = DB::table("monthly_settings")->select("percent","from","to")->get()->toArray();
        foreach($memeberIDs as $hID) {   
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->count()){
                $validator->errors()->add('duplicate', 'ክፍሊት ኣይተመዝገበን መለለዪ ኣባል '.$hID.' ኣብ መዝገብ ኣይተረኸበን');
                return [false,  'error', $validator->errors()->all()];
            }
            if(Monthly::where('hitsuyID', $hID)->where('year', $request->year)->where('month', $request->month)->count()){
                $validator->errors()->add('duplicate', 'ክፍሊት ኣይተመዝገበን መለለዪ ኣባል '.$hID.' ወርሒ ' . $request->month . ' ' . $request->year . ' ከፊሉ ነይሩ እዩ');
                return [false,  'error', $validator->errors()->all()];   
            }
        }
        DB::beginTransaction();
        foreach($memeberIDs as $hID) {   
            $data = new Monthly;                   
            $data->hitsuyID = $hID; 
            $data->year = $request->year; 
            $data->month = $request->month;

            $myNet = ApprovedHitsuy::where('hitsuyID',$hID)->pluck('netSalary')->first();
            $mypercent=0.0;
            foreach ($monthlydata as $monthly) {
                if(($myNet > $monthly->from) && ($myNet <= $monthly->to)){
                    $mypercent = $monthly->percent;
                    break;
                }
            }
                            
            $data->amount = $myNet*$mypercent;
            $data->save();    
        }
        DB::commit();

        return [true, "info", "ወርሓዊ ክፍሊት ብትክክል ተመዝጊቡ ኣሎ"];
    }
    public function storeMewacho(Request $request)
    {
        //
        $memeberIDs=json_decode($request->memeberID);
        $myamount=json_decode($request->amount);

        $messages = [
            'ethiopian_date' => 'ዕለት: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
            'required' => ':attribute ኣይተመልአን',
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ'
        ];
        $validator = \Validator::make($request->all(), [
            'memeberID' => 'required',
            'payday' => 'required|ethiopian_date',
            'mewacho' => 'required|integer',
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'payday' => 'ዝተኸፈለሉ ዕለት',
            'mewacho' => 'ዓይነት መዋጮ',
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!MewachoSetting::where('id', $request->mewacho)->count()){
            return [false,  'error', 'ዓይነት መዋጮ ኣብ መዝገብ ኣይተረኸበን'];
        }
        if(!MewachoSetting::where('id', $request->mewacho)->where('deadline', '>=', date('Y-m-d'))->count()){
            return [false,  'error', 'መኽፈሊ መዋጮ ሓሊፋ እዩ'];
        }
        $mw = MewachoSetting::where('id', $request->mewacho)->first();
        DB::beginTransaction();
        foreach($memeberIDs as $key => $hID) {
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->count()){
                $validator->errors()->add('duplicate', 'ትልሚ ኣይተመዝገበን መለለዪ ኣባል '.$hID.' ኣብ መዝገብ ኣይተረኸበን');
                DB::rollback();
                return [false, 'error', $validator->errors()->all()];
            }
            if(ApprovedHitsuy::where('hitsuyID', $hID)->first()->occupation != $mw->mtype) {
                $validator->errors()->add('duplicate', $hID . ' ' . $mw->mtype . ' ኣይኮነን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];   
            }
            if(Mewacho::where('hitsuyID', $hID)->where('mewacho_id', $request->mewacho)->count()) {
                $validator->errors()->add('duplicate', 'መዋጮ ኣይተመዝገበን [መዋጮ ኣብ መዝገብ ኣሎ]');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];   
            }
            $data = new Mewacho;                   
            $data->hitsuyID = $hID; 
            $data->payday = DateConvert::correctDate($request->payday);
            $data->mewacho_id = $request->mewacho;
            $data->amount = $myamount[$key];   
            $data->save();    
        }
        DB::commit();
        return [true, "info", "መዋጮ ብትክክል ተመዝጊቡ ኣሎ"];
        // return response ()->json ( $request->mewacho );
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
