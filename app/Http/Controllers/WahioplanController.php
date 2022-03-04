<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\meseretawiWdabe;
use App\Wahio;
use App\Zobatat;
use App\Woreda;
use App\Tabia;
use App\Meseretawiwidabeaplan;
use App\Constant;
use App\Wahioplan;
use App\Filter;
use App\UserAction;
use DB;

class WahioplanController extends Controller
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
        if($request->widabe){
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
        $new_value = ($zoneCode ? $zoneCode : '__') . ($woreda ? $woreda->woredacode : '___') . ($tabia ? $tabia->tabiaCode : '____') .  ($widabe ? $widabe->widabeCode : '_____');
        $data = Wahio::where('parentcode', 'LIKE', $new_value . '%')->paginate(Constant::PAGE_SIZE);
        $individualdata = DB::table("wahioplans")->pluck("planyear");
        $tempdata = Wahio::all()->pluck("id");
        $collectionyear = collect([]);
        foreach ($tempdata as $value) {
            $lastYear = Wahioplan::where('wahioid',$value)->orderBy('planyear', 'desc')->orderBy('quarter', 'desc')->pluck('planyear')->first();
            $quarter = Wahioplan::where('wahioid',$value)->orderBy('planyear', 'desc')->orderBy('quarter', 'desc')->pluck('quarter')->first();
           /* if($quarter)
                $collectionyear->prepend($lastYear. '(' . $quarter . ')', $value);
            else*/
                $collectionyear->prepend($lastYear, $value);
        }
        return view ('planing.wahioplan',compact('data','collectionyear', 'zoneCode', 'wahio', 'wahio_l', 'widabe', 'widabe_l', 'tabia', 'tabia_l', 'woreda', 'woreda_l', 'zobadatas'));
    }
    public function listPlan(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");        
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $query = DB::table('wahios')->where('parentcode', 'LIKE', $code . '%')->join('wahioplans', 'wahios.id', '=', 'wahioplans.wahioid');        
        if($year){
            $query = $query->where('wahioplans.planyear', $year);
        }

        $data = $query->paginate(Constant::PAGE_SIZE);

        return view ('planing.wahioplanlist',compact('data','zobadatas', 'zoneCode', 'filter'));
    }
    public function delete(Request $request){
        $data = Wahioplan::where('wahioid', $request->id)->where('planyear', $request->year)->first();
        if($data){
            $data->delete();
            UserAction::storeAction('', 'wahioplans', Constant::DELETE, Constant::PLAN_WAHIO, ['ኮድ' => $data->wahioid, 'ዓመት' => $data->planyear], false, []);
            return [true];
        }
        return [false];
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
            'max' => ':attribute ክሳብ '.(date('Y')-7).' ክኸውን ኣለዎ',
        ];
        //
        $validator = \Validator::make($request->all(),[
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7)
            //'quarter' => 'required|in:3 ወርሒ,6 ወርሒ,9 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'year' => 'ዓመት',
            'quarter' => 'ርብዒ ዓመት'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        //
        $memeberIDs=json_decode($request->memeberID);
        DB::beginTransaction();
        foreach($memeberIDs as $hID) {   
            if(!Wahio::where('id', $hID)->count()){
                $validator->errors()->add('duplicate', 'ትልሚ ኣይተመዝገበን ዋህዮ '.$hID.' ኣብ መዝገብ ኣይተረኸበን');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];
            }
            if(Wahioplan::where('wahioid', $hID)->where('planyear', $request->year)/*->where('quarter', $request->quarter)*/->count()){
                $validator->errors()->add('duplicate', 'ትልሚ ኣይተመዝገበን [ትልሚ ኣብ መዝገብ ኣሎ]');
                DB::rollback();
                return [false,  'error', $validator->errors()->all()];   
            }
            $data = new Wahioplan;
            $data->wahioid = $hID; 
            $data->planyear = $request->year;
            $data->quarter = 'ዓመት';//$request->quarter;
            $data->save();    
        }
        DB::commit();
       UserAction::storeAction('', 'wahioplans', Constant::CREATE, Constant::PLAN_WAHIO, ['ኮድ' => $data->wahioid, 'ዓመት' => $data->planyear], true, $memeberIDs);
       return [true, "info", "ትልሚ ዋህዮ ብትክክል ተመዝጊቡ ኣሎ"];
    }
}
