<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Individualplan;

use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;

use  App\ApprovedHitsuy;
use App\Constant;
use App\UserAction;
use App\Filter;
use DB;

class IndividualplanController extends Controller
{
    public function __construct()    //if not authenticated, redirect to login
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $value = Auth::user()->area;
        $zoneCode = null;
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $zoneCode = Woreda::where('woredacode', $value)->first()->zoneCode;
            $value = '__'.$value;
        }
        else{
            $zoneCode = Auth::user()->area;
        }

        $woreda = $tabia = $widabe = $wahio = null;
        $woreda_l = $tabia_l = $widabe_l = $wahio_l = [];
        if($request->wahio){
            $wahio = Wahio::where('id', $request->wahio)->where('parentcode', 'LIKE', $value . '%')->first();
            if(!$wahio)
                abort(404);
            $wahio_l = Wahio::where('widabeCode', $wahio->widabeCode)->pluck('wahioName', 'id');
            $widabe = meseretawiWdabe::where('widabeCode', $wahio->widabeCode)->first();
            $widabe_l = meseretawiWdabe::where('tabiaCode', $widabe->tabiaCode)->pluck('widabeName', 'widabeCode');
            $tabia = Tabia::where('tabiaCode', $widabe->tabiaCode)->first();
            $tabia_l = Tabia::where('woredacode', $tabia->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda = Woreda::where('woredacode', $tabia->woredacode)->first();
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;
            // echo 'ዋህዮ: ' . $wahio->wahioName . '<br>';
            // echo 'መው: ' . $widabe->widabeName . '<br>';
            // echo 'ጣብያ: ' . $tabia->tabiaName . '<br>';
            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        else if($request->widabe){
            $widabe = meseretawiWdabe::where('widabeCode', $request->widabe)->where('parentcode', 'LIKE', $value . '%')->first();
            if(!$widabe)
                abort(404);
            $wahio_l = Wahio::where('widabeCode', $widabe->widabeCode)->pluck('wahioName', 'id');
            $widabe_l = meseretawiWdabe::where('tabiaCode', $widabe->tabiaCode)->pluck('widabeName', 'widabeCode');
            $tabia = Tabia::where('tabiaCode', $widabe->tabiaCode)->first();
            $tabia_l = Tabia::where('woredacode', $tabia->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda = Woreda::where('woredacode', $tabia->woredacode)->first();
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;

            // echo 'መው: ' . $widabe->widabeName . '<br>';
            // echo 'ጣብያ: ' . $tabia->tabiaName . '<br>';
            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        else if($request->tabia){
            $tabia = Tabia::where('tabiaCode', $request->tabia)->where('parentcode', 'LIKE', $value . '%')->first();
            if(!$tabia)
                abort(404);
            $widabe_l = meseretawiWdabe::where('tabiaCode', $tabia->tabiaCode)->pluck('widabeName', 'widabeCode');
            $tabia_l = Tabia::where('woredacode', $tabia->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda = Woreda::where('woredacode', $tabia->woredacode)->first();
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;

            // echo 'ጣብያ: ' . $tabia->tabiaName . '<br>';
            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        else if($request->woreda){
            $woreda = Woreda::where('woredacode', $request->woreda)->where('zoneCode', 'LIKE', $value . '%')->first();
            if(!$woreda)
                abort(404);

            $tabia_l = Tabia::where('woredacode', $woreda->woredacode)->pluck('tabiaName', 'tabiaCode');
            $woreda_l = Woreda::where('zoneCode', $woreda->zoneCode)->pluck('name', 'woredacode');
            $zoneCode = $woreda->zoneCode;

            // echo 'ወረዳ: ' . $woreda->name . '<br>';
        }
        if(Auth::user()->usertype == 'admin'){
            $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
            if(!$request->zone && !$zoneCode){
                $zoneCode = DB::table("zobatats")->pluck("zoneCode")->first();
                $value = $zoneCode;
            }
            else{
                $zoneCode = $request->zone;
                $value = $zoneCode;
            }
        }
        if(!$woreda_l){
            $woreda_l = Woreda::where('zoneCode', $zoneCode)->pluck('name', 'woredacode');
        }
        if(array_search(Auth::user()->usertype, ['woreda','woredaadmin']) !== false){
            $tabia_l = Tabia::where('woredacode', Auth::user()->area)->pluck('tabiaName', 'tabiaCode');
        }
        $new_value = ($zoneCode ? $zoneCode : '__') . ($woreda ? $woreda->woredacode : '___') . ($tabia ? $tabia->tabiaCode : '____');
        $query = ApprovedHitsuy::where('zoneworedaCode','LIKE', $new_value . '%')->where('approved_status','1');
        if($widabe){
            $query = $query->where('assignedWudabe', $widabe->widabeCode);
        }
        if($wahio){
            $query = $query->where('assignedWahio', $wahio->id);
        }
        $data = $query->paginate(Constant::PAGE_SIZE);
        $individualdata = DB::table("individualplans")->pluck("year");
        $query1 = ApprovedHitsuy::where('zoneworedaCode','LIKE', $new_value . '%')->where('approved_status','1');
        if($widabe){
            $query1 = $query1->where('assignedWudabe', $widabe->widabeCode);
        }
        if($wahio){
            $query1 = $query1->where('assignedWahio', $wahio->id);
        }
        $tempdata = $query1->pluck("hitsuyID");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $collectionyear = collect([]);
        foreach ($tempdata as $value) {
            $lastYear = Individualplan::where('hitsuyID',$value)->orderBy('year', 'desc')->pluck('year')->first();
            $collectionyear->prepend($lastYear, $value);
        }
        return view ('planing.individualplan',compact('data','collectionyear', 'zobadatas', 'zoneCode', 'wahio', 'wahio_l', 'widabe', 'widabe_l', 'tabia', 'tabia_l', 'woreda', 'woreda_l'));
    }
    public function listPlan(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");        
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $query = DB::table('approved_hitsuys')->where('zoneworedaCode', 'LIKE', $code . '%')->join('individualplans', 'approved_hitsuys.hitsuyID', '=', 'individualplans.hitsuyID')->join('hitsuys', 'approved_hitsuys.hitsuyID', '=', 'hitsuys.hitsuyID');
        if($year){
            $query = $query->where('individualplans.year', $year);
        }

        $data = $query->paginate(Constant::PAGE_SIZE);

        return view ('planing.individualplanlist',compact('data','zobadatas', 'zoneCode', 'filter', 'year'));
    }
    public function delete(Request $request){
        $data = Individualplan::where('hitsuyID', $request->id)->where('year', $request->year)->first();
        if($data){
            $data->delete();
            UserAction::storeAction('', 'individualplans', Constant::DELETE, Constant::PLAN_INDIVIDUAL, ['ኮድ' => $data->hitsuyID, 'ዓመት' => $data->year], false, []);
            return [true];
        }
        return [false];
    }
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute ኣይተመልአን',
            'integer' => ':attribute ቑፅሪ ክኸውን ኣለዎ',
            'in' => ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
            'min' => ':attribute ድሕሪ 1950 ክኸውን ኣለዎ',
            'max' => ':attribute ክሳብ '.(date('Y')-7).' ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7),
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
        DB::beginTransaction();
        foreach($memeberIDs as $hID) {   
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->count()){
                $validator->errors()->add('duplicate', 'ትልሚ ኣይተመዝገበን መለለዪ ኣባል '.$hID.' ኣብ መዝገብ ኣይተረኸበን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }
            if(Individualplan::where('hitsuyID', $hID)->where('year', $request->year)->count()) {
                $validator->errors()->add('duplicate', 'ትልሚ ኣይተመዝገበን [ትልሚ ኣብ መዝገብ ኣሎ]');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];   
            }
            $data = new Individualplan;
            $data->hitsuyID = $hID; 
            $data->year = $request->year;
            $data->save();    
        }
        DB::commit();
        UserAction::storeAction('', 'individualplans', Constant::CREATE, Constant::PLAN_INDIVIDUAL, ['ኮድ' => $data->hitsuyID, 'ዓመት' => $data->year], true, $memeberIDs);
        return [true, "info", "ዓመታዊ ትልሚ ውልቀ ሰብ ብትክክል ተመዝጊቡ ኣሎ"];
    }
}
