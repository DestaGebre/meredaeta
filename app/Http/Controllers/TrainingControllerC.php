<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\Siltena;

use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;

use  App\ApprovedHitsuy;
use App\Constant;
use DB;

class TrainingController extends Controller
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
        $individualdata = DB::table("individualplans");
        $query1 = ApprovedHitsuy::where('zoneworedaCode','LIKE', $new_value . '%')->where('approved_status','1');
        if($widabe){
            $query1 = $query1->where('assignedWudabe', $widabe->widabeCode);
        }
        if($wahio){
            $query1 = $query1->where('assignedWahio', $wahio->id);
        }
        $tempdata = $query1->pluck("hitsuyID");
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        foreach ($tempdata as $value) {
            $lastYear = Siltena::where('hitsuyID',$value);
        }
        return view ('planing.individualplan',compact('data', 'zobadatas', 'zoneCode', 'wahio', 'wahio_l', 'widabe', 'widabe_l', 'tabia', 'tabia_l', 'woreda', 'woreda_l'));
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
            'trainingLevel' => 'required|in:ጀማሪ ኣመራርሓ ስልጠና,ማእኸላይ ኣመራርሓ ስልጠና,ላዕለዋይ ኣመራርሓ ስልጠና',
            'trainer' => 'required',
            'trainingPlace' => 'required',
            'zoneDecision' => 'required',  
            'woredaApproved' => 'required',                     
            'numDays' => 'required|integer',
            'startDate' => 'required|ethiopian_date'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'trainingLevel' => 'ዝወሰዶ ስልጠና ',
			'trainer' => 'ስልጠና ዝሃበ ኣካል',
			'trainingPlace' => 'ናይ ስልጠና ቦታ',
			'zoneDecision' => 'ናይ ዞባ ውሳነ ቐሪቡ',  
			'woredaApproved' => 'ናይ ወረዳ ውሳነ ቐሪብ',                     
			'numDays' => 'ጠቕላላ ናይ ስልጠና መዓልትታት',
			'startDate' => 'ስልጠና ዝጀመረሉ ዕለት'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        //
        $memeberIDs=json_decode($request->memeberID);
		$plausible = ['ተራ ኣባል' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ታሕተዋይ ኣመራርሓ' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ሲቪል ሰርቫንት' => 'ጀማሪ ኣመራርሓ ስልጠና', 'ጀማሪ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ ስልጠና', 'ማእኸላይ ኣመራርሓ' => 'ላዕለዋይ ኣመራርሓ ስልጠና', 'ላዕለዋይ ኣመራርሓ' => ''];
        $next_level = ['ተራ ኣባል' => 'ጀማሪ ኣመራርሓ','ታሕተዋይ ኣመራርሓ' => 'ጀማሪ ኣመራርሓ', 'ሲቪል ሰርቫንት' => 'ጀማሪ ኣመራርሓ', 'ጀማሪ ኣመራርሓ' => 'ማእኸላይ ኣመራርሓ', 'ማእኸላይ ኣመራርሓ' => 'ላዕለዋይ ኣመራርሓ', 'ላዕለዋይ ኣመራርሓ' => ''];
        $value = Auth::user()->area;
        if(Auth::user()->usertype=='woreda' || Auth::user()->usertype=='woredaadmin'){
            $value = '__'.$value;
        }
        DB::beginTransaction();
        foreach($memeberIDs as $hID) {   
            if(!ApprovedHitsuy::where('hitsuyID', $hID)->count()){
                 $validator->errors()->add('duplicate', 'ስልጠና ኣይተመዝገበን መለለዪ ኣባል '.$hID.' ኣብ መዝገብ ኣይተረኸበን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }
            if(Siltena::where('hitsuyID', $hID)) {
                $validator->errors()->add('duplicate', 'ስልጠና ኣይተመዝገበን [ትልሚ ኣብ መዝገብ ኣሎ]');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];   
            }
            $data = new Siltena;
            $data->hitsuyID = $hID; 
            $data->save();    
        }
        DB::commit();
        return [true, "info", "ዓመታዊ ትልሚ ውልቀ ሰብ ብትክክል ተመዝጊቡ ኣሎ"];
    }
}
