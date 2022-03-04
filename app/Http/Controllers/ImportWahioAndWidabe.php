<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Kamaln7\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Http\Requests;
use  App\Hitsuy;
use  App\ApprovedHitsuy;
use App\Yearly;
use App\Monthly;
use App\Mewacho;
use App\XLSXReader;
use App\DateConvert;

use  App\Zobatat;
use  App\Woreda;
use App\Tabia;
use App\meseretawiWdabe;
use App\Wahio;
use DB;

class ImportWahioAndWidabe extends Controller
{
    public function __construct()    //if not authenticated redirect to login
    {
        $this->middleware('auth');
    }

    public function index()
    {
        //
        // $xlsx = new XLSXReader('excel.xlsx');
        // $data = $xlsx->getSheetData('Sheet1');
        return view ('importwidabe');
    }
    public function adjust($val, $place){
        $len = strlen($val);
        for($i = 0; $i < $place - $len; $i++){
            $val = '0' . $val;
        }
        return $val;
    }
    public function importFile(Request $request){
        $validator = \Validator::make($request->all(), [
            "excelfile" => "required|mimes:xlsx|max:5120"
        ],
        [
            'required' => ':attribute ክምላእ ኣለዎ',
            'mimes' => 'ዓይነት ፋይል ኤክሴል ክኸውን ኣለዎ',
            'max' => 'ኤክሴል ፋይል ካብ 5 ሜጋ ባይት ክዓቢ የብሉን'
        ]);
        $messages = [
        ];
        $validator->setAttributeNames($messages);
        $validator->validate();
        $excel = $request->file('excelfile');
        $new_name = rand() . '.' . $excel->getClientOriginalExtension();
        $excel->move(public_path(""), $new_name);
        $xlsx = new XLSXReader($new_name);
        $data = $xlsx->getSheetData('መዝገብ መሰረታዊ ውዳበ');
        $data = array_slice($data, 1);
        $data_wahio = $xlsx->getSheetData('መዝገብ ዋህዮ');
        $data_wahio = array_slice($data_wahio, 1);
        $xlsx->close();
        unlink(public_path($new_name));
        $problems = "";
        $indices = ['zone','woreda','tabia','mwidabe', 'type'];
        $transformedData = [];
        $zonecode = "";
        $woredacode = "";
        $tabiacode = "";
        $widabecode = "";
        $wahiocode = "";
        $cnt = 2;
        foreach ($data as $d) {
            // ዓይነት ውዳበ
            if(array_search(trim($d[4]), ['መፍረይቲ','ከተማ ሕርሻ','ኮንስትራክሽን','ንግዲ','ግልጋሎት','ገባር','ተምሃሮ','መምህራን','ሲ/ሰርቫንት','ሸቃሎ']) === false)
                $problems .= "ተ.ቁ " . $cnt . " ዓይነት መሰረታዊ ውዳበ ትኽክል ኣይኮነን<br>";
            $cnt++;
        }
        if(strlen($problems)){
            $validator->errors()->add('duplicate', $problems);
            DB::rollBack();
            return redirect()->back()->withErrors($validator)->withInput();    
        }
        $cnt = 2;
        $flag = 0;
        DB::beginTransaction();
        foreach($data as $d){
            $t = [];
            for($i=0; $i<count($indices); $i++){
                $d[$i] = trim($d[$i]);
                if($indices[$i] == 'zone'){
                    if(Zobatat::where('zoneName', $d[$i])->count()){
                        $zonecode = Zobatat::where('zoneName', $d[$i])->pluck('zoneCode')->toArray()[0];
                        $t[$indices[$i]] = $zonecode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $cnt . " ዞባ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                        $flag = 1;
                    }
                }
                else if($indices[$i] == 'woreda'){
                    if(Woreda::where('zoneCode', $zonecode)->where('name', $d[$i])->count()){
                        $woredacode = Woreda::where('zoneCode', $zonecode)->where('name', $d[$i])->pluck('woredacode')->toArray()[0];
                        $t[$indices[$i]] = $woredacode;
                    }
                    else{
                        $dataworeda = new Woreda;
                        $dataworeda->zoneCode=$zonecode;
                        $dataworeda->name=$d[$i];
                        if(!Woreda::select('woredacode')/*->where('zoneCode', $request->zcode)*/->orderBy('woredacode','desc')->first()){
                            $dataworeda->woredacode = "001";
                        }
                        else{
                            // $dataworeda->woredacode = $this->adjust(Woreda::select('woredacode')/*->where('zoneCode', $request->zcode)*/->orderBy('woredacode','desc')->first()->toArray()['woredacode']+1, 3);

                            $problems .= "ተ.ቁ " . $cnt . " ወረዳ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                            $flag = 1;
                        }
                        $dataworeda->isUrban='ከተማ';
                        $dataworeda->save ();
                        $woredacode = $dataworeda->woredacode;
                        $t[$indices[$i]] = $dataworeda->woredacode;
                    }
                }
                else if($indices[$i] == 'tabia'){
                    if(Tabia::where('woredacode', $woredacode)->where('tabiaName', $d[$i])->count()){
                        $tabiacode = Tabia::where('woredacode', $woredacode)->where('tabiaName', $d[$i])->pluck('tabiaCode')->toArray()[0];
                        $t[$indices[$i]] = $tabiacode;
                    }
                    else{
                        $dataTabia= new Tabia;
                        $dataTabia->woredacode=$woredacode;
                        $dataTabia->tabiaName=$d[$i];
                        if(!Tabia::select('tabiaCode')/*->where('woredacode', $request->wcode)*/->orderBy('tabiaCode','desc')->first()) {
                            $dataTabia->tabiaCode = "0001";
                        }
                        else{
                            $dataTabia->tabiaCode = $this->adjust(Tabia::select('tabiaCode')/*->where('woredacode', $request->wcode)*/->orderBy('tabiaCode','desc')->first()->toArray()['tabiaCode']+1, 4);
                        }
                        $dataTabia->isUrban='ገጠር';
                        $dataTabia->save();
                        $tabiacode = $dataTabia->tabiaCode;
                        $t[$indices[$i]] = $dataTabia->tabiaCode;
                    }
                }
                else if($indices[$i] == 'mwidabe'){
                    if(meseretawiWdabe::where('tabiacode', $tabiacode)->where('widabeName', $d[$i])->count()){
                        $problems .= "ተ.ቁ " . $cnt . " መሰረታዊ ውዳበ " . $d[$i] . " ኣብ መዝገብ ኣሎ እዩ<br>";
                    }
                    else{
                        $dataMwidabe= new meseretawiWdabe;
                        $dataMwidabe->tabiaCode=$tabiacode;       
                        $dataMwidabe->widabeName=$d[$i];
                        $dataMwidabe->type=trim($d[$i+1]);
                        $dataMwidabe->widabeCode = $this->adjust(meseretawiWdabe::select('widabeCode')/*->where('woredacode', $request->wcode)*/->orderBy('widabeCode','desc')->first()->toArray()['widabeCode']+1, 5);
                        $dataMwidabe->save();
                    }
                }
                // else if($indices[$i] == 'proposerWahio'){
                //     if(Wahio::where('widabeCode', $widabecode)->where('wahioName', $d[$i])->count()){
                //         $wahiocode = Wahio::where('widabeCode', $widabecode)->where('wahioName', $d[$i])->pluck('id')->toArray()[0];
                //         $t[$indices[$i]] = $wahiocode;
                //     }
                //     else{
                //         $problems .= "ተ.ቁ " . $d[0] . " ዝተወደበሉ ዋህዮ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                //     }
                // }
            }
            $cnt++;
            if($flag)
                break;
        }
        if(strlen($problems)){
            $validator->errors()->add('duplicate', $problems);
            DB::rollBack();
            return redirect()->back()->withErrors($validator)->withInput();    
        }


        //Import wahios
        $problems = "";
        $indices = ['zone','woreda','tabia','mwidabe', 'wahio', 'type'];
        $transformedData = [];
        $zonecode = "";
        $woredacode = "";
        $tabiacode = "";
        $widabecode = "";
        $wahiocode = "";
        $cnt = 2;
        foreach ($data_wahio as $d) {
            // ዓይነት ዋህዮ
            if(array_search(trim($d[5]), ['መፍረይቲ','ከተማ ሕርሻ','ኮንስትራክሽን','ንግዲ','ግልጋሎት','ሓረስታይ', 'ሸቃሎ', 'መናእሰይ', 'ደ/ኣንስትዮ', 'ተምሃሮ', 'መምህራን', 'ሲ/ሰርቫንት']) === false)
                $problems .= "ተ.ቁ " . $cnt . " ዓይነት ዋህዮ ትኽክል ኣይኮነን<br>";
            $cnt++;
        }
        if(strlen($problems)){
            $validator->errors()->add('duplicate', $problems);
            DB::rollBack();
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $cnt = 2;
        foreach($data_wahio as $d){
            $t = [];
            for($i=0; $i<count($indices); $i++){
                $d[$i] = trim($d[$i]);
                if($indices[$i] == 'zone'){
                    if(Zobatat::where('zoneName', $d[$i])->count()){
                        $zonecode = Zobatat::where('zoneName', $d[$i])->pluck('zoneCode')->toArray()[0];
                        $t[$indices[$i]] = $zonecode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $cnt . " ዞባ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                        $flag = 1;
                    }
                }
                else if($indices[$i] == 'woreda'){
                    if(Woreda::where('zoneCode', $zonecode)->where('name', $d[$i])->count()){
                        $woredacode = Woreda::where('zoneCode', $zonecode)->where('name', $d[$i])->pluck('woredacode')->toArray()[0];
                        $t[$indices[$i]] = $woredacode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $cnt . " ወረዳ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                        $flag = 1;
                    }
                }
                else if($indices[$i] == 'tabia'){
                    if(Tabia::where('woredacode', $woredacode)->where('tabiaName', $d[$i])->count()){
                        $tabiacode = Tabia::where('woredacode', $woredacode)->where('tabiaName', $d[$i])->pluck('tabiaCode')->toArray()[0];
                        $t[$indices[$i]] = $tabiacode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $cnt . " ጣብያ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                        $flag = 1;
                    }
                }
                else if($indices[$i] == 'mwidabe'){
                    if(meseretawiWdabe::where('tabiacode', $tabiacode)->where('widabeName', $d[$i])->count()){
                        $widabecode = meseretawiWdabe::where('tabiacode', $tabiacode)->where('widabeName', $d[$i])->pluck('widabeCode')->toArray()[0];
                        $t[$indices[$i]] = $widabecode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $cnt . " መሰረታዊ ውዳበ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                        $flag = 1;
                    }
                }
                else if($indices[$i] == 'wahio'){
                    if(Wahio::where('widabeCode', $widabecode)->where('wahioName', $d[$i])->count()){
                        $problems .= "ተ.ቁ " . $cnt . " ዋህዮ " . $d[$i] . " ኣብ መዝገብ ኣሎ እዩ<br>";
                    }
                    else{
                        $dataWahio= new Wahio ;
                        $dataWahio->wahioName=$d[$i];   
                        $dataWahio->widabeCode=$widabecode;
                        $dataWahio->type = trim($d[$i+1]);
                        $dataWahio->save();
                    }
                }
            }
            $cnt++;
            if($flag)
                break;
        }
        if(strlen($problems)){
            $validator->errors()->add('duplicate', $problems);
            DB::rollBack();
            return redirect()->back()->withErrors($validator)->withInput();
        }
        Toastr::info("ኤክሴል ብትኽክል ናብ ዳታ ቤዝ ኣትዩ ኣሎ");
        DB::commit();
        return back();
    }
}
