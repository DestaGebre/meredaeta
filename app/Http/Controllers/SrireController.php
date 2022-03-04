<?php

namespace App\Http\Controllers;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use  App\Srire;
use  App\Zobatat;
use  App\Woreda;
use  App\meseretawiWdabe;
use  App\Wahio;
use App\Constant;
use App\Filter;
use App\UserAction;
use DB;

use Illuminate\Http\Request;

class SrireController extends Controller
{   
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $code = ($zoneCode ? $zoneCode : '__');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $data = Woreda::where('zoneCode', '=', $code)->paginate(Constant::PAGE_SIZE);

        $tempdata = Woreda::all()->pluck("name","woredacode");           
        $collectionyear = collect([]);
        $collectionhalf = collect([]);
        foreach ($tempdata as $key => $value) {
            $lastYear = Srire::where('code',$key)->where('type','ወረዳ')->orderBy('year', 'desc')->get(['year', 'half'])->first();
            if($lastYear){
                $collectionyear->prepend($lastYear->year, $key);
                $collectionhalf->prepend($lastYear->half, $key);
            }
            else{
                $collectionyear->prepend('', $key);
                $collectionhalf->prepend('', $key);
            }
        }

	   	return view ('rank.rankworeda',compact('data','zobadatas','collectionyear','collectionhalf', 'zoneCode', 'filter'));
    } 
    public function rankWoredaList(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $rank = $filter['rank'];
        $code = ($zoneCode ? $zoneCode : '__');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $query = DB::table('woredas')->where('zoneCode', '=', $code)->join('srires', 'woredas.woredacode', '=', 'srires.code')->where('srires.type', '=', 'ወረዳ');
        if($year){
            $query = $query->where('srires.year', $year);
        }
        if($rank){
            $query = $query->where('srires.result', $rank);
        }

        $data = $query->paginate(Constant::PAGE_SIZE);

        return view ('rank.rankworedalist',compact('data','zobadatas', 'zoneCode', 'filter'));
    }
    public function rankmwidabeList(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $rank = $filter['rank'];
        $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");        
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $query = DB::table('meseretawi_wdabes')->where('parentcode', 'LIKE', $code . '%')->join('srires', 'meseretawi_wdabes.widabeCode', '=', 'srires.code')->where('srires.type', '=', 'መሰረታዊ ውዳበ');
        if($year){
            $query = $query->where('srires.year', $year);
        }
        if($rank){
            $query = $query->where('srires.result', $rank);
        }

        $data = $query->paginate(Constant::PAGE_SIZE);

        return view ('rank.rankmwidabelist',compact('data','zobadatas', 'zoneCode', 'filter'));
    }
    public function rankwahioList(Request $request){
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $year = $filter['year'];
        $rank = $filter['rank'];
        $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____') . ($filter['widabe'] ? $filter['widabe']->widabeCode : '_____');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $mwidabedata = DB::table("meseretawi_wdabes")->pluck("tabiaCode","widabeCode"); 
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");        
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $data = Wahio::where('parentcode', 'LIKE', $code . '%')->paginate(Constant::PAGE_SIZE);
        $query = DB::table('wahios')->where('parentcode', 'LIKE', $code . '%')->join('srires', 'wahios.id', '=', 'srires.code')->where('srires.type', '=', 'ዋህዮ');
        if($year){
            $query = $query->where('srires.year', $year);
        }
        if($rank){
            $query = $query->where('srires.result', $rank);
        }

        $data = $query->paginate(Constant::PAGE_SIZE);

        return view ('rank.rankwahiolist',compact('data','zobadatas', 'zoneCode', 'filter'));
    }
    public function rankworedadelete(Request $request){
        $data = Srire::where('code', $request->id)->where('type', 'ወረዳ')->where('year', $request->year)->where('half', $request->half)->first();
        if($data){
            $data->delete();
            UserAction::storeAction('', 'srires', Constant::DELETE, Constant::SRIRIE_WOREDA, ['ኮድ' => $data->code, 'ውፅኢት' => $data->result, 'ዓመት' => $data->year, 'half' => $data->half], false, []);
            return [true];
        }
        return [false];
    }

    public function rankmwidabeindex(Request $request)
    { 
       $filter = Filter::filter_values($request);
       $zoneCode = $filter['zoneCode'];
       $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");        
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $data = meseretawiWdabe::where('parentcode', 'LIKE', $code . '%')->paginate(Constant::PAGE_SIZE);

        $tempdata = meseretawiWdabe::all()->pluck("widabeName","widabeCode");           
        $collectionyear = collect([]);
        $collectionhalf = collect([]);
        foreach ($tempdata as $key => $value) {
            $lastYear = Srire::where('code',$key)->where('type','መሰረታዊ ውዳበ')->orderBy('year', 'desc')->get(['year', 'half'])->first();
            if($lastYear){
                $collectionyear->prepend($lastYear->year, $key);
                $collectionhalf->prepend($lastYear->half, $key);
            }
            else{
                $collectionyear->prepend('', $key);
                $collectionhalf->prepend('', $key);
            }
        }

	   	return view ('rank.rankmwidabe',compact('data','zobadatas','collectionyear','collectionhalf','tabiadata','woredadata', 'zoneCode', 'filter'));
    }
    public function rankmwidabedelete(Request $request){
        $data = Srire::where('code', $request->id)->where('type', 'መሰረታዊ ውዳበ')->where('year', $request->year)/*->where('half', $request->half)*/->first();
        if($data){
            $data->delete();
			UserAction::storeAction('', 'srires', Constant::DELETE, Constant::SRIRIE_WIDABE, ['ኮድ' => $data->code, 'ውፅኢት' => $data->result, 'ዓመት' => $data->year, 'half' => $data->half], false, []);
            return [true];
        }
        return [false];
    }

    public function rankwahioindex(Request $request)
    { 
        $filter = Filter::filter_values($request);
        $zoneCode = $filter['zoneCode'];
        $code = ($zoneCode ? $zoneCode : '__') . ($filter['woreda'] ? $filter['woreda']->woredacode : '___') . ($filter['tabia'] ? $filter['tabia']->tabiaCode : '____') . ($filter['widabe'] ? $filter['widabe']->widabeCode : '_____');
        $zobadatas = DB::table("zobatats")->pluck("zoneName","zoneCode");
        $mwidabedata = DB::table("meseretawi_wdabes")->pluck("tabiaCode","widabeCode"); 
        $tabiadata = DB::table("tabias")->pluck("woredacode","tabiaCode");        
        $woredadata = DB::table("woredas")->pluck("zoneCode","woredacode");
        $data = Wahio::where('parentcode', 'LIKE', $code . '%')->paginate(Constant::PAGE_SIZE);

        $tempdata = Wahio::all()->pluck("wahioName","id");           
        $collectionyear = collect([]);
         $collectionhalf = collect([]);
        foreach ($tempdata as $key => $value) {
            $lastYear = Srire::where('code',$key)->where('type','ዋህዮ')->orderBy('year', 'desc')->get(['year','half'])->first();
            if($lastYear){
                $collectionyear->prepend($lastYear->year, $key);
                 $collectionhalf->prepend($lastYear->half, $key);
            }
            else{
                $collectionyear->prepend('', $key);
                 $collectionhalf->prepend('', $key);
            }
        }

	   	return view ('rank.rankwahio',compact('data','zobadatas','collectionyear','collectionhalf','mwidabedata','tabiadata','woredadata', 'zoneCode', 'filter'));
    }
    public function rankwahiodelete(Request $request){
        $data = Srire::where('code', $request->id)->where('type', 'ዋህዮ')->where('year', $request->year)/*->where('half', $request->half)*/->first();
        if($data){
            $data->delete();
			UserAction::storeAction('', 'srires', Constant::DELETE, Constant::SRIRIE_WAHIO, ['ኮድ' => $data->code, 'ውፅኢት' => $data->result, 'ዓመት' => $data->year, 'half' => $data->half], false, []);
            return [true];
        }
        return [false];
    }

    public function storerankWoreda(Request $request)
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
            'type' => 'required|in:መሰረታዊ ውዳበ,ዋህዮ,ወረዳ',
            'result' => 'required|in:ቅድሚት,ማእኸላይ,ድሕሪት',
            'half' => 'required|in:6 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'year' => 'ዓመት',
            'result' => 'ውፅኢት ስርርዕ',
            'half' => 'እዋን ገምጋም'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }

        $memeberIDs=json_decode($request->memeberID);
        
        DB::beginTransaction();
        foreach($memeberIDs as $mycode) {
            if(!Woreda::where('woredacode', $mycode)->count()){
                DB::rollback();
                return [false, "error", "መለለዪ ቑፅሪ ወረዳ " . $mycode . " ኣይተረኸበን<br> ስርርዕ ወረዳታት ኣይተመዝገበን"];
            }
            if(Srire::where('code', $mycode)->where('type', 'ወረዳ')->where('year', $request->year)->where('half', $request->half)->count()){
                DB::rollback();
                return [false, "error", "መለለዪ ቑፅሪ ወረዳ " . $mycode . " ናይ " . $request->year . "(". $request->half .")<br> ስርርዕ ኣብ መዝገብ ኣሎ እዩ"];
            }
            $data = new Srire;                   
            $data->code = $mycode; 
            $data->type = $request->type;
            $data->result = $request->result;
            $data->year = $request->year; 
            $data->half = $request->half;
            $data->save();    
        }
        DB::commit();
        UserAction::storeAction('', 'srires', Constant::CREATE, Constant::SRIRIE_WOREDA, ['ውፅኢት' => $request->result, 'ዓመት' => $request->year, 'ወቕቲ' => $request->half], true, $memeberIDs);
        return [true, "info", "ስርርዕ ወረዳታት ብትክክል ተመዝጊቡ ኣሎ"];
    }
    public function editrankWoreda(Request $request)
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
            'id' => 'required',
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7),
            'type' => 'required|in:መሰረታዊ ውዳበ,ዋህዮ,ወረዳ',
            'result' => 'required|in:ቅድሚት,ማእኸላይ,ድሕሪት',
            'half' => 'required|in:6 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መፍለይ ቑፅሪ ወረዳ',
            'year' => 'ዓመት',
            'result' => 'ውፅኢት ስርርዕ',
            'half' => 'እዋን ገምጋም'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Woreda::where('woredacode', $request->memeberID)->count()){
            DB::rollback();
            return [false, "error", "መለለዪ ቑፅሪ ወረዳ " . $request->memeberID . " ኣይተረኸበን<br> ስርርዕ ወረዳ ኣይተስተኻኸለን"];
        }
        if(Srire::where('code', $request->memeberID)->where('id', '!=', $request->id)->where('type', 'ወረዳ')->where('year', $request->year)->where('half', $request->half)->count()){
            DB::rollback();
            return [false, "error", "ናይ ወረዳ " . $request->memeberID . " ናይ " . $request->year . "(". $request->half .")<br> ስርርዕ ኣብ መዝገብ ኣሎ እዩ"];
        }
        $data = Srire::find($request->id);
        $data->result = $request->result;
        $data->year = $request->year; 
        $data->half = $request->half; 
        $data->save();
		UserAction::storeAction('', 'srires', Constant::UPDATE, Constant::SRIRIE_WOREDA, ['ኮድ' => $data->code, 'ውፅኢት' => $data->result, 'ዓመት' => $data->year, 'half' => $data->half], false, []);  
        return [true, "info", "ስርርዕ ወረዳ ተስተኻኺሉ ኣሎ"];
    }
    public function editrankMwidabe(Request $request)
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
            'id' => 'required',
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7),
            'type' => 'required|in:መሰረታዊ ውዳበ,ዋህዮ,ወረዳ',
            'result' => 'required|in:ቅድሚት,ማእኸላይ,ድሕሪት',
            'half' => 'required|in:6 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መፍለይ ቑፅሪ መሰረታዊ ውዳበ',
            'year' => 'ዓመት',
            'result' => 'ውፅኢት ስርርዕ',
            'half' => 'እዋን ገምጋም'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!meseretawiWdabe::where('widabeCode', $request->memeberID)->count()){
            DB::rollback();
            return [false, "error", "መለለዪ ቑፅሪ መሰረታዊ ውዳበ " . $request->memeberID . " ኣይተረኸበን<br> ስርርዕ መሰረታዊ ውዳበ ኣይተስተኻኸለን"];
        }
        if(Srire::where('code', $request->memeberID)->where('id', '!=', $request->id)->where('type', 'መሰረታዊ ውዳበ')->where('year', $request->year)->where('half', $request->half)->count()){
            DB::rollback();
            return [false, "error", "ናይ መሰረታዊ ውዳበ " . $request->memeberID . " ናይ " . $request->year . "(". $request->half .")" . "<br> ስርርዕ ኣብ መዝገብ ኣሎ እዩ"];
        }
        $data = Srire::find($request->id);
        $data->result = $request->result;
        $data->year = $request->year;
        $data->save();    
        UserAction::storeAction('', 'srires', Constant::UPDATE, Constant::SRIRIE_WIDABE, ['ኮድ' => $data->code, 'ውፅኢት' => $data->result, 'ዓመት' => $data->year, 'half' => $data->half], false, []);
        return [true, "info", "ስርርዕ መሰረታዊ ውዳበ ተስተኻኺሉ ኣሎ"];
    }

    public function storerankMwidabe(Request $request)
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
            'type' => 'required|in:መሰረታዊ ውዳበ,ዋህዮ,ወረዳ',
            'result' => 'required|in:ቅድሚት,ማእኸላይ,ድሕሪት',
            'half' => 'required|in:6 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'year' => 'ዓመት',
            'result' => 'ውፅኢት ስርርዕ',
            'half' => 'እዋን ገምጋም'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $memeberIDs=json_decode($request->memeberID);
        DB::beginTransaction();
        foreach($memeberIDs as $mycode) {   
            if(!meseretawiWdabe::where('widabeCode', $mycode)->count()){
                DB::rollback();
                return [false, "error", "መለለዪ ቑፅሪ መሰረታዊ ውዳበ " . $mycode . " ኣይተረኸበን<br> ስርርዕ መሰረታዊ ውዳበታት ኣይተመዝገበን"];
            }
            if(Srire::where('code', $mycode)->where('type', 'መሰረታዊ ውዳበ')->where('year', $request->year)->where('half', $request->half)->count()){
                DB::rollback();
                return [false, "error", "መለለዪ ቑፅሪ መሰረታዊ ውዳበ " . $mycode . " ናይ " . $request->year . "(". $request->half .")" . "<br> ስርርዕ ኣብ መዝገብ ኣሎ እዩ"];
            }
            $data = new Srire;                   
            $data->code = $mycode; 
            $data->type = $request->type;
            $data->result = $request->result;
            $data->year = $request->year; 
            $data->half = $request->half;
            $data->save();    
        }
        DB::commit();
		UserAction::storeAction('', 'srires', Constant::CREATE, Constant::SRIRIE_WIDABE, ['ውፅኢት' => $request->result, 'ዓመት' => $request->year, 'ወቕቲ' => $request->half], true, $memeberIDs);
        return [true, "info", "ስርርዕ መሰረታዊ ውዳበታት ብትክክል ተመዝጊቡ ኣሎ"];
    }

    public function storerankWahio(Request $request)
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
            'type' => 'required|in:መሰረታዊ ውዳበ,ዋህዮ,ወረዳ',
            'result' => 'required|in:ቅድሚት,ማእኸላይ,ድሕሪት',
            'half' => 'required|in:6 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መለለዩ ቑፅሪ ኣባላት',
            'year' => 'ዓመት',
            'result' => 'ውፅኢት ስርርዕ',
            'half' => 'እዋን ገምጋም'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        $memeberIDs=json_decode($request->memeberID);
        
        DB::beginTransaction();
        foreach($memeberIDs as $mycode) {
            if(!Wahio::where('id', $mycode)->count()){
                DB::rollback();
                return [false, "error", "መለለዪ ቑፅሪ ዋህዮ " . $mycode . " ኣይተረኸበን<br> ስርርዕ ዋህዮታት ኣይተመዝገበን"];
            }
            if(Srire::where('code', $mycode)->where('type', 'ዋህዮ')->where('year', $request->year)->where('half', $request->half)->count()){
                DB::rollback();
                return [false, "error", "መለለዪ ቑፅሪ ዋህዮ " . $mycode . " ናይ " . $request->year  . "(". $request->half .")" . "<br> ስርርዕ ኣብ መዝገብ ኣሎ እዩ"];
            }
            $data = new Srire;                   
            $data->code = $mycode; 
            $data->type = $request->type;
            $data->result = $request->result;
            $data->year = $request->year; 
            $data->half = $request->half;
            $data->save();    
        }
        DB::commit();
		UserAction::storeAction('', 'srires', Constant::CREATE, Constant::SRIRIE_WAHIO, ['ውፅኢት' => $request->result, 'ዓመት' => $request->year, 'ወቕቲ' => $request->half], true, $memeberIDs);
      
        return [true, "info", "ስርርዕ ዋህዮታት ብትክክል ተመዝጊቡ ኣሎ"];
    }
    public function editrankWahio(Request $request)
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
            'id' => 'required',
            'memeberID' => 'required',
            'year' => 'required|integer|digits:4|min:1950|max:'.(date('Y')-7),
            'type' => 'required|in:መሰረታዊ ውዳበ,ዋህዮ,ወረዳ',
            'result' => 'required|in:ቅድሚት,ማእኸላይ,ድሕሪት',
            'half' => 'required|in:6 ወርሒ,ዓመት'
        ],$messages);
        $fieldNames = [
            'memeberID' => 'መፍለይ ቑፅሪ ዋህዮ',
            'year' => 'ዓመት',
            'result' => 'ውፅኢት ስርርዕ',
            'half' => 'እዋን ገምጋም'
        ];
        $validator->setAttributeNames($fieldNames);
        if($validator->fails()){
            return [false, 'error', $validator->errors()->all()];
        }
        if(!Wahio::where('id', $request->memeberID)->count()){
            DB::rollback();
            return [false, "error", "መለለዪ ቑፅሪ ዋህዮ " . $request->memeberID . " ኣይተረኸበን<br> ስርርዕ ዋህዮ ኣይተስተኻኸለን"];
        }
        if(Srire::where('code', $request->memeberID)->where('id', '!=', $request->id)->where('type', 'ዋህዮ')->where('year', $request->year)->where('half', $request->half)->count()){
            DB::rollback();
            return [false, "error", "ናይ ዋህዮ " . $request->memeberID . " ናይ " . $request->year . /*"(". $request->half .")" .*/"<br> ስርርዕ ኣብ መዝገብ ኣሎ እዩ"];
        }
        $data = Srire::find($request->id);
        $data->result = $request->result;
        $data->year = $request->year;
        $data->save();    
        UserAction::storeAction('', 'srires', Constant::UPDATE, Constant::SRIRIE_WAHIO, ['ኮድ' => $data->code, 'ውፅኢት' => $data->result, 'ዓመት' => $data->year, 'half' => $data->half], false, []);
        return [true, "info", "ስርርዕ ዋህዮ ተስተኻኺሉ ኣሎ"];
    }
}
