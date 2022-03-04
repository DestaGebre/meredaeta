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

class ImportExcel extends Controller
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

    public function index()
    {
        //
        // $xlsx = new XLSXReader('excel.xlsx');
        // $data = $xlsx->getSheetData('Sheet1');
        return view ('import');
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
        $data = $xlsx->getSheetData('Sheet1');
        $xlsx->close();
        unlink(public_path($new_name));
        $problems = "";
        $data = array_slice($data, 1, 50);
        $indices = ['number','name','fname','gfname','gender','dob','educationlevel','skill','regDate','birthPlace','occupation','leadership', 'mwleadership', 'zone','woreda','tabiaID','proposerWidabe','proposerWahio', 'mahber', 'netsalary', 'tell'];
        $transformedData = [];
        $zonecode = "";
        $woredacode = "";
        $tabiacode = "";
        $widabecode = "";
        $wahiocode = "";
        foreach($data as $d){
            $t = [];
            for($i=0; $i<count($indices); $i++){
                if($indices[$i] == 'zone'){
                    if(Zobatat::where('zoneName', $d[$i])->count()){
                        $zonecode = Zobatat::where('zoneName', $d[$i])->pluck('zoneCode')->toArray()[0];
                        $t[$indices[$i]] = $zonecode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $d[0] . " ዞባ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                    }
                }
                else if($indices[$i] == 'woreda'){
                    if(Woreda::where('zoneCode', $zonecode)->where('name', $d[$i])->count()){
                        $woredacode = Woreda::where('zoneCode', $zonecode)->where('name', $d[$i])->pluck('woredacode')->toArray()[0];
                        $t[$indices[$i]] = $woredacode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $d[0] . " ወረዳ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                    }
                }
                else if($indices[$i] == 'tabiaID'){
                    if(Tabia::where('woredacode', $woredacode)->where('tabiaName', $d[$i])->count()){
                        $tabiacode = Tabia::where('woredacode', $woredacode)->where('tabiaName', $d[$i])->pluck('tabiaCode')->toArray()[0];
                        $t[$indices[$i]] = $tabiacode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $d[0] . " ጣብያ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                    }
                }
                else if($indices[$i] == 'proposerWidabe'){
                    if(meseretawiWdabe::where('tabiacode', $tabiacode)->where('widabeName', $d[$i])->count()){
                        $widabecode = meseretawiWdabe::where('tabiacode', $tabiacode)->where('widabeName', $d[$i])->pluck('widabeCode')->toArray()[0];
                        $t[$indices[$i]] = $widabecode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $d[0] . " ዝተወደበሉ መሰረታዊ ውዳበ" . $d[$i] . " ኣብ መዝገብ የለን<br>";
                    }
                }
                else if($indices[$i] == 'proposerWahio'){
                    if(Wahio::where('widabeCode', $widabecode)->where('wahioName', $d[$i])->count()){
                        $wahiocode = Wahio::where('widabeCode', $widabecode)->where('wahioName', $d[$i])->pluck('id')->toArray()[0];
                        $t[$indices[$i]] = $wahiocode;
                    }
                    else{
                        $problems .= "ተ.ቁ " . $d[0] . " ዝተወደበሉ ዋህዮ " . $d[$i] . " ኣብ መዝገብ የለን<br>";
                    }
                }
                else{
                    $t[$indices[$i]] = $d[$i];
                }
            }
            $transformedData[] = $t;
        }
        if(strlen($problems)){
            $validator->errors()->add('duplicate', $problems);
            return redirect()->back()->withErrors($validator)->withInput();    
        }
        $data = $transformedData;
        $c = 0;
        foreach($data as $d){
            if(!$d['tell']){
                $d['tell'] = '';
            }
            else if(strlen($d['tell']) == 9){
                $d['tell'] = '0' . $d['tell'];
            }
            if(!$d['mahber']){
                $d['mahber'] = '';
            }
            if(!$d['netsalary']){
                $d['netsalary'] = '';
            }
            if(!$d['gfname']){
                $d['gfname'] = '';
            }
            $d['educationlevel'] = rtrim($d['educationlevel'], 'ይ');
            if(strlen($d['regDate']) < 10){
                $q = explode("/", $d['regDate']);
                if(count($q) == 3){
                    if(strlen($q[2]) == 2){
                        if($q[2]>12){
                            $q[2] = '19' . $q[2];
                        }
                        else{
                            $q[2] = '20' . $q[2];
                        }
                    }
                    $d['regDate'] = (strlen($q[1])==2?$q[1]:'0'.$q[1]) .'/'. (strlen($q[0])==2?$q[0]:'0'.$q[0]) .'/'. $q[2];
                }
            }
            if(strlen($d['dob']) < 10){
                $q = explode("/", $d['dob']);
                if(count($q) == 3){
                    if(strlen($q[2]) == 2){
                        if($q[2]>20){
                            $q[2] = '19' . $q[2];
                        }
                        else{
                            $q[2] = '20' . $q[2];
                        }
                    }
                    $d['dob'] = (strlen($q[1])==2?$q[1]:'0'.$q[1]) .'/'. (strlen($q[0])==2?$q[0]:'0'.$q[0]) .'/'. $q[2];
                }
            }
            // var_dump($d);
            if(!$d['mwleadership']){
                $d['mwleadership'] = '';
            }
            $messages = [
                'after'      => "ተ.ቁ " . $d['number'] . ' | ' . 'ዕለት ትውልዲ ዕለት ካብ ኣባልነት ዘመን ክቕድም ኣለዎ',
                'required' => "ተ.ቁ " . $d['number'] . ' | ' . ':attribute ብትኽክል ኣይኣተወን',
                'alpha' => "ተ.ቁ " . $d['number'] . ' | ' . ':attribute ፊደላት ጥራሕ ክኸውን ኣለዎ',
                'in' => "ተ.ቁ " . $d['number'] . ' | ' . ':attribute ካብቶም ዘለዉ መማረፅታት ክኸውን ኣለዎ',
                'ethiopian_date' => "ተ.ቁ " . $d['number'] . ' | ' . ':attribute: መዓልቲ/ወርሒ/ዓመተምህረት ክኸውን ኣለዎ',
                'digits' => "ተ.ቁ " . $d['number'] . ' | ' . 'ቑፅሪ ስልኪ 10 ድጂት ክኸውን ኣለዎ',
                'numeric' => "ተ.ቁ " . $d['number'] . ' | ' . ' :attribute ቑፅሪ ክኸውን ኣለዎ'

            ];
            $validator = \Validator::make($d,[
            'name' => 'required',            
            'fname' => 'required',
            // 'gfname' => 'required',
            'gender' => 'required|in:ተባ,ኣን', 
            'birthPlace' => 'required',            
            'occupation' => 'required|in:መምህራን,ተምሃሮ,ሰብ ሞያ,መፍረይቲ,ንግዲ,ግልጋሎት,ኮስንትራክሽን,ከተማ ሕርሻ,ሸቃሎ,ገባር',
            // 'position' => 'required|alpha',
            // 'fileNumber' => 'required', 
            //'address' => 'required|alpha_num',                         
            'tell' => 'digits:10',
            'dob' => 'required|ethiopian_date',
            'regDate' => 'required|ethiopian_date',
            'proposerWahio' => 'required',
            'leadership' => 'required|in:ተራ ኣባል,ጀማሪ ኣመራርሓ,ማእኸላይ ኣመራርሓ,ላዕለዋይ ኣመራርሓ,ታሕተዋይ ኣመራርሓ',
            'mwleadership' => 'in:መ/ዉ/ኣመራርሓ,ዋህዮ ኣመራርሓ,ዞባ ኣመራርሓ, ወረዳ ኣመራርሓ',
           // 'mahber' => 'in:ደቂ ኣንስትዮ,መንእሰይ,ሓረስታይ,መምህራን',
            'netsalary' => 'numeric',
            'educationlevel' => 'required|in:ዘይተምሃረ,ቀለም,1,2,3,4,5,6,7,8,9,10,11,12,ሰርቲፊኬት,ዲፕሎማ,ዲግሪ,ማስተርስ,ፒ.ኤች.ዲ'

            ],$messages);
            $fieldNames = [
            'name' => 'ሽም',            
            'fname' => 'ሽም ኣቦ',
            'gfname' => 'ሽም ኣቦሓጎ',
            'gender' => 'ፆታ', 
            'birthPlace' => 'ትውልዲ ቦታ',            
            'occupation' => 'ማሕበራው መሰረት',
            'position' => 'ሓላፍነት',
            'fileNumber' => 'ቑፅሪ ፋይል', 
            //'address' => 'required|alpha_num',                         
            'tell' => 'ቑፅሪ ስልኪ',
            'email' => 'ኢሜይል',
            'dob' => 'ዕለት ትውልዲ',
            'regDate' => 'ኣባልነት ዘመን',
            'proposerWahio' => 'ዋህዮ',
            'leadership' => 'ኩነታት መሪሕነት',
            'mwleadership' => 'ኩነታት መሪሕነት ዋህዮ/መሰረታዊ ውዳበ/',
            'mahber' => 'ዝተወደበሉ ማሕበር',
            'netsalary' => 'ዝተፃረየ ደሞዝ',
            'educationlevel' => 'ደረጃ ትምህርቲ'
            ];
            $validator->setAttributeNames($fieldNames);
            if($validator->fails()){
                // DB::rollBack();
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $validator->validate();
            if($d['occupation']=='መምህር'||$d['occupation']=='ሰብ ሞያ'){
                if(!$d['netsalary']){
                    $validator->errors()->add('duplicate', "ተ.ቁ " . $d['number'] . ' | ' . ' ዝተፃረየ ደሞዝ ኣይተመልአን');
                    // DB::rollBack();
                    return redirect()->back()->withErrors($validator)->withInput();
                }
            }
            $data[$c] = $d;
            $c++;
        }
        DB::beginTransaction();
        foreach($data as $d){
            // $d['dob'] = DateConvert::toGregorian($d['dob']);
            // $d['regDate'] = DateConvert::toGregorian($d['regDate']);
            $zoneCode = $d['zone'];
            $worCode = $d['woreda'];
            $tabCode = $d['tabiaID'];
            $zwtCode="$zoneCode$worCode$tabCode"; //this should be tabiaCode??should be set,
            $lastHitsuy = Hitsuy::where('hitsuyID','LIKE',$zwtCode.'%')->max('hitsuyID');
            if($lastHitsuy){ //if there is last Hitsuy            
                $mID = substr($lastHitsuy,10,6); //starting at 7th and length 3
                $lastID=sprintf('%06d', intval($mID) + 1);
                $finalID="$zwtCode/".$lastID;//."/".$year;
            }else{
                $finalID="$zwtCode/000001";//.$year;
            }

            if(Hitsuy::where('name', $d['name'])->where('fname', $d['fname'])->where('gfname', $d['gfname'])->where('birthPlace', $d['birthPlace'])->where('dob', DateConvert::correctDate($d['dob']))->where('regDate', DateConvert::correctDate($d['regDate']))->get()){
                
                $problems .= "[ተደጊሙ ዝኣተወ] ተ.ቁ " . $d['number'] . " ኣብ መዝገብ ኣሎ እዩ<br>";
                DB::rollBack();
                $validator->errors()->add('duplicate', $problems);
                return redirect()->back()->withErrors($validator)->withInput();
            }


            $newMem = new Hitsuy;
            $newMem->hitsuyID = $finalID;
            $newMem->name = $d['name'];
            $newMem->fname = $d['fname'];
            $newMem->gfname = $d['gfname'];
            $newMem->gender = $d['gender'];
            $newMem->birthPlace = $d['birthPlace'];
            $newMem->dob = DateConvert::correctDate($d['dob']);
            $newMem->occupation = $d['occupation'];
			$newMem->sme = "";
            // $newMem->position = $d->position;
            $newMem->position = "";
            $newMem->regDate = DateConvert::correctDate($d['regDate']);
            $newMem->proposerWidabe = $d['proposerWidabe'];
            $newMem->proposerWahio = $d['proposerWahio'];
            $newMem->proposerMem = "";
            $newMem->fileNumber = "";
            $newMem->region = 'ትግራይ';
            $newMem->tabiaID = $d['tabiaID'];
            $newMem->address = "";
            $newMem->tell = $d['tell'];
            $newMem->email = "";
            $newMem->isRequested = "1";       
            $newMem->hasPermission = "1";
            $newMem->isWilling = "1";
            $newMem->isReportedWahioHalafi = "1";
            $newMem->isReportedWahioMem = "1";
            $newMem->educationlevel = $d['educationlevel'];
            $newMem->skill = $d['skill'];
            $newMem->hitsuy_status = 'ኣባል';
            $newMem->save();   



            $apprMem = new ApprovedHitsuy;
            $apprMem->hitsuyID = $finalID;
            $apprMem->membershipDate = DateConvert::correctDate($d['regDate']);
            $apprMem->membershipType = 'ሲቪል';
            $apprMem->gender = $d['gender'];
            $apprMem->occupation = $d['occupation'];


            // if($d['occupation']=="ምሁር"||$d['occupation']=="መምህር"){
            //     $apprMem->memberType = "ሰብ ሞያ";
            // }
            $apprMem->memberType = $d['leadership'];
            if($d['mwleadership'] == 'መ/ዉ/ኣመራርሓ')
                $apprMem->meseratawiposition = 'መ/ዉ/ኣመራርሓ';
            if($d['mwleadership'] == 'ዋህዮ ኣመራርሓ')
                $apprMem->wahioposition = 'ዋህዮ ኣመራርሓ';
            $zoneworedaCodeVal = substr($finalID,0,9);
            // $zoneworedaCodeVal=intval($zoneworedaCodeVal);

            $apprMem->zoneworedaCode = $zoneworedaCodeVal;
            $apprMem->grossSalary = 0;
            if($d['occupation']=='መምህር'||$d['occupation']=='ሲቪል ሰርቫንት'){
                $apprMem->netSalary = $d['netsalary'];
            }
            else{
                $apprMem->netSalary = 0;
            }
            $apprMem->assignedWudabe = $d['proposerWidabe'];
            $apprMem->wudabeType = meseretawiWdabe::where('widabeCode', $d['proposerWidabe'])->pluck('type')->first();
            $apprMem->assignedWahio = $d['proposerWahio'];
            $apprMem->assignedAssoc = $d['mahber'];
            $apprMem->fileNumber = "";
            $apprMem->isReported = "1";
            $apprMem->hasRequested = "1";
            $apprMem->isApproved = "1";
            $apprMem->save();   
        }
        DB::commit();
        Toastr::info("ኤክሴል ብትኽክል ናብ ዳታ ቤዝ ኣትዩ ኣሎ");
        return back();
    }
}
